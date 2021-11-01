<?php

namespace Blocks;

use Blocks\PAContact\PAContact;
use Blocks\PAListColumnists\PAListColumnists;
use Blocks\PAListPosts\PAListPosts;
use Blocks\PAListPosts\PAListPress;

class ChildBlocks {

    public function __construct() {
        \add_filter('acf_gutenblocks/blocks', [$this, 'registerChildBlocks']);
        \add_action('enqueue_block_editor_assets', [$this, 'enqueueAssets']);
    }

    /**
     */
    public function registerChildBlocks(array $blocks): array {
        $newBlocks = [
            PAContact::class,
            PAListColumnists::class,
            PAListPosts::class,
            PAListPress::class,
        ];

        return array_merge($blocks, $newBlocks);
    }

    function enqueueAssets() {
        wp_enqueue_style('child-blocks-stylesheet', THEME_URI . 'Blocks/assets/styles/blocks.css', array(), \wp_get_theme()->get('Version'), 'all');
    }

}
