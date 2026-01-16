<?php

require_once get_template_directory() . '/inc/globals.php';
require_once get_template_directory() . '/inc/scripts.php';
require_once get_template_directory() . '/inc/utils.php';
require_once get_template_directory() . '/inc/menus.php';
require_once get_template_directory() . '/inc/class-custom-customize.php';
require_once get_template_directory() . '/inc/class-custom-gutenberg.php';
require_once get_template_directory() . '/inc/class-custom-post-types.php';


add_action('after_setup_theme', function() {
    new Custom_Customize();
    new Custom_Gutenberg();
    new Custom_Post_Type();
});