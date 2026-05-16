<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class PasswordResetController extends Controller
{
    // Hiện form nhập email
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    // Gửi mã OTP qua email
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.exists' => 'Email này chưa được đăng ký tài khoản.',
        ]);

        // Tạo mã OTP 6 số
        $otp = rand(100000, 999999);

        // Lưu OTP vào bảng password_reset_tokens
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token'      => Hash::make($otp),
                'created_at' => now(),
            ]
        );

        // Gửi email chứa mã OTP
        Mail::send([], [], function ($message) use ($request, $otp) {
            $message->to($request->email)
                    ->subject('Mã xác nhận đặt lại mật khẩu - Fashion AI')
                    ->html('
                        <div style="font-family: Arial, sans-serif; max-width: 500px; margin: 0 auto; padding: 30px; background: #fff; border-radius: 12px; border: 1px solid #eee;">
                            <h2 style="text-align: center; color: #333; margin-bottom: 10px;">FASHION AI</h2>
                            <p style="text-align: center; color: #999; font-size: 14px; margin-bottom: 25px;">Đặt lại mật khẩu</p>
                            <p style="color: #555; font-size: 14px; line-height: 1.6;">Xin chào,</p>
                            <p style="color: #555; font-size: 14px; line-height: 1.6;">Bạn đã yêu cầu đặt lại mật khẩu. Đây là mã xác nhận của bạn:</p>
                            <div style="text-align: center; margin: 25px 0;">
                                <span style="display: inline-block; padding: 15px 40px; background: #222; color: #fff; font-size: 28px; font-weight: 700; letter-spacing: 8px; border-radius: 10px;">' . $otp . '</span>
                            </div>
                            <p style="color: #999; font-size: 13px; text-align: center;">Mã có hiệu lực trong 10 phút.</p>
                            <p style="color: #999; font-size: 13px; text-align: center; margin-top: 20px;">Nếu bạn không yêu cầu đặt lại mật khẩu, vui lòng bỏ qua email này.</p>
                        </div>
                    ');
        });

        // Lưu email vào session để dùng ở bước tiếp theo
        session(['reset_email' => $request->email]);

        return redirect()->route('password.showOtpForm')->with('success', 'Mã xác nhận đã được gửi đến email của bạn!');
    }

    // Hiện form nhập OTP
    public function showOtpForm()
    {
        if (!session('reset_email')) {
            return redirect()->route('password.forgot');
        }
        return view('auth.verify-otp');
    }

    // Xác nhận OTP
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp'   => 'required|digits:6',
        ]);

        $record = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$record) {
            return back()->with('error', 'Không tìm thấy yêu cầu đặt lại mật khẩu.');
        }

        // Kiểm tra OTP hết hạn (10 phút)
        if (now()->diffInMinutes($record->created_at) > 10) {
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            return back()->with('error', 'Mã xác nhận đã hết hạn. Vui lòng gửi lại.');
        }

        // Kiểm tra OTP đúng
        if (!Hash::check($request->otp, $record->token)) {
            return back()->with('error', 'Mã xác nhận không đúng.');
        }

        // OTP đúng → cho phép đặt lại mật khẩu
        session(['otp_verified' => true, 'reset_email' => $request->email]);

        return redirect()->route('password.showResetForm');
    }

    // Hiện form đặt lại mật khẩu
    public function showResetForm()
    {
        if (!session('otp_verified') || !session('reset_email')) {
            return redirect()->route('password.forgot');
        }
        return view('auth.reset-password');
    }

    // Đặt lại mật khẩu
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6|confirmed',
        ], [
            'password.min'       => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'Không tìm thấy tài khoản.');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        // Xóa token và session
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();
        session()->forget(['reset_email', 'otp_verified']);

        return redirect()->route('login')->with('success', 'Đặt lại mật khẩu thành công! Vui lòng đăng nhập.');
    }
}