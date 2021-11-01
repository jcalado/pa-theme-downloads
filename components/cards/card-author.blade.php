@notempty($id)
    @php
        $key            = "user_{$id}"; 
        $avatar         = get_field('user_avatar', $key);
        $description    = get_user_meta($id, 'description', true);
        $facebook       = get_field('facebook', $key);
        $twitter        = get_field('twitter', $key);
        $instagram      = get_field('instagram', $key);
        $column_name    = get_field('column_name', $key);
        $column_excerpt = get_field('column_excerpt', $key);
        $data           = get_userdata($id);

        if(!empty($avatar))
            $avatar = !empty($small = wp_get_attachment_image_src($avatar, 'thumbnail')) ? $small[0]   : '';
    @endphp

    <div class="pa-card-author d-flex flex-column flex-lg-row">
        <div class="col-auto align-items-center d-flex flex-column mb-4 mb-lg-0">
            <div class="ratio ratio-1x1">
                <figure class="figure m-0">
                    <img src="{{ !empty($avatar) ? $avatar : 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNjAwIiBoZWlnaHQ9IjkwMCIgdmlld0JveD0iMCAwIDE2MDAgOTAwIj4KICA8cmVjdCBpZD0iUmV0w6JuZ3Vsb18xIiBkYXRhLW5hbWU9IlJldMOibmd1bG8gMSIgd2lkdGg9IjE2MDAiIGhlaWdodD0iOTAwIiBmaWxsPSIjOTA5MDkwIi8+Cjwvc3ZnPg==' }}" class="figure-img rounded-circle m-0 h-100 w-100" alt="{{ $data->display_name }}" />
                </figure>	
            </div>

            <h4 class="pa-card-author__title fw-bold mt-3 pt-1 mt-lg-4 pt-lg-0 mb-0">{{ $data->display_name }}</h4>
        </div>

        <div class="pa-card-author__data col text-center text-lg-start d-flex flex-column">
            @notempty($column_name)
                <h3 class="pa-card-author__column-name fw-bold mb-2 order-2 order-lg-1">{!! $column_name !!}</h3>
            @endnotempty

            @notempty($column_excerpt)
                <p class="pa-card-author__column-excerpt mb-4 mb-lg-2 order-3 order-lg-2">{!! $column_excerpt !!}</p>
            @endnotempty

            @notempty($description)
                <p class="pa-card-author__description m-0 order-4 order-lg-3">{!! $description !!}</p>
            @endnotempty

            <div class="pa-card-author__social order-1 order-lg-4 mb-4 m-lg-0 mt-lg-4">
                @notempty($facebook)
                    <a href="{{ $facebook }}" target="_blank" rel="noopener noreferrer"><i class="fab fa-facebook-f" aria-hidden="true"></i></a>
                @endnotempty
                @notempty($twitter)
                    <a href="{{ $twitter }}" target="_blank" rel="noopener noreferrer"><i class="fab fa-twitter" aria-hidden="true"></i></a>
                @endnotempty
                @notempty($instagram)
                    <a href="{{ $instagram }}" target="_blank" rel="noopener noreferrer"><i class="fab fa-instagram" aria-hidden="true"></i></a>
                @endnotempty
            </div>
        </div>
    </div>
@endnotempty