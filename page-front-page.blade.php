{{-- 
    Template name: Page - Front Page 
--}}

@extends('layouts.app')

@section('content')

<div class="pa-content py-5">
	<div class="container">

        {!! the_content() !!}

    </div>
</div>

@endsection
