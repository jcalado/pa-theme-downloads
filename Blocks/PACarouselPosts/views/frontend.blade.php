@if(is_admin())
	<img class="img-preview" src="{{ get_stylesheet_directory_uri() }}/Blocks/PACarouselPosts/preview.png" alt='{{ __('Illustrative image of the front end of the block.', 'iasd') }}'/>
@else 
  @notempty($items) 
    <div class="pa-widget pa-carousel-download col-12 mb-5">
      <div class="pa-glide-videos">
        @notempty($title)
          <div class="d-flex mb-4">
            <h2 class="flex-grow-1">{!! $title !!}</h2>	

            @if(count($items) > 1)
              <div class="pa-slider-controle d-none d-sm-flex justify-content-between justify-content-xl-start align-items-center">
                <div data-glide-el="controls">
                  <span class="fa-stack" data-glide-dir="&lt;">
                    <i class="fas fa-circle fa-stack-2x"></i>
                    <i class="icon fas fa-arrow-left fa-stack-1x"></i>
                  </span>
                </div>

                <div data-glide-el="controls">
                  <span class="fa-stack" data-glide-dir="&gt;">
                    <i class="fas fa-circle fa-stack-2x"></i>
                    <i class="icon fas fa-arrow-right fa-stack-1x"></i>
                  </span>
                </div>
              </div>
            @endif
          </div>
        @endnotempty
        
        <div class="glide__track" data-glide-el="track">
          <div class="glide__slides">
            @foreach($items as $id)
              <div class="glide__slide">
                <div class="card border-0">
                  <figure class="ratio ratio-16x9 bg-light rounded-bottom overflow-hidden mb-2">
                    <img src="{{ check_immg($id, 'medium') }}" class="card-img-top"	alt="{!! wp_strip_all_tags(get_the_title($id)) !!}" />
                  </figure>

                  <div class="card-body p-0">
                    @notempty($department = getDepartment($id))
                      <span class="pa-tag rounded-1 text-uppercase d-inline-block px-2 mb-2">{{ $department->name }}</span>
                    @endnotempty

                    <h3 class="card-title fw-bold h6 mb-3 pa-truncate-2">{!! wp_strip_all_tags(get_the_title($id)) !!}</h3>
                    
                    <a href="{{ get_the_permalink($id) }}" class="border border-1 px-4 py-1 rounded-pill btn-outline-primary text-uppercase fw-bold" title="{!! wp_strip_all_tags(get_the_title($id)) !!}">
                      Ver mais
                    </a>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  @endnotempty
@endif
