<?php

namespace Blocks;

use Blocks\PACarouselVideos\PACarouselVideos;
use Blocks\PAFeaturePost\PAFeaturePost;
use Blocks\PAListPostsColumn\PAListPostsColumn;

class ChildBlocks
{


    public function __construct()
    {
        \add_filter('acf_gutenblocks/blocks', [$this, 'registerChildBlocks']);
        \add_action('enqueue_block_editor_assets', [$this, 'enqueueAssets']);
    }

    /**
     */
    public function registerChildBlocks(array $blocks): array
    {
        $newBlocks = [
            PAFeaturePost::class,
            PAListPostsColumn::class,
            PACarouselVideos::class
        ];

        return array_merge($blocks, $newBlocks);
    }

    function enqueueAssets()
    {
        wp_enqueue_style('child-blocks-stylesheet', THEME_URI . 'Blocks/assets/styles/blocks.css', array(), \wp_get_theme()->get('Version'), 'all');
    }
}
