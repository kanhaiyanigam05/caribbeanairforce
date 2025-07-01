@extends('layout.app')
@push('title')
    <title>{{ $meta->meta_title }}</title>
    <meta name="keywords" content="{{ $meta->meta_keywords }}"/>
    <meta name="description" content="{{ $meta->meta_description }}"/>
@endpush
@section('admin')
    @include('layout.detail')
@endsection
@push('css')
    @stack('detailCss')
    <link rel="stylesheet" href="{{ asset('asset/css/tailwind/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/tailwind/tw.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/base.css') }}">
@endpush
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dompurify/2.3.0/purify.min.js"></script>
    <script src="{{ asset('asset/js/general.js') }}"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://unpkg.com/@geoapify/leaflet-geocoder/dist/leaflet-geocoder.min.js"></script>
    @stack('detailJs')
@endpush