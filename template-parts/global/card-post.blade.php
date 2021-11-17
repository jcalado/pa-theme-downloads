@notempty($post)
  <div class="pa-blog-item mb-4 shadow-sm rounded p-3 position-relative">
    <div class="row align-items-center align-items-xl-start">
      @if(has_post_thumbnail($post))
        <div class="img-container">
          <div class="ratio ratio-214x137">
            <figure class="figure m-xl-0">
              <img src="{{ check_immg($post->ID, 'medium') }}" class="figure-img img-fluid rounded m-0 h-100 w-100" alt="{!! wp_strip_all_tags(get_the_title($post->ID)) !!}">
            </figure>	
          </div>
        </div>
      @endif

      <div class="col">
        <div class="card-body {{ has_post_thumbnail($post) ? 'p-0' : 'ps-4 pe-0 py-4 border-start border-5 pa-border' }}">
          <h3 class="card-title fw-bold h6 pa-truncate-2 m-0 mb-xl-1 mt-xl-3">
            <a href="{{ get_the_permalink($post->ID) }}" class="stretched-link" title="{!! wp_strip_all_tags(get_the_title($post->ID)) !!}">
              {!! wp_strip_all_tags(get_the_title($post->ID)) !!}
            </a>
          </h3>

          <div class="d-none d-sm-block">
            <p class="pa-truncate-1">{!! get_the_excerpt($post->ID) !!}</p>
          </div>

          <a href="{{ get_the_permalink($post->ID) }}" class="d-none d-sm-inline-block pa-see-more border border-1 px-4 py-1 rounded-pill btn-outline-primary text-uppercase fw-bold" title="{!! wp_strip_all_tags(get_the_title($post->ID)) !!}">
            Ver mais
          </a>
        </div>
      </div>
    </div>    
  </div>
@endnotempty
