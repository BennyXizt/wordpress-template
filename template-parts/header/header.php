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
    $desktopMenu = buildMenuStructure(wp_get_nav_menu_items($desktopMenuID));

    function buildMenuStructure($menuItems, $parentID = 0) {
        $buffer = [];

        foreach($menuItems as $item) {
            if((int)$item->menu_item_parent === $parentID) {
                $children = buildMenuStructure($menuItems, (int)$item->ID);

                $buffer[] = [
                    'item' => $item,
                    'children' => $children
                ];
            }
        }

        return $buffer;
    }

    function generateMenus($menu, $class = 'menu', $dept = 0) {
        echo "<ul class='". ($dept > 0 ? "{$class}" : "{$class}__list") ."'>";
        foreach($menu as $element) {
            echo "<li class='{$class}__item". ($element['children'] ? " {$class}__item--submenu submenu-{$dept}" : "") ."'>";
                if($element['item']->url !== '#') {
                    echo "<a href='{$element['item']->url}' class='{$class}__link'>";
                        echo $element['item']->title;
                    echo '</a>';
                }
                else {
                    echo "<div class='{$class}__link'>";
                        echo $element['item']->title;
                    echo '</div>';
                }
                
                if($element['children']) {
                    generateMenus($element['children'], 'submenu', $dept + 1);
                }
            echo '</li>';
        }
        echo '</ul>';
    }
?>

<header class="header">
    <div class="header__container container">
        <div class="header__body">
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
            <div class="header__menu menu">
                <nav class="menu__body">
                    <ul>
                        <?php generateMenus($desktopMenu)?>
                    </ul>
                </nav>
            </div>
            <button class="header__burger burger">
              <span></span>
            </button>
        </div>
    </div>
</header>