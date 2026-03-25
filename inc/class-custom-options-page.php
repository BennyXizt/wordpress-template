<?php

class Custom_Options_Page {
    private $theme_id;
    private $options;
    public function __construct($theme_id = null) {
        if(!$theme_id) {
            $theme_id = sanitize_key(wp_get_theme()->get('Name'));
        }
        $this->theme_id = $theme_id;

        $this->options = [
            // 'slug' => [
            //     'menu_title'    => __('LabelForAsideMenu', $theme_id),
            //     'page_title'    => __('LabelForPage', $theme_id),
            //     'menu_slug'     => 'menuSlug',
            // ]
        ];

        add_action('acf/init', [$this, 'init']);
    }

    public function init() {
        if( function_exists('acf_add_options_page') ) {
            foreach($this->options as $config) {
                acf_add_options_page(array_merge([
                    'capability'    => 'edit_posts',
                    'redirect'      => false,
                    'position'      => 59,
                    'icon_url' => 'dashicons-admin-generic'
                ], $config));
            }
        }
    }
}