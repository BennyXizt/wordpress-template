<?php

function mytheme_setup() {
    add_theme_support('editor-styles'); // gutenberg
    add_theme_support('post-thumbnails'); 
    add_theme_support('custom-logo', [
        'width' => 300,
        'height' => 100,
        'flex-width' => true,
        'flex-height' => true
    ]); // image single post

    add_filter('upload_mimes', function ($mimes) {

        if (current_user_can('administrator')) {
            $mimes['svg'] = 'image/svg+xml';
        }

        return $mimes;
    });

}
add_action('after_setup_theme', 'mytheme_setup');

add_action('init', function () {
    flush_rewrite_rules(); // ToDelete
});
