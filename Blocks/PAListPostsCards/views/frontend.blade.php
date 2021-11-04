@if(is_admin())
	<img class="img-preview" src="{{ get_stylesheet_directory_uri() }}/Blocks/PAListPostsCards/preview.png" alt="{{ __('Illustrative image of the front end of the block.', 'iasd') }}"/>
@else
	@notempty($items) 
		<div class="pa-widget pa-w-list-posts-cards col-lg-4 mb-5">			
      @notempty($title) 
			  <h2 class="mb-4">{{ $title }}</h2>
      @endnotempty

      @foreach ($items as $id)
        <div class="card mb-0 mt-3 border-0 shadow-sm p-3">
          <div class="row align-items-center">
            <div class="img-container">
              <div class="ratio ratio-214x137">
                <figure class="figure m-xl-0">
                  <img src="{{ check_immg($id, 'medium') }}" class="figure-img img-fluid rounded m-0" alt="{!! wp_strip_all_tags(get_the_title($id)) !!}">
                </figure>	
              </div>
            </div>
          
            <div class="col ps-1">
              <div class="card-body p-0">
                <h3 class="card-title h6 pa-truncate-2 fw-bold m-0">
                  <a class="stretched-link" href="{{ get_the_permalink($id) }}" title="{!! wp_strip_all_tags(get_the_title($id)) !!}">
                    {!! wp_strip_all_tags(get_the_title($id)) !!}
                  </a>
                </h3>
              </div>
            </div>
          </div>
        </div>
      @endforeach

			@if(!empty($enable_link) && !empty($link))
				<a 
					href="{{ $link['url'] ?? '#' }}" 
					target="{{ $link['target'] ?? '_self' }}"
					class="pa-all-content d-inline-block mt-4"
				>
					{!! $link['title'] !!}
				</a>
			@endif
		</div>
	@endnotempty
@endif
