@extends('layouts.app')

@section('content')
  <div class="pa-content pb-5">
    @include('template-parts.single.header')

    <div class="container pt-5">
      <div class="row justify-content-center">
        <section class="col-auto col-md-8">     
          <h2 class="mb-3">Detalhes do arquivo</h2>     
          
          <p class="post-excerpt mb-4">{!! get_the_excerpt() !!}</p>
              
          @include('template-parts.single.related-posts')

          @include('template-parts.single.comments')
        </section>
      </div>
    </div>
  </div>
@endsection
