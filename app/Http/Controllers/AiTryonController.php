<?php

namespace App\Http\Controllers;

use App\Models\AiTryonHistory;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;

class AiTryonController extends Controller
{
    public function index($productId)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để sử dụng tính năng thử đồ AI!');
        }

        $product = Product::findOrFail($productId);
        return view('ai-tryon.index', compact('product'));
    }

    public function process(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'user_image' => 'required|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $product = Product::findOrFail($request->product_id);

        // Lưu ảnh user upload
        $userImagePath = $request->file('user_image')->store('tryon-uploads', 'public');
        $userImageUrl  = url('storage/' . $userImagePath);

        // Lấy ảnh sản phẩm
        $garmentImageUrl = $product->ai_clean_image_url
            ? url('storage/' . $product->ai_clean_image_url)
            : url(product_image($product->thumbnail_url));

        try {
            $client = new Client();

            // Gọi Replicate API
            $response = $client->post('https://api.replicate.com/v1/predictions', [
                'headers' => [
                    'Authorization' => 'Bearer ' . env('REPLICATE_API_TOKEN'),
                    'Content-Type'  => 'application/json',
                    'Prefer'        => 'wait',
                ],
                'json' => [
                    'version' => 'c871bb9b046607b680449ecbae55fd8c6d945e0a1948644bf2361b3d021d3ff4',
                    'input'   => [
                        'human_img'       => $userImageUrl,
                        'garm_img'        => $garmentImageUrl,
                        'garment_des'     => $product->name,
                        'is_checked'      => true,
                        'is_checked_crop' => false,
                        'denoise_steps'   => 30,
                        'seed'            => 42,
                    ]
                ]
            ]);

            $result = json_decode($response->getBody(), true);

            if (isset($result['output']) && !empty($result['output'])) {
                $resultImageUrl = is_array($result['output']) ? $result['output'][0] : $result['output'];

                // Lưu lịch sử
                AiTryonHistory::create([
                    'user_id'                 => Auth::id(),
                    'product_id'              => $product->id,
                    'user_uploaded_image_url' => $userImagePath,
                    'result_image_url'        => $resultImageUrl,
                ]);

                return view('ai-tryon.result', compact('product', 'resultImageUrl', 'userImageUrl'));
            }

            return back()->with('error', 'AI xử lý thất bại, vui lòng thử lại!');

        } catch (\Exception $e) {
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
}