{!! get_header() !!}

@include('components.header.title')
@yield('content')

@include('components.global.modal-report')

{!! get_footer() !!}
