<?php
get_template_part('', null, [''=> '']); // include file
get_field(); // get a field from asf
esc_html($var); // text
esc_url($var); // href, src, action
esc_attr($var); // attr
wp_get_attachment_image($fields['image']['ID'], 'full', false, ['class'=>'']); // responsive img

// link
$url = !empty($fields['link']['url']) ? 'href="'. esc_url($fields['link']['url']) .'"' : '';
$target = !empty($fields['link']['target']) ? 'target="'. esc_attr($fields['link']['target']) .'"' : '';
$linkLabel = esc_html($fields['link']['title']);
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