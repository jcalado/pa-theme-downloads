@extends('layouts.app')

@section('content')
  <div class="pa-content pb-5">
    @include('template-parts.single.header')

    <div class="container pt-5">
      <div class="row justify-content-center">
        <section class="col-auto col-md-8">     
          <div class="mb-5 pb-4 pa-widget">
            
            @if(get_the_content())

              <h2 class="mb-4"><?= __('Kit description', 'downloads') ?></h2>
              <div class="mb-5">{!! get_the_content() !!}</div>

            @endif

            <h2 class="mb-4"><?= __('Kit materials', 'downloads') ?></h2>

            @include('template-parts.single.list-kit-downloads', [
              'downloads' => explode(",", get_field('downloads_kits')['sticky']),
            ])
          </div>
          
          @include('template-parts.single.related-posts', [
            'title' => __('Kit materials', 'downloads')
          ])
        </section>
      </div>
    </div>
  </div>
@endsection
