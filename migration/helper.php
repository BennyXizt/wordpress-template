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
// custom post

// link
$url = !empty($fields['link']['url']) ? 'href="'. esc_url($fields['link']['url']) .'"' : '';
$target = !empty($fields['link']['target']) ? 'target="'. esc_attr($fields['link']['target']) .'"' : '';
$linkLabel = esc_html($fields['link']['title']) ?? '';
$blockTypeLink = "a {$url} {$target}";

<a <?= $url . ' ' . $target ?>>
</a>
//link

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