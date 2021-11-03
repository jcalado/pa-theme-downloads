@extends('layouts.app')

@section('content')
    <div class="pa-content py-5">
        <div class="container">
            <div class="row justify-content-md-center">
                {{-- Main --}}
                <section class="col-auto col-md-8{{ is_active_sidebar('single') ? ' col-xl-8' : '' }}">          
                    {{-- Post de destaque --}}
                    @include('template-parts.single.header')

                    {{-- Conteúdo do post --}}
                    {!! the_content() !!}

                    <hr class="separator">

                    {{-- Post relacionados --}}
                    @include('template-parts.single.related-posts')

                    {{-- Post relacionados --}}
                    @include('template-parts.single.comments')
                </section>

                {{-- Sidebar --}}
                @if(is_active_sidebar('single'))
                    <aside class="col-md-4 d-none d-xl-block">
                        @php(dynamic_sidebar('single'))
                    </aside>
                @endif
            </div>
        </div>
    </div>
@endsection
