<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AccountController
{
    // Xem hồ sơ người dùng đang đăng nhập
    public function profile(Request $request)
    {
        $user = $request->user();
        $cartCount = 0;

        return view('account.profile', [
            'user' => $user,
            'cartCount' => $cartCount,
        ]);
    }

    // Cập nhật hồ sơ cá nhân
    

public function update(Request $request)
{
    /** @var User $user */
    $user = $request->user();

    Gate::authorize('update', $user);

    // Chuẩn hóa dữ liệu nhập vào
    $request->merge([
        'fullname' => trim((string) $request->input('fullname', '')),
        'phone' => trim((string) $request->input('phone', '')),
        'address' => trim((string) $request->input('address', '')),
        'province_city' => trim((string) $request->input('province_city', '')),
    ]);

    // Laravel tự kiểm tra dữ liệu và trả lỗi về form nếu không hợp lệ
    
$validated = $request->validate([
    'fullname' => [
        'required',
        'string',
        'max:120',
        'regex:/^[\p{L}\p{M}]+(?:[[:space:]][\p{L}\p{M}]+)*$/u',
    ],

    'phone' => [
        'required',
        'string',
        'max:20',
        'regex:/^[0-9]{10,11}$/',
    ],

    'address' => [
        'required',
        'string',
        'max:500',
    ],

    'date_of_birth' => [
        'required',
        'date',
        'before_or_equal:today',
    ],

    'gender' => [
        'nullable',
        'in:male,female,other',
    ],

    'province_city' => [
        'required',
        'string',
        'max:120',
    ],
], [
    'fullname.required' => 'Vui lòng nhập họ và tên.',
    'fullname.max' => 'Họ và tên không được vượt quá 120 ký tự.',
    'fullname.regex' => 'Họ tên chỉ được chứa chữ cái và khoảng trắng.',

    'phone.required' => 'Vui lòng nhập số điện thoại.',
    'phone.max' => 'Số điện thoại không được vượt quá 20 ký tự.',
    'phone.regex' => 'Số điện thoại phải gồm 10–11 chữ số, không chứa chữ cái hoặc ký tự đặc biệt.',

    'address.required' => 'Vui lòng nhập địa chỉ.',
    'address.max' => 'Địa chỉ không được vượt quá 500 ký tự.',

    'date_of_birth.required' => 'Vui lòng chọn ngày sinh.',
    'date_of_birth.date' => 'Ngày sinh không hợp lệ.',
    'date_of_birth.before_or_equal' => 'Ngày sinh không được ở tương lai.',

    'gender.in' => 'Giới tính không hợp lệ.',

    'province_city.required' => 'Vui lòng chọn tỉnh/thành phố.',
    'province_city.max' => 'Tên tỉnh/thành phố không hợp lệ.',
]);

$user->update($validated);

return redirect()
    ->route('account.profile')
    ->with('success', 'Cập nhật hồ sơ thành công.');
}



    // Đổi mật khẩu người dùng đang đăng nhập
    public function changePassword(Request $request)
    {
        /** @var User $user */
        $user = $request->user();

        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'new_password' => ['required', 'string', 'min:6'],
            'confirm_password' => ['required', 'same:new_password'],
        ], [
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại.',
            'current_password.current_password' => 'Mật khẩu hiện tại không chính xác.',

            'new_password.required' => 'Vui lòng nhập mật khẩu mới.',
            'new_password.string' => 'Mật khẩu mới không hợp lệ.',
            'new_password.min' => 'Mật khẩu mới phải có ít nhất 6 ký tự.',

            'confirm_password.required' => 'Vui lòng xác nhận mật khẩu mới.',
            'confirm_password.same' => 'Mật khẩu xác nhận không khớp.',
        ]);

        // Gán mật khẩu mới; model cần có cast password => hashed
        $user->password = $validated['new_password'];
        $user->save();

        return redirect()
            ->route('account.profile')
            ->with('password_success', 'Đổi mật khẩu thành công.');
    }
}
