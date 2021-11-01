@extends('layouts.app')

@php setup_postdata(get_post()); @endphp

@section('content')
    <div class="pa-content-container pt-5 mt-3">
        <div class="container">
            <div class="row justify-content-center">
                {{-- Main --}}
                <article class="col-12 col-md-8">          
                    {{-- Post header --}}
                    @include('template-parts.single.header')

                    {{-- Conteúdo do post --}}
                    <div class="pa-content">
                        {!! the_content() !!}
                    </div>

                    <div class="pa-break d-block my-5 py-2"></div>

                    {{-- Post footer --}}
                    @include('template-parts.single.footer')
                </article>
            </div>
        </div>
    </div>
@endsection