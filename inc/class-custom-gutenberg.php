<?php

class Custom_Gutenberg {
    private $theme_id;
    private $block_category;

    public function __construct($theme_id = null) {
        if(!$theme_id) {
            $theme_id = sanitize_key(wp_get_theme()->get('Name'));
        }
        $this->theme_id = $theme_id;

        $this->block_category = 'block';

        add_filter('block_categories_all', [$this, 'add_new_category'], 10, 1);
        add_action('acf/init', [$this, 'init']);
    }

    public function add_new_category($categories) {
        $custom = [
            [
                'slug' => $this->block_category,
                'title' => ucfirst($this->block_category),
                'icon' => null
            ]
        ];

        $categories = array_filter($categories, function($cat) {
            return $cat['slug'] !== $this->block_category;
        });

        return array_merge($custom, $categories);
    }

    public function init() {
        if( function_exists('acf_register_block_type') ) {
            // $this->add_new_section('name');
        }
    }

    public function render_callback($block, $content = '', $is_preview = false, $post_id = 0) {
        $name = str_replace('acf/', '', $block['name']);

        $has_content = false;

        foreach($block['data'] as $key => $value) {
            if(strpos($key, '_') === 0) continue;
            if (is_array($value)) {
                if (!empty(array_filter($value))) {
                    $has_content = true;
                    break;
                }
            } elseif ($value !== '' && $value !== null) {
                $has_content = true;
                break;
            }
        }

        $template_file = get_template_directory() . "/template-parts/gutenberg-blocks/{$name}.php";

        if($has_content && file_exists($template_file)) {
            include $template_file;
        }
        else {
            $empty_template = get_template_directory() . "/template-parts/gutenberg-blocks/empty-block.php";
            include $empty_template;
        }
    }

    public function add_new_section($name) {
        acf_register_block_type(array(
            'name' => $name,
            'title' => ucfirst($name),
            'description' => sprintf(
                __('%s Block для Gutenberg с ACF', $this->theme_id),
                ucfirst($name)
            ),
            'render_callback' => [$this, 'render_callback'],
            'category' => $this->block_category,
            'icon' => 'welcome-widgets-menus',
            'keywords' => array( 'example', 'acf' ),
            'mode' => 'auto',
            'supports'        => [
                'align' => true,
                'jsx'   => true,
            ],
        ));
    }
}