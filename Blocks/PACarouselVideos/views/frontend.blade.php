@if(is_admin())
    <img class="img-preview" src="{{ get_stylesheet_directory_uri() }}/Blocks/PACarouselVideos/preview.png" alt="{{ __('Illustrative image of the front end of the block.', 'iasd') }}"/>
@else
    @notempty($items) 
        <div class="pa-widget pa-w-carousel-videos col-12 mb-5">
            <div class="pa-glide-videos">
                {{-- Controls --}}            
                <div class="pa-slider-controle d-flex align-items-center mb-4">
                    <h2 class="flex-grow-1">{!! $title !!}</h2>	

                    <div class="d-none d-xl-block" data-glide-el="controls">
                        <span class="fa-stack" data-glide-dir="&lt;">
                            <i class="fas fa-circle fa-stack-2x"></i>
                            <i class="icon fas fa-arrow-left fa-stack-1x"></i>
                        </span>
                    </div>
                    
                    <div class="d-none d-xl-block" data-glide-el="controls">
                        <span class="fa-stack" data-glide-dir="&gt;">
                            <i class="fas fa-circle fa-stack-2x"></i>
                            <i class="icon fas fa-arrow-right fa-stack-1x"></i> 
                        </span>
                    </div>
                </div>
                
                {{-- Carousel --}}
                <div class="glide__track" data-glide-el="track">
                    <div class="glide__slides">    
                        {{-- Items --}}
                        @foreach($items as $id)
                            <div class="glide__slide">
                                <a href="{{ get_the_permalink($id) }}" title="{!! wp_strip_all_tags(get_the_title($id)) !!}">
                                    <div class="ratio ratio-16x9 mb-2">
                                        <figure class="figure">
                                            <img src="{{ check_immg($id, 'medium') }}" class="figure-img img-fluid rounded m-0" alt="{!! wp_strip_all_tags(get_the_title($id)) !!}">
                                            
                                            @hasfield('video_length', $id)
                                                <div class="figure-caption position-absolute w-100 h-100 d-block">
                                                    <span class="pa-video-time position-absolute px-2 rounded-1">
                                                        <i class="far fa-clock me-1" aria-hidden="true"></i> @videolength($id)
                                                    </span>
                                                </div>
                                            @endfield
                                        </figure>
                                    </div>

                                    <h3 class="card-title fw-bold h6">{!! wp_strip_all_tags(get_the_title($id)) !!}</h3>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endnotempty
@endif
