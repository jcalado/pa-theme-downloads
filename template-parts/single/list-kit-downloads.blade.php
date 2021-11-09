@notempty($downloads)
  <div id="accordion-kits" class="accordion-kits accordion accordion-flush">
    @foreach($downloads as $id)
      <div class="accordion-item shadow-sm">
        <h3 id="accordion-heading-{{ $loop->iteration }}" class="accordion-header">
          <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#accordion-collapse-{{ $loop->iteration }}" aria-expanded="false" aria-controls="accordion-collapse-{{ $loop->iteration }}">
            <div class="img-container me-3 me-lg-4">
              <div class="ratio">
                <figure class="figure m-0">
                  <img src="{{ check_immg($id, 'medium') }}" class="figure-img img-fluid rounded m-0 w-100 h-100 object-cover" alt="{!! wp_strip_all_tags(get_the_title($id)) !!}">
                </figure>	
              </div>
            </div>

            <span class="col p-0">{!! wp_strip_all_tags(get_the_title($id)) !!}</span>
            
            <span class="col-auto p-0 pe-2 d-none d-lg-flex">{!! __('Downloads', 'iasd') !!}</span>
          </button>
        </h3>

        <div id="accordion-collapse-{{ $loop->iteration }}" class="accordion-collapse collapse" aria-labelledby="accordion-heading-{{ $loop->iteration }}" data-bs-parent="#accordion-kits">
          <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the first item's accordion body.</div>
        </div>
      </div>
    @endforeach
  </div>
@endnotempty
