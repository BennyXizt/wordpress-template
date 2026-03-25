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
function util_generateMenus($menu, $class = 'menu', $parentClass = 'menu', $depth = 0) {
    if(empty( $menu )) return;
    
    global $wp;
    $current_url = $wp->request;


    echo "<ul class='{$class}__list'>";

    foreach($menu as $element) {
        $activeLinkPageClass = strtolower($current_url) === strtolower($element['item']->title) ? "{$class}__link--active" : '';
        $submenuClass = !empty($element['children']) ? 'submenu-'.$parentClass : '';
        $liClass = !empty($element['children']) ? "{$class}__item {$class}__item--submenu {$submenuClass}" : "{$class}__item";
        $linkClass = !empty($element['children']) ? "{$class}__link {$class}__link--submenu {$activeLinkPageClass}" : "{$class}__link {$activeLinkPageClass}";
        $spanClass = $depth === 0 ? "{$submenuClass}__trigger {$submenuClass}__trigger--first {$activeLinkPageClass}" : "{$submenuClass}__trigger";
        $iconClass = !empty($element['children']) ? $submenuClass : $class;
        $iconWrapperClass = "{$iconClass}__wrapper";

        echo "<li class='{$liClass}'>";
            if($element['item']->url !== '#') {
                echo "<a href='{$element['item']->url}' class='{$linkClass}'>";
            }

            if($element['children']) {
                echo "<span class='{$spanClass}'>";
            }

            echo $element['item']->title;

            if($element['children']) {
                    echo "<div class='{$iconWrapperClass}'>";
                        get_template_part('template-parts/gutenberg/blocks/icon', null, ['blockClass'=>$iconClass, 'data'=>[
                            'file' => get_template_directory_uri() . '/assets/media/icons/sprite.svg',
                            'icon_name' => 'ph_arrow-drop-down-line',
                            'rounded' => false
                        ]]);
                    echo '</div>';
                echo '</span>';
            }

            if($element['item']->url !== '#') {
                echo '</a>';
            }
            
            if($element['children']) {
                util_generateMenus($element['children'], 'submenu-menu', 'menu', $depth + 1);
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
        echo "<a href='". esc_url(home_url('/')) ."' class='{$class}__logo'>";

        if($logo_file && $logo_ext === 'svg') {
            echo $logo_svg;
        }
        elseif($logo_file && $logo_ext !== 'svg') {
            echo "<img src='" . esc_url($logo[0])  . "' width='" . esc_html($logo[1])  . "' height='" . esc_html($logo[2])  . "' alt='". esc_attr(get_bloginfo('name') . '__logo') . "'>";
        }

        echo '</a>';
    }

}
function util_get_reading_time($post_id = null) {
    if(!$post_id) {
        $post_id = get_the_ID();

        if(!$post_id) return null;
    }

    $content = get_post_field('post_content', $post_id);

    if(!$content) return null;

    $wordsPerMinute = ceil(str_word_count(strip_tags($content)) / 200);


    return $wordsPerMinute . ' Min';
}