<?php
get_template_part('', null, [''=> '']); // include file
get_field(); // get a field from asf
esc_html($var); // text
esc_url($var); // href, src, action
esc_attr($var); // attr
wp_get_attachment_image($fields['image']['ID'], 'full', false, ['class'=>'']); // responsive img
get_theme_mod('CustomizeSettingsID'); // get value from customizer
get_template_directory(''); // path to a file
get_template_directory_uri(''); // link to a file

// get curr page link
global $wp;
$current_url = home_url(add_query_arg(array(), $wp->request)); 
// get curr page link

// custom post
$posts = get_posts([
    'post_type'      => 'ExistedPostTYPE',
    'posts_per_page' => 5,
    'post_status'    => 'publish',
    'suppress_filters' => false, // ломает pre_get_posts /Polylang /SEOPlugins
]); // get post
setup_postdata($post);
wp_reset_postdata();

$query = new WP_Query([
    'post_type'      => 'ExistedPostTYPE',
    'posts_per_page' => 5,
    'post_status'    => 'publish',
]); // alternative custom post but with more data
if ($query->have_posts()) :
    while ($query->have_posts()): $query->the_post();
wp_reset_postdata();
// global $post;
$id = $post->ID | get_the_ID();
$title = get_the_title($id);
$content = get_the_content(null, false, $id) | the_content();
$contentRAW = get_post_field('post_content', $post_id);
$imageID = get_post_thumbnail_id($id);
$categoryDefaultTaxonomy = get_the_category();
$link = get_permalink($id);
$date = get_the_date('d.m.Y', $id);
$datetime = get_the_date('Y-m-d', $id); 
$formatted_date = get_the_date('jS M Y', $id);
$terms = get_the_terms($id, 'TaxonomySlug');
$term_link = get_term_link($term->term_id);
// custom post

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

// get item from Customize
$sanitizedKey = sanitize_key(wp_get_theme()->get('Name') . 'ExistedCustomizeSettingID');
$item = get_theme_mod($sanitizedKey, '');
// get item from Customize
?>

// comments
<?php if (comments_open() || get_comments_number()) : ?>
    <?php comments_template(); ?>
<?php endif; ?>
// comments

// get category name from categories
<?php 
$categories = array_map(
    fn($e) => $e->name
    , array_filter(get_the_category(), fn($e) => !empty($e->name))
);
$category = implode(', ', $categories);
?>

// edit acf field in block 
<?php
echo acf_inline_text_editing_attrs( ‘my_text_field’ );
?>