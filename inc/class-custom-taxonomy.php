<?php

class Custom_Taxonomy {
    private $types = [
        // 'slug' => [
        //     'postTypes'     => ['slugOfPostType'],
        //     'data' => [
        //         'labels'        => [
        //             'name'              => 'Categories',
        //             'singular_name'     => 'Category',
        //             'search_items'      => 'Search Categories',
        //             'all_items'         => 'All Categories',
        //             'edit_item'         => 'Edit Category',
        //             'add_new_item'      => 'Add New Category',
        //             'menu_name'         => 'Categories',
        //         ],
        //         'hierarchical' => false,
        //         'rewrite' => ['slug' => 'services/type']
        //     ]
        // ],
    ];

    public function __construct() {
        add_action('init', [$this, 'init']);
    }
    public function init() {
        foreach($this->types as $slug => $config) {
            register_taxonomy($slug, $config['postTypes'], array_merge($config['data'], [
                'show_ui'      => true,
                'show_admin_column' => true,
                'show_in_rest' => true, 
            ]));
        }
    }
}