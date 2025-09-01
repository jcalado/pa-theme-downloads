@if(is_admin())
	<img class="img-preview" src="{{ get_stylesheet_directory_uri() }}/Blocks/PAListLinks/preview.png" alt="{{ __('Illustrative image of the front end of the block.', 'downloads') }}" />
@else
	@notempty($items) 
		<div class="pa-widget pa-w-list-links col-lg-4 mb-5">	
      @notempty($title)		
			  <h2 class="mb-4">{{ $title }}</h2>
      @endnotempty

      <div class="row">
        @foreach($items as $item)
          <div class="col-12 mb-3">
            <a 
              href="{{ $item['link']['url'] }}" 
              target="{{ !empty($item['link']['target']) ? $item['link']['target'] : '_self' }}"
              title="{!! wp_strip_all_tags($item['link']['title']) !!}"
              class="pa-truncate-1 ms-4"
            >
              {!! wp_strip_all_tags($item['link']['title']) !!}
            </a>
          </div>
        @endforeach
      </div>
		</div>
	@endnotempty
@endif
