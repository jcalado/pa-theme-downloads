{!! get_header() !!}

@include('components.header.event-title')



  <div class="pa-content pb-5">
    <div class="container">
      <div class="calendar">
        <section class="col-auto col-md-12">     
          <div>
            @php
              use Tribe\Events\Views\V2\Template_Bootstrap;
            echo tribe( Template_Bootstrap::class )->get_view_html();
            @endphp
          </div>
        </section>
      </div>
    </div>
  </div>

@include('components.global.modal-report')

{!! get_footer() !!}
@php
die();
@endphp



