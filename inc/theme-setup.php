<?php

function mytheme_setup() {
    add_theme_support('post-thumbnails'); 

    add_filter('upload_mimes', function ($mimes) {

        if (current_user_can('administrator')) {
            $mimes['svg'] = 'image/svg+xml';
        }

        return $mimes;
    });

}
add_action('after_setup_theme', 'mytheme_setup');
