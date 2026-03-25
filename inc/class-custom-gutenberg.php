<?php

class Custom_Gutenberg {
    private $theme_id;
    private $block_category;
    private $blocks;

    public function __construct($theme_id = null) {
        if(!$theme_id) {
            $theme_id = sanitize_key(wp_get_theme()->get('Name'));
        }
        $this->theme_id = $theme_id;

        $this->block_category = 'block';

        $this->blocks = [
            'title-test' => [
                'title' => __('Title', $this->theme_id),
                'mode' => 'edit'
            ],
            'text-test' => [
                'title' => __('Text', $this->theme_id),
            ],
            'icon-test' => [
                'title' => __('Icon', $this->theme_id),
            ],
            'button-test' => [
                'title' => __('Button Link', $this->theme_id),
            ],
        ];

        add_action('acf/init', [$this, 'init']);
        add_action('enqueue_block_editor_assets', [$this, 'mytheme_gutenberg_editor_assets']);

        add_filter('block_categories_all', [$this, 'add_new_category'], 10, 1);
        add_filter('acf/fields/wysiwyg/toolbars', [$this, 'change_standart_tinymce_toolbal'], 10, 1);
        add_filter('tiny_mce_before_init', [$this, 'add_support_span'], 10, 1);
        
    }
    public function mytheme_gutenberg_editor_assets() {
        wp_enqueue_style('mytheme-editor-style', get_template_directory_uri() . '/assets/styles/css/editor-style.css', array(), wp_get_theme()->get('Version'));
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
            $this->add_new_blocks();
        }
    }

    public function render_template_callback($block, $content = '', $is_preview = false, $post_id = 0) {
        $name = str_replace('acf/', '', $block['name']);

        $field_type = null;
        $has_content = false;

        $unallowedTypes = ['color_picker', 'button_group'];

        if(!empty($block['data'])) {
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
        } else $has_content = true;

        if($block['category'] === $this->block_category) {
            $template_file = get_template_directory() . "/template-parts/gutenberg/blocks/{$name}.php";
        }
        else if($block['category'] === $this->section_category) {
            $template_file = get_template_directory() . "/template-parts/gutenberg/sections/{$name}.php";
        }

        $empty_template = get_template_directory() . "/template-parts/gutenberg/empty.php";

        if(file_exists($template_file)) {
            if($has_content) include $template_file;
            else {
                $localized_message = __('Gutenberg Block: заполните поля', $this->theme_id);
                include $empty_template;
            }
        }
        else {    
            $localized_message = __('Gutenberg Block: Block Template не найден<br><br>Path: ' . $template_file, $this->theme_id);
            include $empty_template;
        }
    }

    public function add_new_blocks() {
        foreach($this->blocks as $name => $config) {
            acf_register_block_type(array_merge([
                'name'              => $name,
                'description'       => __('ACF Block для Gutenberg', $this->theme_id),
                'render_callback'   => [$this, 'render_template_callback'],
                'category'          => $this->block_category,
                'icon'              => 'welcome-widgets-menus',
                'keywords'          => ['example', 'acf'],
                'mode'              => 'auto',
                'api_version'       => 3,
                'acf_block_version' => 3,
                'supports'          => [
                    'align'             => false,
                    'jsx'               => true,
                    'customClassName'   => false,
                ],
            ], $config));
        }
    }
}