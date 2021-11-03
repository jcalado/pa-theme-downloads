@if(is_admin())
	<img class="img-preview" src="{{ get_stylesheet_directory_uri() }}/Blocks/PAListVideosColumn/preview.png" alt="{{ __('Illustrative image of the front end of the block.', 'iasd') }}"/>
@else
	@notempty($items) 
		<div class="pa-widget pa-w-list-posts col-lg-4 pa-w-list-videos mb-5">			
			<h2 class="mb-4">{{ $title }}</h2>

			@foreach ($items as $id)
				<div class="card mb-35 mb-xl-4 border-0">
					<a href="{{ get_the_permalink($id) }}" title="{!! wp_strip_all_tags(get_the_title($id)) !!}">
						<div class="row">
							<div class="img-container">
								<div class="ratio ratio-16x9">
									<figure class="figure m-xl-0">
										<img src="{{ check_immg($id, 'medium') }}" class="figure-img img-fluid rounded m-0" alt="{!! wp_strip_all_tags(get_the_title($id)) !!}">

										@hasfield('video_length', $id)
											<div class="figure-caption position-absolute w-100 h-100 d-block">
												<span class="pa-video-time position-absolute px-2 rounded-1">
													<i class="far fa-clock me-1" aria-hidden="true"></i> @videolength($id)
												</span>
											</div>
										@endfield
									</figure>	
								</div>
							</div>
							<div class="col">
								<div class="card-body p-0">
									<h3 class="card-title h6 pa-truncate-3">{!! wp_strip_all_tags(get_the_title($id)) !!}</h3>
								</div>
							</div>
						</div>
					</a>
				</div>
			@endforeach

			@if(!empty($enable_link) && !empty($link))
				<a 
					href="{{ $link['url'] ?? '#' }}" 
					target="{{ $link['target'] ?? '_self' }}"
					class="pa-all-content"
				>
					{!! $link['title'] !!}
				</a>
			@endif
		</div>
	@endnotempty
@endif