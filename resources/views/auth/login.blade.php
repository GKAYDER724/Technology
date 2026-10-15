@extends('layouts.app')

@section('title', 'Đăng nhập | ElectroTech')

@section('content')
<div class="et-auth-page">
    <div class="et-auth-shell">
        <aside class="et-auth-visual">
            <a href="{{ url('/') }}" class="et-auth-brand">
                <span class="et-auth-brand-icon"><i class="bi bi-lightning-charge-fill"></i></span>
                <span>Electro<span>Tech</span></span>
            </a>
            <div class="et-auth-visual-copy">
                <span class="et-auth-kicker">TECHNOLOGY · TRUST · EXPERIENCE</span>
                <h1>Công nghệ tốt hơn.<br><span>Trải nghiệm tốt hơn.</span></h1>
                <p>Đăng nhập để theo dõi đơn hàng, lưu sản phẩm yêu thích và tận hưởng những ưu đãi dành riêng cho bạn.</p>
                <div class="et-auth-benefits">
                    <div><i class="bi bi-shield-check"></i><span>Thông tin được bảo vệ</span></div>
                    <div><i class="bi bi-truck"></i><span>Theo dõi đơn hàng dễ dàng</span></div>
                    <div><i class="bi bi-stars"></i><span>Ưu đãi dành riêng cho thành viên</span></div>
                </div>
            </div>
            <div class="et-auth-visual-footer"><span><i class="bi bi-patch-check-fill"></i> Sản phẩm chính hãng</span><span>ElectroTech © {{ date('Y') }}</span></div>
        </aside>

        <section class="et-auth-form-panel">
            <a href="{{ url('/') }}" class="et-auth-mobile-brand"><span class="et-auth-brand-icon"><i class="bi bi-lightning-charge-fill"></i></span><strong>Electro<span>Tech</span></strong></a>
            <div class="et-auth-form-wrap">
                <div class="et-auth-heading">
                    <span class="et-auth-kicker">CHÀO MỪNG TRỞ LẠI</span>
                    <h2>Đăng nhập</h2>
                    <p>Nhập thông tin tài khoản của bạn để tiếp tục.</p>
                </div>

                @if (session('status'))
                    <div class="et-auth-alert et-auth-alert-success">{{ session('status') }}</div>
                @endif
                @if ($errors->any())
                    <div class="et-auth-alert et-auth-alert-error"><i class="bi bi-exclamation-circle"></i><div><strong>Vui lòng kiểm tra lại thông tin</strong><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div></div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="et-auth-form">
                    @csrf
                    <div class="et-auth-field">
                        <label for="email">Email</label>
                        <div class="et-auth-input-wrap"><i class="bi bi-envelope"></i><input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" autocomplete="email" required autofocus></div>
                        @error('email')<small class="et-auth-field-error">{{ $message }}</small>@enderror
                    </div>
                    <div class="et-auth-field">
                        <div class="et-auth-label-row"><label for="password">Mật khẩu</label>@if (Route::has('password.request'))<a href="{{ route('password.request') }}">Quên mật khẩu?</a>@endif</div>
                        <div class="et-auth-input-wrap"><i class="bi bi-lock"></i><input id="password" type="password" name="password" placeholder="Nhập mật khẩu" autocomplete="current-password" required><button type="button" class="et-auth-toggle-password" data-password-toggle="password" aria-label="Hiện mật khẩu"><i class="bi bi-eye"></i></button></div>
                        @error('password')<small class="et-auth-field-error">{{ $message }}</small>@enderror
                    </div>
                    <label class="et-auth-checkbox"><input type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}><span>Ghi nhớ đăng nhập</span></label>
                    <button type="submit" class="et-auth-submit">Đăng nhập <i class="bi bi-arrow-right"></i></button>
                </form>
                <div class="et-auth-switch">Bạn chưa có tài khoản? <a href="{{ route('register') }}">Tạo tài khoản mới</a></div>
                <div class="et-auth-secure"><i class="bi bi-shield-lock"></i> Kết nối an toàn · Bảo mật thông tin cá nhân</div>
            </div>
        </section>
    </div>
</div>
<script src="{{ asset('js/auth.js') }}" defer></script>
@endsection
