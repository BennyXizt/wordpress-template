<?php
    $custom_logo_id = get_theme_mod('custom_logo'); 
    $logo_file = get_attached_file($custom_logo_id);

    if($logo_file) {
        $logo_ext = pathinfo($logo_file, PATHINFO_EXTENSION);
        $logo_svg = file_get_contents($logo_file);
        $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
    }

    $locations = get_nav_menu_locations();
    $desktopMenuID = $locations['header_menu'];
    $desktopMenu = util_buildMenu(wp_get_nav_menu_items($desktopMenuID));
?>

<header class="header">
    <div class="header__container container">
        <div class="header__body">
             <?php if(is_front_page() || is_home()) : ?>
                <figure class="header__logo">
                    <?php if($logo_file && $logo_ext === 'svg') :?>
                        <?= $logo_svg;?>
                    <?php elseif($logo_file && $logo_ext !== 'svg') : ?>
                        <img src="<?= esc_url($logo[0]); ?>" width="<?= $logo[1]?>" height="<?= $logo[2]?>" alt="<?= bloginfo('name'); ?>_logo">
                    <?php endif; ?>
                </figure>
            <?php else : ?>
                <a href="<?= esc_url(home_url('/'));?>" class="header__logo">
                    <?php if($logo_file && $logo_ext === 'svg') :?>
                        <?= $logo_svg;?>
                    <?php elseif($logo_file && $logo_ext !== 'svg') : ?>
                        <img src="<?= esc_url($logo[0]); ?>" width="<?= $logo[1]?>" height="<?= $logo[2]?>" alt="<?= bloginfo('name'); ?>_logo">
                    <?php endif; ?>
                </a>
            <?php endif; ?>
            <div class="header__menu menu">
                <nav class="menu__body">
                    <?php util_generateMenus($desktopMenu); ?>
                </nav>
            </div>
            <button class="header__burger burger">
              <span></span>
            </button>
        </div>
    </div>
</header>