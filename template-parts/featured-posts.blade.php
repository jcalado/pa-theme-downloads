@php
    global $exclude;
    $count = get_field('featured_layout');
    $count = !empty($count) ? $count : 1;
    $items = get_field("featured_items_{$count}")['data'];

    if(empty($items))
        $items = array();
    else 
        $items = array_column($items, 'id');

    if($count - count($items) > 0):
        $query = new WP_Query(
            array(
                'post_status'	      => 'publish',
                'ignore_sticky_posts' => 1,
                'post__not_in'        => $items,
                'posts_per_page'      => $count - count($items),
                'fields'              => 'ids',
                'post_type'           => isset($post_type) && !empty($post_type) ? $post_type : 'post',
            )
        );

        if(!empty($query->found_posts))
            $items = array_merge($items, $query->posts);
    endif;
    
    $exclude = $items;
@endphp

@notempty($items)
    <div class="row pa-widget pa-w-featured-post position-relative mb-5">
        @foreach($items as $item)
            @if(count($items) == 3)
                @if($loop->index == 0)
                    <div class="col-md-8">
                @elseif($loop->index == 1)
                    <div class="col-md-4">
                @endif
            @endif
            
            <div class="col-md-{{ count($items) == 1 || count($items) == 3 ? '12' : '6' }}">
                @php
                    $class = '';

                    if((count($items) == 3 && $loop->index == 1) || count($items) == 1)
                        $class = ' mb-3';
                    elseif(count($items) > 1)
                        $class = ' mb-3 mb-md-0';
                    else
                        $class = ' mb-3 pb-md-3 mb-md-4';
                @endphp

                <div class="pa-blog-itens{{ $class }}">    
                    <div class="pa-blog-feature">
                        <a href="{{ get_the_permalink($item) }}" title="{{ get_the_title($item) }}">
                            <div class="ratio {{ count($items) == 1 ? 'ratio-591x244' : 'ratio-16x9' }}">
                                <figure class="figure m-xl-0 w-100">
                                    <img src="{{ check_immg($item, 'full') }}" class="figure-img img-fluid m-0 rounded w-100 h-100 object-cover" alt="{{ get_the_title($item) }}" />

                                    <figcaption class="figure-caption position-absolute w-100 p-3 rounded-bottom">
                                        @notempty(getPostFormat($item))
                                            <span class="pa-tag rounded-1 text-uppercase mb-2 d-none d-md-table-cell px-2">{{ getPostFormat($item)->name }}</span>
                                        @endnotempty
                                        
                                        <h3 class="h5 pt-2 pa-truncate-2">{!! get_the_title($item) !!}</h3>
                                    </figcaption>
                                </figure>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            @if(count($items) == 3 && $loop->index == 0 || count($items) == 3 && $loop->index == 2)
                </div>
            @endif
        @endforeach
    </div>
@endnotempty