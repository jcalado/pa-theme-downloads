<div class="post-info container-fluid px-0">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-md-8">
        <div class="row align-items-center">
          <div class="img-container mb-3 mb-xl-0">
            <div class="ratio ratio-56x31">
              <figure class="figure m-xl-0">
                <img src="{{ check_immg(get_the_ID(), 'medium') }}" class="figure-img img-fluid rounded m-0 w-100 h-100 object-cover" alt="{!! wp_strip_all_tags(get_the_title()) !!}">
              </figure>	
            </div>
          </div>

          <div class="col">
            <h2 class="post-info__title border-0 p-0 fw-bold m-o">{!! wp_strip_all_tags(get_the_title()) !!}</h2>

            <hr />

            <div class="row align-items-center justify-content-between">
              <div class="pa-post-meta col-auto order-1"><i class="far fa-calendar me-2"></i>{!! get_the_date() !!}</div>

              <div class="pa-share col-auto order-3 order-xl-2 mt-2 mt-xl-0">
                @php require(get_template_directory() . '/components/parts/share.php') @endphp
              </div>

              @notempty($tag = getPrioritySeat(get_the_ID()))
                <span class="post-info__tag col-12 mt-2 order-2 order-xl-3">{{ $tag->name }}</span>
              @endnotempty
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
