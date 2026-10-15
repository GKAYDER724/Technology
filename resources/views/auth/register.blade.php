@extends('layouts.app')

@section('title', 'Đăng ký tài khoản | ElectroTech')

@section('content')
<div class="et-auth-page et-auth-register-page">
    <div class="et-auth-shell">
        <aside class="et-auth-visual">
            <a href="{{ url('/') }}" class="et-auth-brand"><span class="et-auth-brand-icon"><i class="bi bi-lightning-charge-fill"></i></span><span>Electro<span>Tech</span></span></a>
            <div class="et-auth-visual-copy">
                <span class="et-auth-kicker">JOIN THE ELECTROTECH COMMUNITY</span>
                <h1>Khám phá công nghệ.<br><span>Bắt đầu từ hôm nay.</span></h1>
                <p>Tạo tài khoản ElectroTech để quản lý đơn hàng, lưu sản phẩm yêu thích và cập nhật ưu đãi mới nhất.</p>
                <div class="et-auth-benefits">
                    <div><i class="bi bi-person-check"></i><span>Tài khoản cá nhân của bạn</span></div>
                    <div><i class="bi bi-box-seam"></i><span>Quản lý lịch sử mua hàng</span></div>
                    <div><i class="bi bi-gift"></i><span>Cập nhật ưu đãi thành viên</span></div>
                </div>
            </div>
            <div class="et-auth-visual-footer"><span><i class="bi bi-patch-check-fill"></i> Đồng hành cùng công nghệ</span><span>ElectroTech © {{ date('Y') }}</span></div>
        </aside>

        <section class="et-auth-form-panel">
            <a href="{{ url('/') }}" class="et-auth-mobile-brand"><span class="et-auth-brand-icon"><i class="bi bi-lightning-charge-fill"></i></span><strong>Electro<span>Tech</span></strong></a>
            <div class="et-auth-form-wrap">
                <div class="et-auth-heading"><span class="et-auth-kicker">TẠO TÀI KHOẢN MIỄN PHÍ</span><h2>Đăng ký</h2><p>Điền thông tin bên dưới để trở thành thành viên ElectroTech.</p></div>
                @if ($errors->any())
                    <div class="et-auth-alert et-auth-alert-error"><i class="bi bi-exclamation-circle"></i><div><strong>Vui lòng kiểm tra lại thông tin</strong><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div></div>
                @endif
                <form method="POST" action="{{ route('register') }}" class="et-auth-form">
                    @csrf
                    <div class="et-auth-field"><label for="name">Họ và tên</label><div class="et-auth-input-wrap"><i class="bi bi-person"></i><input id="name" type="text" name="name" value="{{ old('name') }}" placeholder="Nguyễn Văn An" autocomplete="name" maxlength="100" required autofocus></div>@error('name')<small class="et-auth-field-error">{{ $message }}</small>@enderror</div>
                    <div class="et-auth-field"><label for="email">Địa chỉ email</label><div class="et-auth-input-wrap"><i class="bi bi-envelope"></i><input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" autocomplete="email" required></div>@error('email')<small class="et-auth-field-error">{{ $message }}</small>@enderror</div>
                    <div class="et-auth-field">
                        <label for="password">Mật khẩu</label>
                        <div class="et-auth-input-wrap"><i class="bi bi-lock"></i><input id="password" type="password" name="password" placeholder="Tối thiểu 8 ký tự" autocomplete="new-password" minlength="8" required><button type="button" class="et-auth-toggle-password" data-password-toggle="password" aria-label="Hiện mật khẩu"><i class="bi bi-eye"></i></button></div>
                        <div class="et-auth-password-meter"><span class="et-auth-meter-bars"><i></i><i></i><i></i><i></i></span><small id="etPasswordHint">Sử dụng ít nhất 8 ký tự.</small></div>
                        @error('password')<small class="et-auth-field-error">{{ $message }}</small>@enderror
                    </div>
                    <div class="et-auth-field"><label for="password_confirmation">Xác nhận mật khẩu</label><div class="et-auth-input-wrap"><i class="bi bi-shield-lock"></i><input id="password_confirmation" type="password" name="password_confirmation" placeholder="Nhập lại mật khẩu" autocomplete="new-password" minlength="8" required><button type="button" class="et-auth-toggle-password" data-password-toggle="password_confirmation" aria-label="Hiện mật khẩu xác nhận"><i class="bi bi-eye"></i></button></div><small class="et-auth-field-error" id="etPasswordMatchError" hidden>Mật khẩu xác nhận chưa khớp.</small></div>
                    <label class="et-auth-checkbox et-auth-terms"><input type="checkbox" name="terms" value="1" required><span>Tôi đồng ý với <a href="{{ url('/privacy-policy') }}" target="_blank" rel="noopener">chính sách bảo mật</a> và điều khoản sử dụng của ElectroTech.</span></label>
                    <button type="submit" class="et-auth-submit">Tạo tài khoản <i class="bi bi-arrow-right"></i></button>
                </form>
                <div class="et-auth-switch">Bạn đã có tài khoản? <a href="{{ route('login') }}">Đăng nhập ngay</a></div>
                <div class="et-auth-secure"><i class="bi bi-shield-lock"></i> Thông tin của bạn được sử dụng để quản lý tài khoản</div>
            </div>
        </section>
    </div>
</div>
<script src="{{ asset('js/auth.js') }}" defer></script>
@endsection

