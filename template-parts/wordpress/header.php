<?php
    $locations = get_nav_menu_locations();
    $desktopMenuID = $locations['header_menu'] ?? null;

    $desktopMenu = $desktopMenuID ? util_buildMenu(wp_get_nav_menu_items($desktopMenuID)) : null;
?>

<header class="header">
    <div class="header__container container">
        <div class="header__body">
            <?php get_template_part('template-parts/wordpress/logo', null, ['blockClass'=>'header', 'label'=>true]); ?>
            <?php if($desktopMenu): ?>
                <div class="header__menu menu">
                    <nav class="menu__body">
                        <?php util_generateMenus($desktopMenu); ?>
                    </nav>
                </div>
            <?php else: ?>
                Add Some Menu Pages
            <?php endif; ?>
                
            <button data-fsc-burger class="header__burger burger">
              <span aria-hidden="true"></span>
            </button>
        </div>
    </div>
</header>