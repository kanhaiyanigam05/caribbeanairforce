@extends('layout.app')
@section('css')
    <script src="{{ asset('admins/css/custom-calendar/calendar.css') }}"></script>
    <link rel="stylesheet" href="{{ asset('admins/css/swiper-v11/swiper.css') }}" />
    <link rel="stylesheet" href="{{ asset('admins/css/post-reset.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="{{ asset('admins/css/hamburger.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" />
@endsection
@section('admin')
    @yield('events')
@endsection
@section('js')
    <script src="{{ asset('admins/js/swiper-v11/swiper.js') }}"></script>
    <script src="{{ asset('admins/js/swiper-v11/swiper-settings.js') }}"></script>
    <script src="{{ asset('admins/js/tinymce-v7.3.0/tinymce.min.js') }}"></script>
    <script src="{{ asset('admins/js/tinymce-v7.3.0/settings.js') }}"></script>
    <script src="{{ asset('admins/js/drag.js') }}"></script>
    <script src="{{ asset('admins/js/tab-switch.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
    <script src="{{ asset('admins/js/custom-calendar/calendar.js') }}"></script>
    <script src="{{ asset('admins/js/swiper-v11/event-form.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dompurify/2.3.0/purify.min.js"></script>
@endsection
