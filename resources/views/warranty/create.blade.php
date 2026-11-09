@extends('layouts.app')

@section('title', 'Tạo yêu cầu bảo hành | ElectroTech')

@section('content')
    <div class="warranty-page">

        <div class="warranty-breadcrumb">
            <a href="/">Trang chủ</a>
            <span>/</span>
            <a href="{{ route('warranty.index') }}">Bảo hành</a>
            <span>/</span>
            <span>Tạo yêu cầu</span>
        </div>

        <div class="warranty-page-heading">
            <div>
                <span class="eyebrow">ELECTROTECH CARE</span>
                <h1>Tạo yêu cầu bảo hành</h1>
                <p>Điền thông tin bên dưới để tạo phiếu yêu cầu hỗ trợ sản phẩm.</p>
            </div>
            <div class="heading-icon">
                <i class="bi bi-file-earmark-plus"></i>
            </div>
        </div>

        <div class="warranty-form-layout">

            <form class="w-panel warranty-form" onsubmit="event.preventDefault();">

                {{-- Bước 1: Thông tin sản phẩm --}}
                <div class="panel-heading">
                    <div>
                        <span class="step-label">BƯỚC 1</span>
                        <h2>Thông tin sản phẩm</h2>
                    </div>
                    <span class="required-note"><b>*</b> Thông tin bắt buộc</span>
                </div>

                <div class="w-form-grid">
                    <label class="w-field">
                        <span>Mã đơn hàng <b>*</b></span>
                        <input type="text" placeholder="VD: ORD-20261010-001">
                        <small>Nhập mã đơn hàng đã mua tại ElectroTech</small>
                    </label>

                    <label class="w-field">
                        <span>Tên sản phẩm <b>*</b></span>
                        <input type="text" placeholder="Nhập tên sản phẩm">
                    </label>

                    <label class="w-field">
                        <span>Số serial / IMEI</span>
                        <input type="text" placeholder="Nhập số serial hoặc IMEI">
                    </label>

                    <label class="w-field">
                        <span>Ngày mua hàng <b>*</b></span>
                        <input type="date">
                    </label>

                    <label class="w-field">
                        <span>Nhóm sản phẩm <b>*</b></span>
                        <select>
                            <option value="">Chọn nhóm sản phẩm</option>
                            <option>Điện thoại</option>
                            <option>Laptop</option>
                            <option>Máy tính bảng</option>
                            <option>Phụ kiện</option>
                            <option>Thiết bị gia dụng</option>
                            <option>Khác</option>
                        </select>
                    </label>

                    <label class="w-field">
                        <span>Hình thức hỗ trợ <b>*</b></span>
                        <select>
                            <option value="">Chọn hình thức</option>
                            <option>Bảo hành tại trung tâm</option>
                            <option>Gửi sản phẩm đến cửa hàng</option>
                            <option>Tư vấn kỹ thuật</option>
                        </select>
                    </label>
                </div>

                <div class="form-divider"></div>

                {{-- Bước 2: Mô tả tình trạng --}}
                <div class="panel-heading">
                    <div>
                        <span class="step-label">BƯỚC 2</span>
                        <h2>Mô tả tình trạng</h2>
                    </div>
                </div>

                <div class="w-form-grid">
                    <label class="w-field full">
                        <span>Tình trạng / lỗi sản phẩm <b>*</b></span>
                        <select>
                            <option value="">Chọn tình trạng phù hợp</option>
                            <option>Không lên nguồn</option>
                            <option>Lỗi màn hình</option>
                            <option>Lỗi pin / sạc</option>
                            <option>Lỗi phần mềm</option>
                            <option>Lỗi kết nối</option>
                            <option>Hư hỏng khác</option>
                        </select>
                    </label>

                    <label class="w-field full">
                        <span>Mô tả chi tiết <b>*</b></span>
                        <textarea rows="5"
                            placeholder="Mô tả lỗi, thời điểm phát sinh và các cách bạn đã thử..."></textarea>
                        <small>Không cung cấp mật khẩu hoặc thông tin nhạy cảm trong phần mô tả.</small>
                    </label>

                    <label class="w-field full">
                        <span>Ảnh / video minh họa</span>
                        <div class="upload-placeholder">
                            <i class="bi bi-cloud-arrow-up"></i>
                            <b>Kéo thả tệp vào đây hoặc <u>chọn tệp</u></b>
                            <small>PNG, JPG hoặc MP4 · Giao diện minh họa tải tệp</small>
                            <input type="file" multiple accept="image/*,video/*">
                        </div>
                    </label>
                </div>

                <div class="form-divider"></div>

                {{-- Bước 3: Thông tin liên hệ --}}
                <div class="panel-heading">
                    <div>
                        <span class="step-label">BƯỚC 3</span>
                        <h2>Thông tin liên hệ</h2>
                    </div>
                </div>

                <div class="w-form-grid">
                    <label class="w-field">
                        <span>Họ và tên <b>*</b></span>
                        <input type="text" placeholder="Nhập họ và tên">
                    </label>

                    <label class="w-field">
                        <span>Số điện thoại <b>*</b></span>
                        <input type="tel" placeholder="VD: 09xx xxx xxx">
                    </label>

                    <label class="w-field">
                        <span>Email</span>
                        <input type="email" placeholder="name@example.com">
                    </label>

                    <label class="w-field">
                        <span>Tỉnh / thành phố</span>
                        <select>
                            <option value="">Chọn tỉnh / thành phố</option>
                            <option>Hà Nội</option>
                            <option>TP. Hồ Chí Minh</option>
                            <option>Đà Nẵng</option>
                            <option>Tỉnh / thành khác</option>
                        </select>
                    </label>

                    <label class="w-field full">
                        <span>Địa chỉ nhận / gửi sản phẩm</span>
                        <input type="text" placeholder="Số nhà, đường, phường / xã...">
                    </label>
                </div>

                <label class="w-check">
                    <input type="checkbox">
                    <span>
                        Tôi xác nhận thông tin cung cấp là chính xác và đồng ý
                        để ElectroTech liên hệ hỗ trợ.
                    </span>
                </label>

                <div class="form-actions">
                    <a class="w-btn w-btn-light" href="{{ route('warranty.index') }}">
                        Hủy bỏ
                    </a>

                    <button class="w-btn w-btn-primary" type="button">
                        <i class="bi bi-send"></i>
                        Gửi yêu cầu
                        <span class="demo-tag">Demo</span>
                    </button>
                </div>

                <p class="form-demo-note">
                    <i class="bi bi-info-circle"></i>
                    Đây là giao diện mẫu; nút gửi chưa lưu dữ liệu hoặc tạo yêu cầu thật.
                </p>
            </form>

            {{-- Sidebar --}}
            <aside class="warranty-sidebar">

                <div class="w-panel sidebar-help">
                    <div class="sidebar-help-icon">
                        <i class="bi bi-headset"></i>
                    </div>

                    <h3>Cần hỗ trợ thêm?</h3>
                    <p>Đội ngũ chăm sóc khách hàng luôn sẵn sàng hướng dẫn bạn.</p>

                    <div class="help-row">
                        <i class="bi bi-telephone"></i>
                        <span>
                            <small>Hotline hỗ trợ</small>
                            <b>1900 xxxx</b>
                        </span>
                    </div>

                    <div class="help-row">
                        <i class="bi bi-clock"></i>
                        <span>
                            <small>Thời gian làm việc</small>
                            <b>08:00 – 21:00</b>
                        </span>
                    </div>
                </div>

                <div class="w-panel sidebar-checklist">
                    <h3>
                        <i class="bi bi-clipboard-check"></i>
                        Chuẩn bị trước
                    </h3>

                    <ul>
                        <li>
                            <i class="bi bi-check-circle-fill"></i>
                            Mã đơn hàng / hóa đơn
                        </li>
                        <li>
                            <i class="bi bi-check-circle-fill"></i>
                            Số serial hoặc IMEI
                        </li>
                        <li>
                            <i class="bi bi-check-circle-fill"></i>
                            Mô tả lỗi rõ ràng
                        </li>
                        <li>
                            <i class="bi bi-check-circle-fill"></i>
                            Hình ảnh minh họa (nếu có)
                        </li>
                    </ul>
                </div>

            </aside>
        </div>
    </div>
@endsection
