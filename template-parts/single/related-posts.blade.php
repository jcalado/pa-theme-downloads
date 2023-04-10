@php
  $relatedPosts = getRelatedPosts(get_the_ID(), get_post_type())
@endphp

@notempty($relatedPosts)
  <div class="row mb-3 mb-xl-4">
    <div class="col-12 pa-widget">
      <h2 class="mb-0 mb-xl-2">{{ !empty($title) ? $title : __('Related files', 'iasd') }}</h2>
    </div>
  </div>

  <div class="row pa-blog-itens mb-4 mx-sm-0">
    <div class="pa-glide-related-posts pa-carousel-download pa-widget px-0">
      <div class="glide__track ps-1 ps-sm-0" data-glide-el="track">
        <div class="glide__slides ps-1 ps-sm-0">
          @foreach($relatedPosts as $post)
            <div class="glide__slide px-1 h-auto">
              <div class="card border-0 shadow-sm">
                <figure class="ratio ratio-16x9 bg-light rounded-bottom overflow-hidden mb-2">
                  <img src="{{ check_immg($post->ID, 'medium') }}" class="card-img-top"	alt="{!! wp_strip_all_tags(get_the_title($post->ID)) !!}" />
                </figure>

                <div class="card-body p-3 d-flex flex-column">
                  @notempty($department = getDepartment($post->ID))
                    <div>
                      <span class="pa-tag rounded-1 text-uppercase d-inline-block px-2 mb-2">{{ $department->name }}</span>
                    </div>
                  @endnotempty

                  <h3 class="card-title fw-bold h6 mb-3 pa-truncate-2">{!! wp_strip_all_tags(get_the_title($post->ID)) !!}</h3>

                  <div class="flex-grow-1"></div>
                  
                  <div>
                    <a 
                      href="{{ get_the_permalink($post->ID) }}" 
                      class="border border-1 px-4 py-1 rounded-pill btn-outline-primary text-uppercase fw-bold" 
                      title="{!! wp_strip_all_tags(get_the_title($post->ID)) !!}"
                    >
                    <?= __('View more', 'iasd')  ?>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
@endnotempty


