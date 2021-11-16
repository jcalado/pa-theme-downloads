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
                  <a href="#" class="text-primary text-decoration-none d-inline-flex align-items-center"><svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="info-circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-info-circle fa-w-16 fa-lg me-2"><path fill="currentColor" d="M256 8C119.043 8 8 119.083 8 256c0 136.997 111.043 248 248 248s248-111.003 248-248C504 119.083 392.957 8 256 8zm0 448c-110.532 0-200-89.431-200-200 0-110.495 89.472-200 200-200 110.491 0 200 89.471 200 200 0 110.53-89.431 200-200 200zm0-338c23.196 0 42 18.804 42 42s-18.804 42-42 42-42-18.804-42-42 18.804-42 42-42zm56 254c0 6.627-5.373 12-12 12h-88c-6.627 0-12-5.373-12-12v-24c0-6.627 5.373-12 12-12h12v-64h-12c-6.627 0-12-5.373-12-12v-24c0-6.627 5.373-12 12-12h64c6.627 0 12 5.373 12 12v100h12c6.627 0 12 5.373 12 12v24z"></path></svg>Reportar problema</a>
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
