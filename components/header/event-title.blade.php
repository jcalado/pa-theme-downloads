@php
  use IASD\Core\Settings\Modules;   
@endphp

@if(Modules::isActiveModule('headertitle'))
  <section class="pa-header py-3">
      <header class="container">
          <div class="row">
              <div class="col py-5">
                  <span class="pa-tag rounded-1 px-3 py-1 d-table-cell">{{ __('Adventist downloads', 'iasd') }}</span>
                  <h1 class="mt-2">Eventos</h1>
              </div>
          </div>
      </header>
  </section>
@endif
