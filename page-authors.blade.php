{{-- 
    Template name: Page - Authors
--}}

@extends('layouts.app')

@section('content')

<div class="pa-content py-5">
	<div class="container">
        <div class="row justify-content-{{ is_active_sidebar('archive-authors') ? 'between' : 'center' }}">
            <div class="col-12 col-xl-7{{ is_active_sidebar('archive-authors') ? ' pe-xl-4' : '' }}">
                <load-more 
                    template="card-post" 
                    url="{{ get_rest_url(null, 'wp/v2/columnists') }}"
                    args="{{ '_fields=name,link,column,avatar.medium&per_page=10&orderby=id' }}"
                    nonce="{{ wp_create_nonce('wp_rest') }}"
                >
                    <template id="card-post">
                        <card-author *foreach="@{{this.items}}" .author="@{{item}}"></card-author>
                    </template>
                </load-more>
            </div>

            @if(is_active_sidebar('archive-authors'))
                <aside class="col-md-4 d-none d-xl-block">
                    @php(dynamic_sidebar('archive-authors'))
                </aside>
            @endif
        </div>
    </div>
</div>

@endsection
