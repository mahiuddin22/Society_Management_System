<!DOCTYPE html>
<html lang="en">

<head>
    <!-- ========== Meta and Title ========== -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ env('APP_NAME') }} | {{$current_request}}</title>
    <!-- Fonts & Icons -->
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/css/bootstrap-icons-1.10.5/font/bootstrap-icons.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/css/fontawesome6.7.2/css/all.min.css')}}" rel="stylesheet" />

    <!-- DataTables -->
    <link href="{{asset('assets/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/css/buttons.bootstrap5.min.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('assets/css/material_blue.css')}}" />
    <link href="{{asset('assets/css/select2.min.css')}}" rel="stylesheet" />
    <!-- Bootstrap Select CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap-select.min.css')}}" />
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <!-- Summernote Texteditor -->
    <link href="{{asset('assets/css/summernote-lite.min.css')}}" rel="stylesheet" />
    <!-- LightGallery CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/lightgallery-bundle.min.css')}}" />
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/swiper-bundle.min.css')}}" />
    <!-- Custom CSS -->
    <link href="{{asset('assets/css/style.css')}}" rel="stylesheet" />
    
    <script src="{{asset('assets/js/jquery-3.7.1.min.js')}}"></script>
</head>

