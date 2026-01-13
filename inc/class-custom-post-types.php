<?php

class Custom_Post_Type {
    private $types = [
        'testimonial' => [
            'name'          => 'Testimonials',
            'singular_name' => 'Testimonial',
            'supports'      => ['title', 'editor', 'thumbnail'],
            'icon'          => 'dashicons-testimonial',
        ]
    ];

    public function __construct() {
        add_action('init', [$this, 'init']);
    }
    public function init() {
        foreach($this->types as $slug => $config) {
            register_post_type($slug, [
                'labels' => [
                    'name'          => $config['name'],
                    'singular_name' => $config['singular_name'],
                ],
                'public'        => true,
                'show_in_rest'  => true, 
                'has_archive'   => true,
                'supports'      => $config['supports'],
                'menu_icon'     => $config['icon'],
            ]);
        }
    }
}