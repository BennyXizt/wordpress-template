<?php

class Custom_Customize {
    private $theme_id;
    public function __construct($theme_id = null) {
        if(!$theme_id) {
            $theme_id = sanitize_key(wp_get_theme()->get('Name'));
        }
        $this->theme_id = $theme_id;
        add_action('customize_register', [$this, 'init']);

        $this->allow_custom_logo();
    }
    private function allow_custom_logo() {
        add_theme_support('custom-logo', array(
            'width' => 300,
            'height' => 100,
            'flex-width' => true,
            'flex-height' => true
        ));
    }
    public function init($wp_customize) {
        $this->site_identity_keywords_register($wp_customize);
        $this->site_identity_site_owner($wp_customize);
    }
    private function site_identity_keywords_register($wp_customize) {
        $wp_customize->add_setting($this->theme_id . '_header_keywords', [
            'default' => 'wordpress, blog',
            'sanitize_callback' => 'sanitize_text_field'
        ]);

        $wp_customize->add_control($this->theme_id . '_header_keywords', [
            'label' => __('Meta Keywords', $this->theme_id),
            'section' => 'title_tagline',
            'type' => 'text'
        ]);
    }
    private function site_identity_site_owner($wp_customize) {
        $wp_customize->add_setting($this->theme_id . '_header_site_owner', [
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field'
        ]);

        $wp_customize->add_control($this->theme_id . '_header_site_owner', [
            'label' => __('Site Owner', $this->theme_id),
            'section' => 'title_tagline',
            'type' => 'text'
        ]);
    }
}
