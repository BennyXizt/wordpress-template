<?php


function mytheme_enqueue_assets_register() {
    wp_enqueue_style('theme-metadata', get_stylesheet_uri());
    wp_enqueue_style('custom-main-style', get_template_directory_uri() . '/assets/styles/index.css', [], wp_get_theme()->get('Version'));

    wp_enqueue_script('custom-main-js', get_template_directory_uri() . '/assets/js/index.js', [], wp_get_theme()->get('Version'), true);

    add_filter('script_loader_tag', function ($tag, $handle) {
        if ($handle === 'custom-main-js') {
            $tag = str_replace('<script ', '<script type="module" ', $tag);
        }
        return $tag;
    }, 10, 2);
}


add_action('wp_enqueue_scripts', 'mytheme_enqueue_assets_register');