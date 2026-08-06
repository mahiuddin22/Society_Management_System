<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="csrf-token" content="{{ csrf_token() }}" />
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
@stack('styles')
<script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
