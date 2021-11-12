@notempty($downloads)
  <div id="accordion-kits" class="accordion-kits accordion accordion-flush">
    @foreach($downloads as $id)
      <div class="accordion-item shadow-sm mb-4">
        <h3 id="accordion-heading-{{ $loop->iteration }}" class="accordion-header">
          <button 
            class="accordion-button collapsed fw-bold" 
            type="button" data-bs-toggle="collapse" 
            data-bs-target="#accordion-collapse-{{ $loop->iteration }}" 
            aria-expanded="false" 
            aria-controls="accordion-collapse-{{ $loop->iteration }}"
            title="{!! wp_strip_all_tags(get_the_title($id)) !!}"
          >
            <div class="img-container me-3 me-lg-4">
              <div class="ratio">
                <figure class="figure m-0">
                  <img src="{{ check_immg($id, 'medium') }}" class="figure-img img-fluid rounded m-0 w-100 h-100 object-cover" alt="{!! wp_strip_all_tags(get_the_title($id)) !!}">
                </figure>	
              </div>
            </div>

            <span class="col p-0 me-3 pa-truncate-3">{!! wp_strip_all_tags(get_the_title($id)) !!}</span>
            
            <span class="accordion-kits__tag col-auto p-0 pe-2 d-none d-lg-flex text-primary">{!! __('Downloads', 'iasd') !!}</span>
          </button>
        </h3>

        <div id="accordion-collapse-{{ $loop->iteration }}" class="accordion-collapse collapse" aria-labelledby="accordion-heading-{{ $loop->iteration }}">
          <div class="accordion-body pt-1 pt-lg-3 pe-3 pe-lg-4 pb-3 pb-lg-4 ps-1 ps-lg-4">
            <div class="ps-2 pt-2 pt-lg-0">
              <p class="post-excerpt mb-4 pa-truncate-3">{!! get_the_excerpt($id) !!}</p>

              @include('template-parts.single.list-downloads', [
                'downloads' => get_field('downloads', $id),
              ])

              <div class="accordion-footer d-flex align-items-center justify-content-between">
                <div class="col pe-2 d-flex">
                  @include('components.global.link-report', [
                    'permalink' => get_the_permalink($id),
                  ])
                </div>

                <div class="col-auto d-flex">
                  <a href="{{ get_the_permalink($id) }}" role="button" class="accordion-kits__permalink text-primary fw-bold text-decoration-none col-auto">Acessar conteúdo<i class="fas fa-arrow-right ms-2"></i></a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    @endforeach
  </div>
@endnotempty
