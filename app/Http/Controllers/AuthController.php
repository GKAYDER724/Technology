<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PasswordOtp;
use App\Mail\ForgotPasswordOtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{

    /**
     * Hiển thị trang đăng nhập.
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect('/');
        }

        return view('auth.login');
    }



    /**
     * Xử lý đăng nhập.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([

            'email' => [
                'required',
                'email'
            ],

            'password' => [
                'required',
                'string'
            ],

        ], [

            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không đúng định dạng.',
            'password.required' => 'Vui lòng nhập mật khẩu.',

        ]);


        $remember = $request->boolean('remember');


        if (Auth::attempt($credentials, $remember)) {

            $request->session()->regenerate();

            return redirect()->intended('/');

        }


        return back()
            ->withErrors([

                'email' => 'Email hoặc mật khẩu không chính xác.',

            ])
            ->onlyInput('email');
    }





    /**
     * Hiển thị trang đăng ký.
     */
    public function showRegister()
    {
        if (Auth::check()) {
            return redirect('/');
        }

        return view('auth.register');
    }





    /**
     * Xử lý đăng ký tài khoản.
     */
    public function register(Request $request)
    {

        $validated = $request->validate([

            'name' => [
                'required',
                'string',
                'max:255'
            ],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'password' => [
                'required',
                'confirmed',
                Password::min(8),
            ],

        ], [

            'name.required' => 'Vui lòng nhập họ và tên.',
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không hợp lệ.',
            'email.unique' => 'Email này đã được đăng ký.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp.',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',

        ]);



        $user = User::create([

            'role_id' => 3,
            'fullname' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'status' => 'active',

        ]);



        Auth::login($user);

        $request->session()->regenerate();



        return redirect('/')
            ->with(
                'success',
                'Đăng ký tài khoản thành công!'
            );

    }





    /**
     * Gửi mã OTP quên mật khẩu.
     */
    public function sendOtp(Request $request)
    {

        $request->validate([

            'email' => [
                'required',
                'email'
            ],

        ], [

            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không hợp lệ.',

        ]);



        $user = User::where(
            'email',
            $request->email
        )->first();



        if (!$user) {

            return back()->withErrors([

                'email' => 'Email này chưa được đăng ký.'

            ]);

        }



        // Hủy toàn bộ OTP cũ
        PasswordOtp::where(
            'email',
            $request->email
        )
        ->where(
            'used',
            false
        )
        ->update([

            'used' => true

        ]);



        // Tạo OTP mới
        $otp = random_int(100000, 999999);



        PasswordOtp::create([

            'email' => $request->email,

            'otp' => $otp,

            'expires_at' => now()->addMinutes(5),

            'used' => false,

        ]);



        Mail::to($request->email)
            ->send(
                new ForgotPasswordOtpMail($otp)
            );



        $request->session()->put(
            'email',
            $request->email
        );



        return redirect()

            ->route('password.verifyOtp')

            ->with(
                'success',
                'Mã OTP đã được gửi vào email của bạn.'
            );

    }
    /**
     * Gửi lại OTP.
     */
    public function resendOtp(Request $request)
    {

        $email = session('email');



        if (!$email) {

            return redirect()

                ->route('password.request')

                ->withErrors([

                    'email' => 'Không tìm thấy email cần khôi phục.'

                ]);

        }




        $user = User::where(
            'email',
            $email
        )->first();




        if (!$user) {

            return back()

                ->withErrors([

                    'otp' => 'Tài khoản không tồn tại.'

                ]);

        }




        // Hủy toàn bộ OTP cũ
        PasswordOtp::where(
            'email',
            $email
        )
        ->where(
            'used',
            false
        )
        ->update([

            'used' => true

        ]);




        // Tạo OTP mới
        $otp = random_int(100000, 999999);




        PasswordOtp::create([

            'email' => $email,

            'otp' => $otp,

            'expires_at' => now()->addMinutes(5),

            'used' => false,

        ]);




        Mail::to($email)

            ->send(

                new ForgotPasswordOtpMail($otp)

            );





        return back()

            ->with(

                'success',

                'Mã OTP mới đã được gửi lại.'

            );

    }






    /**
     * Xác nhận OTP.
     */
    public function verifyOtp(Request $request)
    {

        $request->validate([

            'otp' => [

                'required',

                'digits:6'

            ],

        ], [

            'otp.required' => 'Vui lòng nhập mã OTP.',

            'otp.digits' => 'Mã OTP phải gồm 6 chữ số.',

        ]);





        $email = session('email');




        if (!$email) {


            return redirect()

                ->route('password.request')

                ->withErrors([

                    'email' => 'Phiên xác thực đã hết hạn.'

                ]);

        }





        // Kiểm tra OTP mới nhất của email
        $otp = PasswordOtp::where(

                'email',

                $email

            )

            ->where(

                'otp',

                $request->otp

            )

            ->where(

                'used',

                false

            )

            ->where(

                'expires_at',

                '>',

                now()

            )

            ->latest()

            ->first();






        if (!$otp) {


            return back()

                ->withErrors([

                    'otp' => 'Mã OTP không đúng hoặc đã hết hạn.'

                ]);

        }






        // Lưu email để đổi mật khẩu
        $request->session()->put(

            'reset_password_email',

            $email

        );





        return redirect()

            ->route('password.reset')

            ->with(

                'success',

                'Xác nhận OTP thành công!'

            );

    }
    /**
     * Đặt lại mật khẩu.
     */
    public function resetPassword(Request $request)
    {

        $request->validate([

            'password' => [

                'required',

                'confirmed',

                Password::min(8),

            ],

        ], [

            'password.required' => 'Vui lòng nhập mật khẩu mới.',

            'password.confirmed' => 'Mật khẩu xác nhận không khớp.',

            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',

        ]);





        $email = $request->session()

            ->get('reset_password_email');





        if (!$email) {


            return redirect()

                ->route('password.request')

                ->withErrors([

                    'email' => 'Phiên đặt lại mật khẩu đã hết hạn.'

                ]);

        }





        $user = User::where(

            'email',

            $email

        )->first();





        if (!$user) {


            return redirect()

                ->route('password.request')

                ->withErrors([

                    'email' => 'Không tìm thấy tài khoản.'

                ]);

        }





        // Không cho mật khẩu mới trùng mật khẩu cũ
        if (Hash::check(

            $request->password,

            $user->password

        )) {


            return back()

                ->withErrors([

                    'password' => 'Mật khẩu mới không được trùng với mật khẩu hiện tại.'

                ]);

        }





        // Đổi mật khẩu
        $user->update([

            'password' => Hash::make(

                $request->password

            ),

        ]);





        // Đánh dấu OTP hiện tại đã sử dụng
        PasswordOtp::where(

            'email',

            $email

        )

        ->where(

            'used',

            false

        )

        ->update([

            'used' => true

        ]);





        // Xóa session khôi phục
        $request->session()->forget([

            'reset_password_email',

            'email'

        ]);





        return redirect()

            ->route('login')

            ->with(

                'success',

                'Đổi mật khẩu thành công. Vui lòng đăng nhập lại.'

            );

    }






    /**
     * Đăng xuất.
     */
    public function logout(Request $request)
    {

        Auth::logout();



        $request->session()->invalidate();



        $request->session()->regenerateToken();




        return redirect('/login')

            ->with(

                'success',

                'Bạn đã đăng xuất thành công.'

            );

    }

}