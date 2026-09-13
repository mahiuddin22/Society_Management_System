<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="csrf-token" content="{{ csrf_token() }}" />
<meta name="description" content="Uttara Sector 3 Welfare Society — Serving and supporting the residents of Uttara Sector 3 through community welfare, services, and development.">
<title>Uttara Sector 3 Welfare Society — @yield('title', ucfirst($current_request ?? 'Dashboard'))</title>

<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap-icons-1.10.5/font/bootstrap-icons.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/fontawesome6.7.2/css/all.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap5.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/buttons.bootstrap5.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/material_blue.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap-select.min.css') }}" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" />
<link rel="stylesheet" href="{{ asset('assets/css/summernote-lite.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/lightgallery-bundle.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/swiper-bundle.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=VT323&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/smoothness/jquery-ui.css">
@stack('styles')
<script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
