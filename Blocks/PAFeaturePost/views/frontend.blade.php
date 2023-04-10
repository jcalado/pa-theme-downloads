@if (is_admin())
  <img class="img-preview" src="{{ get_stylesheet_directory_uri() }}/Blocks/PAFeaturePost/preview.png" alt="{{ __('Illustrative image of the front end of the block.', 'iasd') }}"/>
@else
  <div class="col-lg-8">
    <div class="pa-blog-itens mb-5 pa-widget">    
      <h2 class="mb-3">{{ $title }}</h2>

      <div class="pa-blog-feature">
        <a href="{{ get_the_permalink($id) }}" title="{!! wp_strip_all_tags(get_the_title($id)) !!}">
          <div class="ratio ratio-16x9">
            <figure class="figure m-xl-0 w-100">
              <img src="{{ check_immg($id, 'full') }}" class="figure-img img-fluid m-0 rounded w-100 h-100 object-cover" alt="{!! wp_strip_all_tags(get_the_title($id)) !!}">

              <figcaption class="figure-caption position-absolute w-100 p-3 rounded-bottom">
                @notempty($department = getDepartment($id))
                  <span class="pa-tag rounded-1 text-uppercase mb-2 d-none d-md-inline-block px-2">{{ $department->name }}</span>
                @endnotempty
                
                <h3 class="h5 pt-2 pa-truncate-2">{!! get_the_title($id) !!}</h3>
              </figcaption>
            </figure>
          </div>
        </a>
      </div>
    </div>
  </div>
@endif
