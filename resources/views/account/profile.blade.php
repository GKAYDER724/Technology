@extends('layouts.app')

@section('title', 'Tài khoản cá nhân - ElectroTech')

@section('content')

<main class="et-profile-page">
    <div class="et-profile-container">

        {{-- BREADCRUMB --}}
        <div class="et-profile-breadcrumb">
            <a href="{{ url('/') }}">Trang chủ</a>
            <i class="bi bi-chevron-right"></i>
            <span>Tài khoản cá nhân</span>
        </div>

        {{-- PROFILE HERO --}}
        <section class="et-profile-hero">
            <div class="et-profile-hero-top">
                <div class="et-profile-identity">
                    <div class="et-profile-avatar">
                        <img
                            src="https://i.pravatar.cc/160?img=12"
                            alt="Ảnh đại diện">
                    </div>

                    <div class="et-profile-user-info">
                        <h1>
                            {{ $user->fullname }}
                            <span class="et-vip-badge">
                                <i class="bi bi-award-fill"></i>
                                Tech VIP
                            </span>
                        </h1>

                        <p class="et-profile-contact">
                            {{ $user->email }}
                            <span>•</span>
                            {{ $user->phone ?? 'Chưa cập nhật số điện thoại' }}
                        </p>

                        <div class="et-profile-loyalty">
                            <span>
                                Điểm tích lũy:
                                <strong>1.250 điểm</strong>
                            </span>
                            <span class="et-loyalty-divider">·</span>
                            <span>
                                Hạng:
                                <strong class="et-loyalty-rank">
                                    VIP Khách hàng thân thiết
                                </strong>
                            </span>
                        </div>
                    </div>
                </div>

                <a href="{{ url('/orders') }}" class="et-profile-orders-btn">
                    <i class="bi bi-box-seam"></i>
                    Xem lịch sử đơn hàng
                </a>
            </div>

            <div class="et-profile-stats">
                <div class="et-profile-stat">
                    <strong>3</strong>
                    <span>Tổng đơn đã mua</span>
                </div>

                <div class="et-profile-stat">
                    <strong>1</strong>
                    <span>Đơn hàng đang xử lý</span>
                </div>

                <div class="et-profile-stat">
                    <strong>2</strong>
                    <span>Đánh giá sản phẩm</span>
                </div>
            </div>
        </section>

        {{-- MAIN CONTENT --}}
        <div class="et-profile-layout">

            {{-- LEFT: PERSONAL INFORMATION --}}
            <section class="et-profile-panel et-profile-form-panel">

                <div class="et-profile-section-heading">
                    <h2>
                        <i class="bi bi-person"></i>
                        HỒ SƠ THÔNG TIN CÁ NHÂN
                    </h2>
                    <span>Cập nhật thông tin nhận hàng và tài khoản</span>
                </div>

                {{-- THÔNG BÁO THÀNH CÔNG --}}
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif


                @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <strong>Vui lòng kiểm tra lại thông tin.</strong>
                    <ul style="margin: 8px 0 0; padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                {{-- PROFILE FORM --}}
                <form
                    id="profile-update-form"
                    class="et-profile-form"
                    action="{{ route('account.profile.update') }}"
                    method="POST">
                    @csrf
                    @method('PUT')

                    <div class="et-profile-fields">

                        {{-- FULL NAME --}}
                        <div class="et-profile-field">
                            <label for="profile-name">
                                Họ và tên đầy đủ <b>*</b>
                            </label>

                            <input
                                type="text"
                                id="profile-name"
                                name="fullname"
                                value="{{ old('fullname', $user->fullname) }}"
                                maxlength="120"
                                pattern="[\p{L}\p{M}]+([ ]+[\p{L}\p{M}]+)*"
                                title="Họ tên chỉ được chứa chữ cái và khoảng trắng."
                                required
                                class="@error('fullname') input-error @enderror">

                            @error('fullname')
                            <small class="field-error">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- PHONE --}}
                        <div class="et-profile-field">
                            <label for="profile-phone">
                                Số điện thoại <b>*</b>
                            </label>

                            <input
                                type="tel"
                                id="profile-phone"
                                name="phone"
                                value="{{ old('phone', $user->phone) }}"
                                inputmode="numeric"
                                pattern="[0-9]{10,11}"
                                minlength="10"
                                maxlength="11"
                                title="Vui lòng nhập số điện thoại gồm 10–11 chữ số."
                                required
                                class="@error('phone') input-error @enderror">

                            @error('phone')
                            <small class="field-error">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- EMAIL --}}
                        <div class="et-profile-field">
                            <label for="profile-email">Email tài khoản</label>

                            <input
                                type="email"
                                id="profile-email"
                                value="{{ $user->email }}"
                                readonly>
                        </div>

                        {{-- BIRTHDAY --}}
                        <div class="et-profile-field">
                            <label for="profile-birthday">Ngày sinh</label>

                            <input
                                type="date"
                                id="profile-birthday"
                                name="date_of_birth"
                                value="{{ old('date_of_birth', $user->date_of_birth) }}"
                                max="{{ date('Y-m-d') }}"
                                class="@error('date_of_birth') input-error @enderror">

                            @error('date_of_birth')
                            <small class="field-error">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- GENDER --}}
                        <fieldset class="et-profile-gender">
                            <legend>Giới tính</legend>

                            <label>
                                <input
                                    type="radio"
                                    name="gender"
                                    value="male"
                                    {{ old('gender', $user->gender) === 'male' ? 'checked' : '' }}>
                                <span>Nam</span>
                            </label>

                            <label>
                                <input
                                    type="radio"
                                    name="gender"
                                    value="female"
                                    {{ old('gender', $user->gender) === 'female' ? 'checked' : '' }}>
                                <span>Nữ</span>
                            </label>

                            <label>
                                <input
                                    type="radio"
                                    name="gender"
                                    value="other"
                                    {{ old('gender', $user->gender) === 'other' ? 'checked' : '' }}>
                                <span>Khác</span>
                            </label>

                            @error('gender')
                            <small class="field-error">{{ $message }}</small>
                            @enderror
                        </fieldset>

                        {{-- ADDRESS AND CITY --}}
                        <div class="et-profile-fields et-profile-address-fields">

                            <div class="et-profile-field">
                                <label for="profile-address">
                                    Địa chỉ giao hàng mặc định <b>*</b>
                                </label>

                                <input
                                    type="text"
                                    id="profile-address"
                                    name="address"
                                    value="{{ old('address', $user->address) }}"
                                    maxlength="255"
                                    required
                                    class="@error('address') input-error @enderror">

                                @error('address')
                                <small class="field-error">{{ $message }}</small>
                                @enderror
                            </div>


                            <div class="et-profile-field">
                                <label for="profile-city">
                                    Tỉnh / Thành phố <b>*</b>
                                </label>

                                <select
                                    id="profile-city"
                                    name="province_city"
                                    required
                                    class="@error('province_city') input-error @enderror">
                                    <option value="">-- Chọn tỉnh / thành phố --</option>

                                    @foreach ([
                                    'An Giang',
                                    'Bắc Ninh',
                                    'Cà Mau',
                                    'Cao Bằng',
                                    'Đắk Lắk',
                                    'Điện Biên',
                                    'Đồng Nai',
                                    'Đồng Tháp',
                                    'Gia Lai',
                                    'Hà Tĩnh',
                                    'Hưng Yên',
                                    'Khánh Hòa',
                                    'Lai Châu',
                                    'Lâm Đồng',
                                    'Lạng Sơn',
                                    'Lào Cai',
                                    'Nghệ An',
                                    'Ninh Bình',
                                    'Phú Thọ',
                                    'Quảng Ngãi',
                                    'Quảng Ninh',
                                    'Quảng Trị',
                                    'Sơn La',
                                    'Tây Ninh',
                                    'Thái Nguyên',
                                    'Thanh Hóa',
                                    'Tuyên Quang',
                                    'Vĩnh Long',
                                    'Cần Thơ',
                                    'Đà Nẵng',
                                    'Hải Phòng',
                                    'Hà Nội',
                                    'Hồ Chí Minh',
                                    'Huế',
                                    ] as $province)
                                    <option
                                        value="{{ $province }}"
                                        {{ old('province_city', $user->province_city) === $province ? 'selected' : '' }}>
                                        {{ $province }}
                                    </option>
                                    @endforeach
                                </select>

                                @error('province_city')
                                <small class="field-error">{{ $message }}</small>
                                @enderror
                            </div>


                        </div>

                        {{-- SAVE BUTTON --}}
                        <div class="et-profile-form-actions">
                            <button type="submit" class="et-profile-primary-btn">
                                <i class="bi bi-floppy"></i>
                                Lưu Thay Đổi Thông Tin
                            </button>
                        </div>

                    </div>
                </form>

                {{-- CHANGE PASSWORD --}}
                <div class="et-profile-password-section">

                    <div class="et-profile-section-heading">
                        <h2>
                            <i class="bi bi-lock"></i>
                            ĐỔI MẬT KHẨU BẢO MẬT
                        </h2>
                    </div>

                    {{-- PASSWORD SUCCESS --}}
                    @if (session('password_success'))
                    <div class="alert alert-success">
                        {{ session('password_success') }}
                    </div>
                    @endif

                    {{-- PASSWORD ERRORS --}}
                    @if ($errors->has('current_password')
                    || $errors->has('new_password')
                    || $errors->has('confirm_password'))
                    <div class="et-password-errors">
                        @foreach ([
                        'current_password',
                        'new_password',
                        'confirm_password'
                        ] as $field)
                        @error($field)
                        <small class="field-error">{{ $message }}</small>
                        @enderror
                        @endforeach
                    </div>
                    @endif

                    <form
                        id="profile-password-form"
                        action="{{ route('account.password.update') }}"
                        method="POST">
                        @csrf
                        @method('PUT')

                        <div class="et-password-fields">

                            <div class="et-profile-field">
                                <label for="current-password">
                                    Mật khẩu hiện tại
                                </label>

                                <input
                                    type="password"
                                    id="current-password"
                                    name="current_password"
                                    placeholder="Nhập mật khẩu hiện tại"
                                    required>
                            </div>

                            <div class="et-profile-field">
                                <label for="new-password">Mật khẩu mới</label>

                                <input
                                    type="password"
                                    id="new-password"
                                    name="new_password"
                                    placeholder="Tối thiểu 6 ký tự"
                                    minlength="6"
                                    required>
                            </div>

                            <div class="et-profile-field">
                                <label for="confirm-password">
                                    Xác nhận mật khẩu
                                </label>

                                <input
                                    type="password"
                                    id="confirm-password"
                                    name="confirm_password"
                                    placeholder="Nhập lại mật khẩu mới"
                                    minlength="6"
                                    required>
                            </div>

                        </div>

                        <div class="et-profile-password-actions">
                            <button
                                type="submit"
                                class="et-profile-password-btn">
                                Cập nhật mật khẩu
                            </button>
                        </div>
                    </form>

                </div>
            </section>

            {{-- RIGHT SIDEBAR --}}
            <aside class="et-profile-sidebar">

                {{-- VIP BENEFITS --}}
                <section class="et-profile-vip-card">
                    <div class="et-profile-vip-heading">
                        <h2>
                            <i class="bi bi-award"></i>
                            ĐẶC QUYỀN TECH VIP
                        </h2>
                        <i class="bi bi-stars et-profile-vip-stars"></i>
                    </div>

                    <p>
                        Bạn là thành viên VIP với đặc quyền ưu tiên
                        dành cho khách hàng cao cấp nhất tại ElectroTech.
                    </p>

                    <ul>
                        <li>
                            <i class="bi bi-shield-check"></i>
                            Miễn phí vận chuyển hóa tốc trọn đời
                        </li>
                        <li>
                            <i class="bi bi-shield-check"></i>
                            Hỗ trợ kỹ thuật viên kiểm tra tận nhà
                        </li>
                        <li>
                            <i class="bi bi-shield-check"></i>
                            Tặng 500.000đ voucher quà tặng sinh nhật
                        </li>
                        <li>
                            <i class="bi bi-shield-check"></i>
                            Tích lũy 1% giá trị mỗi đơn hàng thành điểm
                        </li>
                    </ul>
                </section>

                {{-- QUICK ACTIONS --}}
                <section class="et-profile-panel et-profile-quick-card">
                    <h2>THAO TÁC NHANH</h2>

                    <a href="{{ url('/orders') }}" class="et-profile-quick-link">
                        <span>
                            <i class="bi bi-box-seam"></i>
                            Theo dõi đơn hàng của tôi
                        </span>
                        <i class="bi bi-chevron-right"></i>
                    </a>

                    <a href="{{ url('/notifications') }}" class="et-profile-quick-link">
                        <span>
                            <i class="bi bi-envelope"></i>
                            Hộp thư thông báo
                        </span>
                        <i class="bi bi-chevron-right"></i>
                    </a>
                </section>

            </aside>
        </div>
    </div>
</main>
@endsection