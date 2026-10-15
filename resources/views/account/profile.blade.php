@extends('layouts.app')

@section('title', 'Tài khoản cá nhân - ElectroTech')

@section('content')
<main class="et-profile-page">
    <div class="et-profile-container">

        {{-- Breadcrumb --}}
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
                            alt="Ảnh đại diện Nguyễn Văn Hùng"
                        >
                    </div>

                    <div class="et-profile-user-info">
                        <h1>
                            Nguyễn Văn Hùng
                            <span class="et-vip-badge">
                                <i class="bi bi-award-fill"></i>
                                Tech VIP
                            </span>
                        </h1>

                        <p class="et-profile-contact">
                            hung.nguyen@gmail.com
                            <span>•</span>
                            0912 345 678
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

                <form id="profile-update-form" class="et-profile-form">

                    <div class="et-profile-fields">
                        <div class="et-profile-field">
                            <label for="profile-name">
                                Họ và tên đầy đủ <b>*</b>
                            </label>
                            <input
                                type="text"
                                id="profile-name"
                                name="name"
                                value="Nguyễn Văn Hùng"
                                required
                            >
                        </div>

                        <div class="et-profile-field">
                            <label for="profile-phone">
                                Số điện thoại <b>*</b>
                            </label>
                            <input
                                type="tel"
                                id="profile-phone"
                                name="phone"
                                value="0912 345 678"
                                required
                            >
                        </div>

                        <div class="et-profile-field">
                            <label for="profile-email">Email tài khoản</label>
                            <input
                                type="email"
                                id="profile-email"
                                name="email"
                                value="hung.nguyen@gmail.com"
                            >
                        </div>

                        <div class="et-profile-field">
                            <label for="profile-birthday">Ngày sinh</label>
                            <input
                                type="date"
                                id="profile-birthday"
                                name="birthday"
                                value="1995-08-15"
                            >
                        </div>
                    </div>

                    <fieldset class="et-profile-gender">
                        <legend>Giới tính</legend>

                        <label>
                            <input type="radio" name="gender" value="male" checked>
                            <span>Nam</span>
                        </label>

                        <label>
                            <input type="radio" name="gender" value="female">
                            <span>Nữ</span>
                        </label>

                        <label>
                            <input type="radio" name="gender" value="other">
                            <span>Khác</span>
                        </label>
                    </fieldset>

                    <div class="et-profile-fields et-profile-address-fields">
                        <div class="et-profile-field">
                            <label for="profile-address">
                                Địa chỉ giao hàng mặc định
                            </label>
                            <input
                                type="text"
                                id="profile-address"
                                name="address"
                                value="Số 45, Đường Lê Duẩn"
                            >
                        </div>

                        <div class="et-profile-field">
                            <label for="profile-city">Tỉnh / Thành phố</label>
                            <input
                                type="text"
                                id="profile-city"
                                name="city"
                                value="TP. Hồ Chí Minh"
                            >
                        </div>
                    </div>

                    <div class="et-profile-form-actions">
                        <button type="submit" class="et-profile-primary-btn">
                            <i class="bi bi-floppy"></i>
                            Lưu Thay Đổi Thông Tin
                        </button>
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

                    <form id="profile-password-form">
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
                                    required
                                >
                            </div>

                            <div class="et-profile-field">
                                <label for="new-password">Mật khẩu mới</label>
                                <input
                                    type="password"
                                    id="new-password"
                                    name="new_password"
                                    placeholder="Tối thiểu 6 ký tự"
                                    minlength="6"
                                    required
                                >
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
                                    required
                                >
                            </div>
                        </div>

                        <div class="et-profile-password-actions">
                            <button
                                type="submit"
                                class="et-profile-password-btn"
                            >
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
