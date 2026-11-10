<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ElectroStore - Siêu Thị Thiết Bị Điện Tử & Công Nghệ Chính Hãng')</title>
    <meta name="description" content="Hệ thống bán lẻ thiết bị điện tử, máy tính xách tay, điện thoại thông minh, màn hình gaming chính hãng uy tín số 1 Việt Nam.">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- Custom Tech E-commerce CSS -->
    <link rel="stylesheet" href="/css/app.css">
    @yield('styles')
</head>
<body class="bg-light">

    {{-- Main Header --}}
    @include('layouts.header')

    {{-- Main Content Section --}}
    <main class="py-4">
        @yield('content')
    </main>

    {{-- Main Footer --}}
    @include('layouts.footer')

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom Tech E-commerce JS -->
    <script src="/js/app.js"></script>
    @yield('scripts')
</body>
</html>
