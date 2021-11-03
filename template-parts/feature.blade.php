@notempty($post)
    <div class="pa-blog-itens mb-5">
        <h2 class="mb-4">{{ __('Feature', 'iasd') }}</h2>

        <div class="pa-blog-feature pa-w-list-videos">
            <a href="{{ get_the_permalink($post->ID) }}" title="{{ get_the_title($post->ID) }}">
                <div class="ratio ratio-16x9">
                    <figure class="figure m-xl-0 w-100">
                        <img src="{{ check_immg($post->ID, 'full') }}" class="figure-img img-fluid m-0 rounded w-100 h-100 object-cover" alt="{{ get_the_title($post->ID) }}">

                        @hasfield('video_length', $post->ID)
                            <div class="figure-caption position-absolute w-100 h-100 d-block">
                                <i class="fas fa-play position-absolute top-50 start-50 translate-middle pa-icon-play"></i>
                                <span class="pa-video-time position-absolute px-2 rounded-1">
                                    <i class="far fa-clock me-1" aria-hidden="true"></i> @videolength($post->ID)
                                </span>
                            </div>
                        @endfield
                    </figure>
                </div>
            </a>
        </div>
    </div>
@endnotempty
