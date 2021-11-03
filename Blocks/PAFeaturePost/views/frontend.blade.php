@if (is_admin())
    <img class="img-preview" src="{{ get_stylesheet_directory_uri() }}/Blocks/PAFeaturePost/preview.png" alt="{{ __('Illustrative image of the front end of the block.', 'iasd') }}"/>
@else
    <div class="col-lg-8">
        <div class="pa-blog-itens mb-5">    
            <h2 class="mb-4">{{ $title }}</h2>

            <div class="pa-blog-feature pa-w-list-videos">
                
                <a href="{{ get_the_permalink($id) }}" title="{!! wp_strip_all_tags(get_the_title($id)) !!}">
                    <div class="ratio ratio-16x9">
                        <figure class="figure m-xl-0 w-100">
                            <img src="{{ check_immg($id, 'full') }}" class="figure-img img-fluid m-0 rounded w-100 h-100 object-cover" alt="{!! wp_strip_all_tags(get_the_title($id)) !!}">

                            @hasfield('video_length', $id)
                                <div class="figure-caption position-absolute w-100 h-100 d-block">
                                    <i class="fas fa-play position-absolute top-50 start-50 translate-middle pa-icon-play"></i>
                                    <span class="pa-video-time position-absolute px-2 rounded-1">
                                        <i class="far fa-clock me-1" aria-hidden="true"></i> @videolength($id)
                                    </span>
                                </div>
                            @endfield
                        </figure>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endif
