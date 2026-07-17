<?php
    $args = $args ?? null;

    $parentClass = $args && isset($args['blockClass']) ? $args['blockClass'] : '';
    $blockClass = 'logo';

    $label = $args && isset($args['label']) ? 
        ($args['label'] === true ? get_bloginfo('name') : $args['label']) : 
        null;

    $custom_logo_id = get_theme_mod('custom_logo'); 
    $logo_file = get_attached_file($custom_logo_id);

    if(!$logo_file) return;

    $logo_ext = pathinfo($logo_file, PATHINFO_EXTENSION);
    
    if($logo_ext === 'svg') {
        $logo_image = file_get_contents($logo_file);
        $logo = preg_replace('/<svg\b/', "<svg class='{$blockClass}__icon icon'", $logo_image);
    } else {
        $logo_image = wp_get_attachment_image_src($custom_logo_id, 'full');
        $logo = sprintf('<img class="%s__image" src="%s" width="%d" height="%d" alt="%s__logo"></img>', 
            esc_attr($blockClass),
            esc_url($logo_image[0]), 
            absint($logo_image[1]),
            absint($logo_image[2]),
            esc_attr(get_bloginfo('name'))
        );
    }
?>

<?php if(is_front_page() || is_home()) : ?>
    <div class="<?=$parentClass?>__logo <?=$blockClass?>">
        <?=$logo?>

        <?php if($label): ?>
            <span class="<?=$blockClass?>__label">
                <?=esc_html($label)?>
            </span>
        <?php endif;?>
    </div>
<?php else : ?>
    <a href="<?= esc_url(home_url('/'));?>" class="<?=$parentClass?>__logo <?=$blockClass?>">
        <?=$logo?>

        <?php if($label): ?>
            <span class="<?=$blockClass?>__label">
                <?=esc_html($label)?>
            </span>
        <?php endif;?>
    </a>
<?php endif; ?>