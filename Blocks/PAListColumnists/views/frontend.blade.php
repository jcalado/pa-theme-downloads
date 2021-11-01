@if(is_admin())
	<img class="img-preview" src="{{ get_stylesheet_directory_uri() }}/Blocks/PAListColumnists/preview.png"/>
@else
	<div class="pa-widget pa-w-list-columns col mb-5 col-md-4">
		@notempty($title)
			<h2>{!! $title !!}</h2>
		@endnotempty

		@notempty($items)
			<div class="mt-4">
				@foreach($items as $item)
					@php
						$key         = "user_{$item}"; 
						$avatar      = get_field('user_avatar', $key);
						$column_name = get_field('column_name', $key);
						$data        = get_userdata($item);

						if(!empty($avatar))
            				$avatar = !empty($small = wp_get_attachment_image_src($avatar, 'thumbnail')) ? $small[0]   : '';
					@endphp

					<div class="pa-author-item pa-blog-item">
						<a href="{{ get_author_posts_url($item) }}" title="{{ $data->display_name }}">
							<div class="row align-items-center">
								<div class="col-auto pe-3">
									<div class="ratio ratio-1x1">
										<figure class="figure m-0">
											<img src="{{ !empty($avatar) ? $avatar : 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNjAwIiBoZWlnaHQ9IjkwMCIgdmlld0JveD0iMCAwIDE2MDAgOTAwIj4KICA8cmVjdCBpZD0iUmV0w6JuZ3Vsb18xIiBkYXRhLW5hbWU9IlJldMOibmd1bG8gMSIgd2lkdGg9IjE2MDAiIGhlaWdodD0iOTAwIiBmaWxsPSIjOTA5MDkwIi8+Cjwvc3ZnPg==' }}" class="figure-img rounded-circle m-0 h-100 w-100" alt="{{ $data->display_name }}" />
										</figure>	
									</div>
								</div>

								<div class="col ps-1">
									<div class="card-body p-0">
										@notempty($data->display_name)
											<h3 class="fw-bold m-0">{!! $data->display_name !!}</h3>
										@endnotempty

										@notempty($column_name)
											<p class="pa-truncate-2 m-0">{!! $column_name !!}</p>
										@endnotempty
									</div>
								</div>
							</div>
						</a>
					</div>
				@endforeach
			</div>
		@endnotempty

		@notempty($enable_link)
			<a 
				href="{{ $link['url'] ?? '#' }}" 
				target="{{ $link['target'] ?? '_self' }}"
				class="pa-all-content"
			>
				{!! $link['title'] !!}
			</a>
		@endnotempty
	</div>
@endif