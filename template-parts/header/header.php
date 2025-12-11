<?php
    $custom_logo_id = get_theme_mod('custom_logo'); 
    $logo_file = get_attached_file($custom_logo_id);

    if($logo_file) {
        $logo_ext = pathinfo($logo_file, PATHINFO_EXTENSION);
        $logo_svg = file_get_contents($logo_file);
        $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
    }
?>

<header class="header">
    <div class="header__container container">
        <?php if(is_front_page() || is_home()) : ?>
            <div class="header__logo">
                <?php if($logo_file && $logo_ext === 'svg') :?>
                    <?= $logo_svg;?>
                <?php elseif($logo_file && $logo_ext !== 'svg') : ?>
                    <img src="<?= esc_url($logo[0]); ?>" width="<?= $logo[1]?>" height="<?= $logo[2]?>" alt="<?= bloginfo('name'); ?>_logo">
                <?php endif; ?>
                <?= bloginfo('name'); ?>
            </div>
        <?php else : ?>
            <a href="<?= esc_url(home_url('/'));?>" class="header__logo">
                <?php if($logo_file && $logo_ext === 'svg') :?>
                    <?= $logo_svg;?>
                <?php elseif($logo_file && $logo_ext !== 'svg') : ?>
                    <img src="<?= esc_url($logo[0]); ?>" width="<?= $logo[1]?>" height="<?= $logo[2]?>" alt="<?= bloginfo('name'); ?>_logo">
                <?php endif; ?>
                <?= bloginfo('name'); ?>
            </a>
        <?php endif; ?>
    </div>
</header>