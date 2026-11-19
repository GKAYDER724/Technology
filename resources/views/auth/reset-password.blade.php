@extends('layouts.app')

@section('title', 'Đặt lại mật khẩu | ElectroTech')

@section('content')

<div class="et-auth-page">

    <div class="et-auth-shell">

        <section class="et-auth-form-panel">

            <div class="et-auth-form-wrap">

                <div class="et-auth-heading">

                    <span class="et-auth-kicker">
                        KHÔI PHỤC TÀI KHOẢN
                    </span>

                    <h2>
                        Đặt mật khẩu mới
                    </h2>

                    <p>
                        Nhập mật khẩu mới cho tài khoản của bạn.
                    </p>

                </div>


                @if(session('success'))

                    <div class="et-auth-alert et-auth-alert-success">
                        {{ session('success') }}
                    </div>

                @endif


                @if($errors->any())

                    <div class="et-auth-alert et-auth-alert-error">

                        <ul>

                            @foreach($errors->all() as $error)

                                <li>{{ $error }}</li>

                            @endforeach

                        </ul>

                    </div>

                @endif



                <form method="POST"
                      action="{{ route('password.update') }}"
                      class="et-auth-form">

                    @csrf


                    <div class="et-auth-field">

                        <label>
                            Mật khẩu mới
                        </label>

                        <div class="et-auth-input-wrap">

                            <i class="bi bi-lock"></i>

                            <input
                                type="password"
                                name="password"
                                placeholder="Nhập mật khẩu mới"
                                
                            >

                        </div>

                    </div>



                    <div class="et-auth-field">

                        <label>
                            Xác nhận mật khẩu
                        </label>

                        <div class="et-auth-input-wrap">

                            <i class="bi bi-lock-fill"></i>

                            <input
                                type="password"
                                name="password_confirmation"
                                placeholder="Nhập lại mật khẩu"
                                
                            >

                        </div>

                    </div>



                    <button type="submit" class="et-auth-submit">

                        Đổi mật khẩu

                        <i class="bi bi-check-circle"></i>

                    </button>

                </form>

            </div>

        </section>

    </div>

</div>

@endsection