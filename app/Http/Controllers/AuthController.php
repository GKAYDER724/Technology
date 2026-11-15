<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
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
            'name' => ['required', 'string', 'max:255'],
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
            ->with('success', 'Đăng ký tài khoản thành công!');
    }

    /**
     * Xử lý đăng xuất.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')
            ->with('success', 'Bạn đã đăng xuất thành công.');
    }
}
