<?php
    $args = $args ?? null;

    $fields = [
        'hasLink' => get_field('block_type') === 'link',
        'label' => get_field('label') ?? null,
        'link' => is_array(get_field('link')) ? get_field('link') : [],
        'size' => get_field('size') ?? null,
    ];

    $blockClass = $args && isset($args['blockClass']) ? $args['blockClass'] . '__button button' : 'button';
    $blockSizes = ['small'=>'button--size-small'];

    if(isset($blockSizes[$fields['size']])) {
        $blockClass .= ' ' . $blockSizes[$fields['size']];
    }

    $blockType = $fields['hasLink'] ? 'a' : 'button';
    $blockTypeLink = null;

    if($blockType === 'a') {
        $url = !empty($fields['link']['url']) ? 'href="'. esc_url($fields['link']['url']) .'"' : '';
        $target = !empty($fields['link']['target']) ? 'target="'. esc_attr($fields['link']['target']) .'"' : '';
        $blockTypeLink = "a {$url} {$target}";
    }
   

?>



<<?= $blockTypeLink ? $blockTypeLink : $blockType?>  class="<?=$blockClass?>">
    <?php if($fields['hasLink'] && $fields['link']) : ?>
        <?= esc_html($fields['link']['title']) ?>
    <?php elseif(!$fields['hasLink'] && $fields['label']) : ?>
        <?= esc_html($fields['label']) ?>
    <?php endif; ?>
</<?=$blockType?>>