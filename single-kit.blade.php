@extends('layouts.app')

@section('content')
  <div class="pa-content pb-5">
    @include('template-parts.single.header')

    <div class="container pt-5">
      <div class="row justify-content-center">
        <section class="col-auto col-md-8">     
          <div class="mb-5">
            @include('template-parts.single.list-kit-downloads', [
              'downloads' => get_field('downloads'),
            ])
          </div>
          
          @include('template-parts.single.comments')
          
          @include('template-parts.single.related-posts')
        </section>
      </div>
    </div>
  </div>
@endsection
