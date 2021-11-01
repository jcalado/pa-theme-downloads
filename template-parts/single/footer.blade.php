<footer class="mb-5">
    @if(!empty($format = getPostFormat(get_the_ID())) && $format->slug == 'artigo' && is_singular('post'))
        @php
            $previous = get_previous_post(true, '', 'xtt-pa-format');   
            $next = get_next_post(true, '', 'xtt-pa-format');
        @endphp

        <div class="row align-items-center">
            <div class="col col-xl-4 order-2 order-xl-1">
                @notempty($previous)
                    <a class="pa-post-link text-decoration-none" href="{{ get_permalink($previous) }}"><i class="fas fa-arrow-left me-3"></i>Artigo anterior</a>
                @endnotempty
            </div>
            
            <div class="col-12 col-xl-4 pa-share pa-share-footer text-center order-1 order-xl-2 mb-4 mb-xl-0">
                @php require(get_template_directory() . '/components/parts/share.php') @endphp
            </div>

            <div class="col col-xl-4 text-end order-3">
                {{-- @notempty($next) --}}
                    <a class="pa-post-link text-decoration-none" href="{{ get_permalink($next) }}">Próximo artigo<i class="fas fa-arrow-right ms-3"></i></a>
                {{-- @endnotempty --}}
            </div>
        </div>

        <div class="row mt-4 mt-xl-5 pt-xl-2">
            <div class="col-12 mt-xl-1">
                @include('components.cards.card-author', ['id' => get_the_author_meta('ID')])
            </div>
        </div>
    @endif

    @if(comments_open()) 
        {!! comments_template() !!}
    @endif
</footer>