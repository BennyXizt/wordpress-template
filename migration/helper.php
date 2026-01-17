<?php
get_template_part('', null, [''=> '']); // include file
get_field(); // get a field from asf
esc_html($var); // text
esc_url($var); // href, src, action
esc_attr($var); // attr
wp_get_attachment_image($fields['image']['ID'], 'full', false, ['class'=>'']); // responsive img

// custom post
get_posts([
    'post_type'      => 'ExistedPostID',
    'posts_per_page' => 5,
    'post_status'    => 'publish',
]); // get post
setup_postdata($post);
wp_reset_postdata();


$id = $item->ID;
$title = get_the_title($id);
$content = get_the_content(null, false, $id);
$imageID = get_post_thumbnail_id($id);
$link = get_permalink($id);
// custom post

// term
$terms = get_the_terms($id, 'TaxonomySlug');
$term_link = get_term_link($term->term_id);


// link
$url = !empty($fields['link']['url']) ? 'href="'. esc_url($fields['link']['url']) .'"' : '';
$target = !empty($fields['link']['target']) ? 'target="'. esc_attr($fields['link']['target']) .'"' : '';
$linkLabel = esc_html($fields['link']['title']) ?? '';
$blockTypeLink = "a {$url} {$target}";

<a <?= $url . ' ' . $target ?>>
</a>
// link

// init Gutenberg block
$args = $args ?? null;

if($args) {
    $fields = [
        ''
    ];
}
else {
    $fields = [
        ''
    ];
}

// menu
$locations = get_nav_menu_locations();
$menuID = $locations['menuSlug'];
$mnenu = wp_get_nav_menu_items($menuID);
// menu

// custom logo
$custom_logo_id = get_theme_mod('custom_logo'); 
$logo_file = get_attached_file($custom_logo_id);

if($logo_file) {
    $logo_ext = pathinfo($logo_file, PATHINFO_EXTENSION);
    $logo_svg = file_get_contents($logo_file);
    $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
}
// custom logo

// array

// array