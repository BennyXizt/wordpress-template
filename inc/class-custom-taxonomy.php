<?php

class Custom_Taxonomy {
    private $types = [
        'SLUG' => [
            'postTypes'     => ['CustomPostTypeSlug'],
            'labels'        => [
                'name'              => 'Label',
                'singular_name'     => 'SingularLabel',
                'search_items'      => 'SearchLabel',
                'all_items'         => 'AllLabel',
                'edit_item'         => 'EditLabel',
                'add_new_item'      => 'AddNewLabel',
                'menu_name'         => 'MenuLabel',
            ],
            'hierarchical' => true,
            'rewrite' => ['slug' => 'InternetBrowserLink']
        ]
    ];

    public function __construct() {
        add_action('init', [$this, 'init']);
    }
    public function init() {
        foreach($this->types as $slug => $config) {
            register_taxonomy($slug, $config['postTypes'], [
                'labels' => $config['labels'],
                'hierarchical' => $config['hierarchical'],
                'show_ui'      => true,
                'show_admin_column' => true,
                'rewrite'      => $config['rewrite'],
                'show_in_rest' => true, 
            ]);
        }
    }
}