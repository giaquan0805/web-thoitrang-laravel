<?php

namespace App\Http\Controllers;

use App\Models\AiTryonHistory;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

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

        // Đọc ảnh user thành base64
        $userImageBase64 = base64_encode(file_get_contents(storage_path('app/public/' . $userImagePath)));
        $userMimeType = $request->file('user_image')->getMimeType();

        // Đọc ảnh sản phẩm thành base64
        $productImagePath = $product->thumbnail_url;
        if (file_exists(public_path('storage/' . $productImagePath))) {
            $productImageBase64 = base64_encode(file_get_contents(public_path('storage/' . $productImagePath)));
        } elseif (file_exists(public_path($productImagePath))) {
            $productImageBase64 = base64_encode(file_get_contents(public_path($productImagePath)));
        } else {
            return back()->with('error', 'Không tìm thấy ảnh sản phẩm!');
        }

        try {
            $apiKey = env('OPENROUTER_API_KEY');

            if (!$apiKey) {
                return back()->with('error', 'Chưa cấu hình OpenRouter API Key! Vui lòng thêm OPENROUTER_API_KEY vào file .env');
            }

            // Gọi OpenRouter API với Nano Banana
            $response = Http::timeout(120)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Content-Type' => 'application/json',
                    'HTTP-Referer' => url('/'),
                    'X-Title' => 'Fashion AI - Virtual Try-On',
                ])
                ->post('https://openrouter.ai/api/v1/chat/completions', [
                    'model' => 'google/gemini-2.5-flash-image',
                    'messages' => [
                        [
                            'role' => 'user',
                            'content' => [
                                [
                                    'type' => 'text',
                                    'text' => 'Take the person in the first image and dress them in the clothing/accessory item shown in the second image. Generate a realistic photo of the person wearing that exact item. Keep the person\'s face, body shape, pose, and background the same. Only change their clothing/accessory to match the item in the second image. Make it look natural and realistic.'
                                ],
                                [
                                    'type' => 'image_url',
                                    'image_url' => [
                                        'url' => 'data:' . $userMimeType . ';base64,' . $userImageBase64
                                    ]
                                ],
                                [
                                    'type' => 'image_url',
                                    'image_url' => [
                                        'url' => 'data:image/jpeg;base64,' . $productImageBase64
                                    ]
                                ]
                            ]
                        ]
                    ],
                ]);

            $result = $response->json();

            // Tìm ảnh trong response
            $resultImageUrl = null;
            $resultFileName = null;

            // Cách 1: Ảnh nằm trong message.images (OpenRouter + Gemini)
            if (isset($result['choices'][0]['message']['images'])) {
                foreach ($result['choices'][0]['message']['images'] as $img) {
                    if (isset($img['image_url']['url']) && str_starts_with($img['image_url']['url'], 'data:')) {
                        $imageDataUrl = $img['image_url']['url'];
                        $base64Data = preg_replace('/^data:image\/\w+;base64,/', '', $imageDataUrl);
                        $imageData = base64_decode($base64Data);
                        $resultFileName = 'tryon-results/' . uniqid('result_') . '.png';
                        Storage::disk('public')->put($resultFileName, $imageData);
                        $resultImageUrl = asset('storage/' . $resultFileName);
                        break;
                    }
                }
            }

            // Cách 2: Ảnh nằm trong message.content (array)
            if (!$resultImageUrl && isset($result['choices'][0]['message']['content'])) {
                $content = $result['choices'][0]['message']['content'];
                if (is_array($content)) {
                    foreach ($content as $part) {
                        if (isset($part['type']) && $part['type'] === 'image_url') {
                            $imageDataUrl = $part['image_url']['url'] ?? null;
                            if ($imageDataUrl && str_starts_with($imageDataUrl, 'data:')) {
                                $base64Data = preg_replace('/^data:image\/\w+;base64,/', '', $imageDataUrl);
                                $imageData = base64_decode($base64Data);
                                $resultFileName = 'tryon-results/' . uniqid('result_') . '.png';
                                Storage::disk('public')->put($resultFileName, $imageData);
                                $resultImageUrl = asset('storage/' . $resultFileName);
                                break;
                            }
                        }
                    }
                }
            }

            if ($resultImageUrl) {
                // Lưu lịch sử
                AiTryonHistory::create([
                    'user_id'                 => Auth::id(),
                    'product_id'              => $product->id,
                    'user_uploaded_image_url'  => $userImagePath,
                    'result_image_url'        => $resultFileName,
                ]);

                $userImageUrl = asset('storage/' . $userImagePath);
                return view('ai-tryon.result', compact('product', 'resultImageUrl', 'userImageUrl'));
            }

            // Debug lỗi
            $errorMsg = 'AI không thể tạo ảnh thử đồ.';
            if (isset($result['error']['message'])) {
                $errorMsg .= ' Lỗi: ' . $result['error']['message'];
            } elseif (isset($result['choices'][0]['message']['content']) && is_string($result['choices'][0]['message']['content'])) {
                $errorMsg .= ' AI phản hồi: ' . substr($result['choices'][0]['message']['content'], 0, 200);
            }

            return back()->with('error', $errorMsg);

        } catch (\Exception $e) {
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
}