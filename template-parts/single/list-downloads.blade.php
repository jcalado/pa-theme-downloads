@notempty($downloads)
  <table class="pa-downloads-table table table-hover">
    <thead>
      <tr>
        <th class="px-0 border-0 d-none d-lg-table-cell" scope="col">{{ __('Name', 'iasd') }}</th>

        <th class="px-3 border-0 d-none d-lg-table-cell" scope="col">{{ __('Size', 'iasd') }}</th>

        <th class="pa-downloads-table__fit px-0 border-0 text-end d-none d-lg-table-cell" scope="col">{{ __('Download', 'iasd') }}</th>

        <th class="px-0 border-0 d-block d-lg-none" scope="col">{{ __('Download files', 'iasd') }}</th>
      </tr>
    </thead> 

    <tbody>
      @foreach($downloads as $download)
        <tr>
          <td class="py-3 px-0 px-lg-3">
            <span class="pa-truncate-1" title="{!! $loop->iteration . '. ' . wp_strip_all_tags($download['name']) !!}">
              <span class="pa-tag rounded-1 text-uppercase d-inline-block px-1 me-2">{{ $download['format'] }}</span>
              {!! $loop->iteration . '. ' . wp_strip_all_tags($download['name']) !!}
            </span>
          </td>

          <td class="p-3">{{ $download['size'] . 'MB' }}</td>

          <td class="pa-downloads-table__fit py-3 px-0 px-lg-3 fw-bold">
            <a class="text-decoration-none" href="{{ $download['link'] }}" target="_blank">
              <i class="fas fa-download me-2"></i>
              
              <span class="d-none d-lg-inline-block">Baixar</span> 
            </a>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
@endnotempty
