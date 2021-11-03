@notempty($posts)
    <div class="pa-blog-itens mb-4">
        {{-- <h2 class="mb-4">{{ isset($title) ? $title : single_term_title() }}</h2> --}}
        
        <div class="row pa-w-list-videos">
            @foreach($posts as $post)
                <div class="pa-blog-item mb-4 mb-md-4 border-0 col-12 col-md-4 position-relative">
                    <div class="ratio ratio-16x9 mb-2">
                        <figure class="figure">
                            <img src="{{ check_immg($post->ID, 'medium') }}" class="figure-img img-fluid rounded m-0 w-100 h-100 object-cover" alt="{{ get_the_title($post->ID) }}">

                            @hasfield('video_length', $post->ID)
                                <div class="figure-caption position-absolute w-100 h-100 d-block">
                                    <span class="pa-video-time position-absolute px-2 rounded-1">
                                        <i class="far fa-clock me-1" aria-hidden="true"></i> @videolength($post->ID)
                                    </span>
                                </div>
                            @endfield
                        </figure>	
                    </div>

                    <a class="stretched-link" href="{{ get_the_permalink($post->ID) }}" title="{{ get_the_title($post->ID) }}">
                        <h3 class="card-title fw-bold h6 pa-truncate-2">{!! get_the_title($post->ID) !!}</h3>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endnotempty