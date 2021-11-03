@extends('layouts.app')

@section('content')
	@php
		global $wp_query, $queryFeatured;
	@endphp

	<div class="pa-content py-5">
		<div class="container">
			<div class="row justify-content-md-center">
				<section class="col-12 col-md-8{{ is_active_sidebar('archive') ? ' col-xl-8' : '' }}">
					@includeWhen(get_query_var('paged') < 1 && $queryFeatured->found_posts > 0, 'template-parts.feature', [
						'post' => $queryFeatured->posts[0],
					])

					@includeWhen($wp_query->found_posts >= 1, 'template-parts.grid-posts', [
						// 'title' => single_term_title('', false),
						'posts' => $wp_query->posts,
					])
					
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
