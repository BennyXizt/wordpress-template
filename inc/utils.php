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