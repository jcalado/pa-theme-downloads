{{-- 
    Template name: Page - Press Room
--}}

@extends('layouts.app')

@section('content')

@include('template-parts.home', [
    'post_type' => 'press',
    'api_url'   => get_rest_url(null, 'wp/v2/press'),
    'sidebar'   => 'front-press',
])

@endsection
