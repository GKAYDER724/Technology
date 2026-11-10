@extends('layouts.app')

@section('title', 'Bảo hành | ElectroTech')

@section('content')
    <div class="warranty-page">

        <div class="warranty-breadcrumb">
            <a href="/">Trang chủ</a>
            <span>/</span>
            <span>Bảo hành</span>
        </div>

        <section class="warranty-hero">
            <div class="warranty-hero-copy">
                <span class="eyebrow">
                    <i class="bi bi-shield-shaded"></i>
                    ELECTROTECH CARE
                </span>

                <h1>Trung tâm <span>bảo hành</span></h1>

                <p>
                    Đồng hành cùng bạn trong suốt quá trình sử dụng sản phẩm.
                    Tra cứu thông tin và quản lý yêu cầu bảo hành thật dễ dàng.
                </p>

                <div class="hero-actions">
                    <a class="w-btn w-btn-primary" href="{{ route('warranty.create') }}">
                        <i class="bi bi-plus-lg"></i>
                        Tạo yêu cầu bảo hành
                    </a>

                    <a class="w-btn w-btn-light" href="{{ route('warranty.status') }}">
                        <i class="bi bi-search"></i>
                        Tra cứu trạng thái
                    </a>
                </div>

                <div class="hero-note">
                    <i class="bi bi-check-circle-fill"></i>
                    Hỗ trợ tận tâm · Quy trình minh bạch · Theo dõi thuận tiện
                </div>
            </div>

            <div class="warranty-hero-art" aria-hidden="true">
                <div class="art-glow"></div>

                <div class="art-shield">
                    <i class="bi bi-shield-fill-check"></i>
                    <i class="bi bi-check-lg art-check"></i>
                </div>

                <div class="art-card art-card-top">
                    <i class="bi bi-headset"></i>
                    <span>
                        <b>Hỗ trợ khách hàng</b>
                        <small>Luôn sẵn sàng đồng hành</small>
                    </span>
                </div>

                <div class="art-card art-card-bottom">
                    <i class="bi bi-tools"></i>
                    <span>
                        <b>Quy trình rõ ràng</b>
                        <small>Cập nhật từng giai đoạn</small>
                    </span>
                </div>
            </div>
        </section>

        <div class="warranty-section-heading">
            <div>
                <span class="eyebrow">DỊCH VỤ HẬU MÃI</span>
                <h2>Bạn cần hỗ trợ gì?</h2>
                <p>Chọn một dịch vụ bên dưới để tiếp tục.</p>
            </div>
        </div>

        <div class="warranty-service-grid">

            <a class="warranty-service-card" href="{{ route('warranty.create') }}">
                <div class="service-icon blue">
                    <i class="bi bi-file-earmark-plus"></i>
                </div>

                <span class="service-arrow">
                    <i class="bi bi-arrow-up-right"></i>
                </span>

                <h3>Tạo yêu cầu bảo hành</h3>
                <p>Gửi thông tin sản phẩm và mô tả tình trạng cần hỗ trợ.</p>

                <span class="service-link">
                    Bắt đầu yêu cầu
                    <i class="bi bi-arrow-right"></i>
                </span>
            </a>

            <a class="warranty-service-card" href="{{ route('warranty.status') }}">
                <div class="service-icon cyan">
                    <i class="bi bi-search"></i>
                </div>

                <span class="service-arrow">
                    <i class="bi bi-arrow-up-right"></i>
                </span>

                <h3>Xem trạng thái</h3>
                <p>Tra cứu tiến độ xử lý của một yêu cầu bảo hành.</p>

                <span class="service-link">
                    Tra cứu ngay
                    <i class="bi bi-arrow-right"></i>
                </span>
            </a>

            <a class="warranty-service-card" href="{{ route('warranty.history') }}">
                <div class="service-icon purple">
                    <i class="bi bi-clock-history"></i>
                </div>

                <span class="service-arrow">
                    <i class="bi bi-arrow-up-right"></i>
                </span>

                <h3>Lịch sử bảo hành</h3>
                <p>Xem lại các yêu cầu và thông tin bảo hành trước đây.</p>

                <span class="service-link">
                    Xem lịch sử
                    <i class="bi bi-arrow-right"></i>
                </span>
            </a>

        </div>

        <section class="warranty-info-strip">
            <div class="info-strip-icon">
                <i class="bi bi-info-circle-fill"></i>
            </div>

            <div>
                <h3>Trước khi gửi yêu cầu</h3>
                <p>
                    Vui lòng chuẩn bị mã đơn hàng hoặc số serial sản phẩm,
                    thông tin liên hệ và mô tả lỗi để việc tiếp nhận được thuận tiện hơn.
                </p>
            </div>

            <a href="{{ route('warranty.create') }}">
                Tạo yêu cầu
                <i class="bi bi-arrow-right"></i>
            </a>
        </section>

    </div>
@endsection
