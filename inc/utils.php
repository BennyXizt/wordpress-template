<?php

 function util_buildMenu($menuItems, $parentID = 0) {
    $buffer = [];

    if(empty( $menuItems )) return;

    foreach($menuItems as $item) {
        if((int)$item->menu_item_parent === $parentID) {
            $children = util_buildMenu($menuItems, (int)$item->ID);

            $buffer[] = [
                'item' => $item,
                'children' => $children
            ];
        }
    }

    return $buffer;
}
function util_generateMenus($menu, $class = 'menu', $dept = 0) {
    if(empty( $menu )) return;

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
                util_generateMenus($element['children'], 'submenu', $dept + 1);
            }
        echo '</li>';
    }
    echo '</ul>';
}
function util_displayLogo($class) {
    $custom_logo_id = get_theme_mod('custom_logo'); 
    $logo_file = get_attached_file($custom_logo_id);

    if($logo_file) {
        $logo_ext = pathinfo($logo_file, PATHINFO_EXTENSION);
        $logo_svg = file_get_contents($logo_file);
        $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
    }

    if(is_front_page() || is_home()) {
        echo "<figure class='{$class}__logo'>";

        if($logo_file && $logo_ext === 'svg') {
            echo $logo_svg;
        }
        elseif($logo_file && $logo_ext !== 'svg') {
            echo "<img src='" . esc_url($logo[0])  . "' width='" . esc_html($logo[1])  . "' height='" . esc_html($logo[2])  . "' alt='". esc_attr(get_bloginfo('name') . '__logo') . "'>";
        }

        echo '</figure>';
    }
    else {
        echo "<a href='{esc_url(home_url('/'))}' class='{$class}__logo'>";

        if($logo_file && $logo_ext === 'svg') {
            echo $logo_svg;
        }
        elseif($logo_file && $logo_ext !== 'svg') {
            echo "<img src='" . esc_url($logo[0])  . "' width='" . esc_html($logo[1])  . "' height='" . esc_html($logo[2])  . "' alt='". esc_attr(get_bloginfo('name') . '__logo') . "'>";
        }

        echo '</a>';
    }

}
