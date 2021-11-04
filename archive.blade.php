@extends('layouts.app')

@section('content')
	@php
		global $wp_query, $queryFeatured;
	@endphp

	<div class="pa-content py-5">
		<div class="container">
			<div class="row justify-content-md-center">
				<section class="col-12 col-md-8">
          @if(get_query_var('paged') < 1 && $queryFeatured->found_posts > 0)
            @php
              get_template_part('template-parts/global/feature', 'feature', [
                'post' => $queryFeatured->posts[0],
                'tag'  => ($tag = getDepartment($queryFeatured->posts[0]->ID)) ? $tag->name : '',
              ]); 
            @endphp
          @endif

          @if($wp_query->found_posts >= 1)
            <h2 class="mb-3">Materiais</h2>

            <div class="row">
              <div class="col-12">
                <div class="pa-blog-itens mt-3 mb-5">
                  @each('template-parts.global.card-post', $wp_query->posts, 'post')
                </div>
              </div>
            </div>
          @endif
					
					<div class="pa-pg-numbers row">
						@php(new PaPageNumbers())
					</div>
				</section>

				@if(is_active_sidebar('archive'))
					<aside class="col-md-4 d-none d-xl-block">
						@php(dynamic_sidebar('archive'))
					</aside>
				@endif
			</div>
		</div>
	</div>
@endsection
