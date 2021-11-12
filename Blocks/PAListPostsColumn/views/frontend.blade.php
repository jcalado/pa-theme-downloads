@if(is_admin())
	<img class="img-preview" src="{{ get_stylesheet_directory_uri() }}/Blocks/PAListPostsColumn/preview.png" alt="{{ __('Illustrative image of the front end of the block.', 'iasd') }}"/>
@else
	@notempty($items) 
		<div class="pa-widget pa-w-list-posts pa-w-list-posts-column col-lg-4 mb-5">			
			<h2 class="mb-3">{{ $title }}</h2>

      <div class="row">
        @foreach ($items as $id)
          <div class="card col-12 mb-3 border-0">
            <a href="{{ get_the_permalink($id) }}" title="{!! wp_strip_all_tags(get_the_title($id)) !!}">
              <div class="row">
                <div class="img-container">
                  <div class="ratio ratio-56x31">
                    <figure class="figure m-xl-0">
                      <img src="{{ check_immg($id, 'medium') }}" class="figure-img img-fluid rounded m-0" alt="{!! wp_strip_all_tags(get_the_title($id)) !!}">
                    </figure>	
                  </div>
                </div>
                <div class="col ps-1">
                  <div class="card-body p-0">
                    @notempty($department = getDepartment($id))
                      <span class="pa-tag rounded-1 text-uppercase d-inline-block px-2 mb-1">{{ $department->name }}</span>
                    @endnotempty

                    <h3 class="card-title h6 pa-truncate-3 fw-bold m-0">{!! wp_strip_all_tags(get_the_title($id)) !!}</h3>
                  </div>
                </div>
              </div>
            </a>
          </div>
        @endforeach
      </div>

			@if(!empty($enable_link) && !empty($link))
				<a 
					href="{{ $link['url'] ?? '#' }}" 
					target="{{ $link['target'] ?? '_self' }}"
					class="pa-all-content d-inline-block mt-1"
				>
					{!! $link['title'] !!}
				</a>
			@endif
		</div>
	@endnotempty
@endif
