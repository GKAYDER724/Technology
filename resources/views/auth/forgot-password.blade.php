@extends('layouts.app')

@section('title', 'Quên mật khẩu | ElectroTech')

@section('content')

<div class="et-auth-page">
    <div class="et-auth-shell">

        <section class="et-auth-form-panel">

            <div class="et-auth-form-wrap">

                <div class="et-auth-heading">

                    <span class="et-auth-kicker">
                        KHÔI PHỤC TÀI KHOẢN
                    </span>

                    <h2>Quên mật khẩu?</h2>

                    <p>
                        Nhập email của bạn để nhận mã xác nhận.
                    </p>

                </div>


                @if(session('success'))
                    <div class="et-auth-alert et-auth-alert-success">
                        {{ session('success') }}
                    </div>
                @endif


                @if ($errors->any())
                    <div class="et-auth-alert et-auth-alert-error">

                        <i class="bi bi-exclamation-circle"></i>

                        <div>

                            <strong>
                                Vui lòng kiểm tra lại thông tin
                            </strong>

                            <ul>

                                @foreach ($errors->all() as $error)

                                    <li>
                                        {{ $error }}
                                    </li>

                                @endforeach

                            </ul>

                        </div>

                    </div>
                @endif



                <form method="POST" action="{{ route('password.sendOtp') }}">

                    @csrf


                    <div class="et-auth-field">

                        <label for="email">
                            Email
                        </label>


                        <div class="et-auth-input-wrap">

                            <i class="bi bi-envelope"></i>


                            <input 
                                id="email"
                                type="text"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="you@example.com"
                                autocomplete="email"
                                >


                        </div>


                    </div>



                    <button type="submit" class="et-auth-submit">

                        Gửi mã OTP

                        <i class="bi bi-send"></i>

                    </button>


                </form>



                <div class="et-auth-switch">

                    Nhớ mật khẩu?

                    <a href="{{ route('login') }}">
                        Đăng nhập
                    </a>

                </div>


            </div>

        </section>

    </div>
</div>


@endsection