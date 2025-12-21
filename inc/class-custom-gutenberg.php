<?php

class Custom_Gutenberg {
    private $theme_id;
    private $block_category;
    private $section_category;

    public function __construct($theme_id = null) {
        if(!$theme_id) {
            $theme_id = sanitize_key(wp_get_theme()->get('Name'));
        }
        $this->theme_id = $theme_id;

        $this->block_category = 'block';
        $this->section_category = 'section';

        add_filter('block_categories_all', [$this, 'add_new_category'], 10, 1);
        add_filter('acf/fields/wysiwyg/toolbars', [$this, 'change_standart_tinymce_toolbal'], 10, 1);
        add_filter('tiny_mce_before_init', [$this, 'add_support_span'], 10, 1);
        add_action('acf/init', [$this, 'init']);
    }

    public function change_standart_tinymce_toolbal($toolbars) {
        if (isset($toolbars['Basic'][1])) {
            if (!in_array('styleselect', $toolbars['Basic'][1])) {
                array_unshift($toolbars['Basic'][1], 'styleselect');
            }
            if (!in_array('removeformat', $toolbars['Basic'][1])) {
                $toolbars['Basic'][1][] = 'removeformat';
            }
        }

        return $toolbars;
    }

    public function add_support_span($init) {
        $init['style_formats'] = json_encode([
            [
                'title' => 'Inline',
                'items' => [
                    [
                        'title' => 'Span',
                        'inline' => 'span',
                        'classes' => '',
                    ],
                    [
                        'title' => 'Span Highlight',
                        'inline' => 'span',
                        'classes' => 'highlight',
                    ],
                ]
            ]
        ]);

        return $init;
    }

    public function add_new_category($categories) {
        $custom = [
            [
                'slug' => $this->section_category,
                'title' => ucfirst($this->section_category),
                'icon' => null
            ],
            [
                'slug' => $this->block_category,
                'title' => ucfirst($this->block_category),
                'icon' => null
            ]
        ];

        $categories = array_filter($categories, function($cat) {
            return $cat['slug'] !== $this->block_category && $cat['slug'] !== $this->section_category;
        });

        return array_merge($custom, $categories);
    }

    public function init() {
        if( function_exists('acf_register_block_type') ) {
            $this->add_new_block('button-link');
        }
    }

    public function render_block_callback($block, $content = '', $is_preview = false, $post_id = 0) {
        $name = str_replace('acf/', '', $block['name']);

        $field_type = null;
        $has_content = false;

        $unallowedTypes = ['color_picker', 'button_group'];

        foreach($block['data'] as $key => $value) {
            $field_object = acf_get_field($key);

            if($field_object) {
                $field_type = $field_object['type'];
            }
                
            if(strpos($key, '_') === 0 || in_array($field_type, $unallowedTypes)) continue;

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

        $block_data  = $block;
        $inner_html  = $content;
        $preview     = $is_preview;
        $post_id     = $post_id;

        $template_file = get_template_directory() . "/template-parts/gutenberg/blocks/{$name}.php";

        if($has_content && file_exists($template_file)) {
            include $template_file;
        }
        else {
            $empty_template = get_template_directory() . "/template-parts/gutenberg/empty.php";
            include $empty_template;
        }
    }

    public function add_new_block($name) {
        acf_register_block_type(array(
            'name' => $name,
            'title' => ucfirst($name),
            'description' => sprintf(
                __('%s Block для Gutenberg с ACF', $this->theme_id),
                ucfirst($name)
            ),
            'render_callback' => [$this, 'render_block_callback'],
            'category' => $this->block_category,
            'icon' => 'welcome-widgets-menus',
            'keywords' => array( 'example', 'acf' ),
            'mode' => 'auto',
            'supports'        => [
                'align' => true,
                'jsx'   => true,
                // 'color' => [
                //     'text' => true,
                //     'background' => true
                // ],
                // 'typography' => [
                //     'fontSize' => true,
                //     'lineHeight' => true
                // ]
            ],
        ));
    }
    public function add_new_section($name) {
         acf_register_block_type(array(
            'name' => $name,
            'title' => ucfirst($name),
            'description' => sprintf(
                __('%s Section для Gutenberg с ACF', $this->theme_id),
                ucfirst($name)
            ),
            'render_template' => get_template_directory() . "/template-parts/gutenberg/sections/{$name}.php",
            'category' => $this->section_category,
            'icon' => 'screenoptions',
            'keywords' => array( 'example', 'acf' ),
            'mode' => 'auto',
            'supports'        => [
                'align' => true,
                'jsx'   => true,
            ],
        ));
    }
}