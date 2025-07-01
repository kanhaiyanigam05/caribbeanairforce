@extends('layout.front')
@push('title')
    <title>{{ $meta->meta_title }}</title>
    <meta name="keywords" content="{{ $meta->meta_keywords }}"/>
    <meta name="description" content="{{ $meta->meta_description }}"/>
@endpush

@section('main')
    @include('layout.detail')
@endsection
@push('css')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&amp;icon_names=share">
    @stack('detailCss')
@endpush
@push('js')
    @stack('detailJs')
@endpush