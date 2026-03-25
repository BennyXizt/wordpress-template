<?php

class Custom_Post_Type {
    private $types = [
        // 'slug' => [
        //     'labels' => [
        //         'name'          => 'PluralLabel',
        //         'singular_name' => 'SingularLabel',
        //     ],
        //     'supports'      => ['title', 'editor', 'thumbnail'],
        //     'menu_icon'     => 'dashicons-testimonial',
        // ],
    ];

    public function __construct() {
        add_action('init', [$this, 'init']);
    }
    public function init() {
        foreach($this->types as $slug => $config) {
            register_post_type($slug, array_merge([
                'public'        => true,
                'show_in_rest'  => true, 
                'has_archive'   => true,
                'supports'      => ['title', 'editor', 'thumbnail'],
                'menu_icon'     => 'dashicons-editor-ul',
            ], $config));
        }
    }
}