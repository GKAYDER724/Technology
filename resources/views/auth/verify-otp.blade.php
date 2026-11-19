@extends('layouts.app')

@section('title', 'Xác nhận OTP | ElectroTech')

@section('content')

<div class="et-auth-page">

    <div class="et-auth-shell">

        <section class="et-auth-form-panel">

            <div class="et-auth-form-wrap">


                <div class="et-auth-heading">

                    <span class="et-auth-kicker">
                        XÁC NHẬN BẢO MẬT
                    </span>

                    <h2>Nhập mã OTP</h2>

                    <p>
                        Nhập mã OTP 6 số đã được gửi đến email của bạn.
                    </p>

                </div>



                @if(session('success'))

                    <div class="et-auth-alert et-auth-alert-success">

                        {{ session('success') }}

                    </div>

                @endif



                @if($errors->any())

                    <div class="et-auth-alert et-auth-alert-error">

                        <i class="bi bi-exclamation-circle"></i>

                        <div>

                            <strong>Vui lòng kiểm tra lại</strong>

                            <ul>

                                @foreach($errors->all() as $error)

                                    <li>{{ $error }}</li>

                                @endforeach

                            </ul>

                        </div>

                    </div>

                @endif





                <form method="POST"
                      action="{{ route('password.verifyOtp.submit') }}"
                      class="et-auth-form">

                    @csrf



                    <div class="et-auth-field">

                        <label for="otp">
                            Mã OTP
                        </label>


                        <div class="et-auth-input-wrap">

                            <i class="bi bi-shield-lock"></i>


                            <input
                                id="otp"
                                type="text"
                                name="otp"
                                placeholder="Nhập 6 chữ số"
                                maxlength="6"
                                
                            >


                        </div>


                    </div>




                    <button type="submit" class="et-auth-submit">

                        Xác nhận OTP

                        <i class="bi bi-arrow-right"></i>

                    </button>



                </form>





                <div class="et-auth-switch">

                    Chưa nhận được mã?

                    <a href="{{ route('password.resendOtp') }}">
    Gửi lại OTP
</a>

                </div>



            </div>

        </section>

    </div>

</div>


@endsection