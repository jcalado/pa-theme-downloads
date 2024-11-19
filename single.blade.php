@extends('layouts.app')

@section('content')
  <div class="pa-content pb-5">
    @include('template-parts.single.header')

    <div class="container pt-5">
      <div class="row justify-content-center">
        <section class="col-auto col-md-8 pa-widget">     
          <h2 class="mb-3"><?= __('File details', 'iasd') ?></h2>     
          
          <div class="mb-4">{!! get_the_content() !!}</div>

          <div class="mb-5">
            @include('template-parts.single.list-downloads', [
              'downloads' => get_field('downloads'),
            ])

            <div class="row justify-content-center justify-content-lg-start">
              <div class="col-auto mt-4">
                @include('components.global.link-report')
              </div>
            </div>
          </div>
          
          @include('template-parts.single.comments')
          
          @include('template-parts.single.related-posts')
        </section>
      </div>
    </div>
  </div>
@endsection
