@component('mail::message')

# Khôi phục mật khẩu ElectroTech

Xin chào,

Bạn vừa yêu cầu đặt lại mật khẩu cho tài khoản ElectroTech.

Mã OTP của bạn là:

@component('mail::panel')
{{ $otp }}
@endcomponent

Mã này có hiệu lực trong **5 phút**.

Nếu bạn không thực hiện yêu cầu này, vui lòng bỏ qua email này.

Trân trọng,  
Đội ngũ ElectroTech

@endcomponent