<?php
    $args = $args ?? null;

    if($args) {
        $fields = [
            'file' => $args['data']['file'] ?? '',
            'iconName' => $args['data']['icon_name'] ?? '',
            'isRounded' => $args['data']['rounded'] ?? '',
            'size' => $args['data']['size'] ?? null,
            'style' => $args['data']['style'] ?? null
        ];

        $blockClass = 'icon';

        if(isset($fields['isRounded'])) {
            $blockClass = isset($args['blockClass']) ? $args['blockClass'] . '__icon-rounded icon-rounded' : 'icon-rounded';
            $svgCSS = isset($args['blockClass']) ? $args['blockClass'] . '__icon-rounded icon-rounded__icon' : 'icon-rounded__icon';
        }
    }
    else {
        $fields = [
            'file' => get_field('file') ?? '',
            'iconName' => get_field('icon_name') ?? '',
            'isRounded' => get_field('rounded') ?? '',
            'size' => get_field('size') ?? null,
            'style' => get_field('style') ?? null
        ];

        $blockClass = 'icon';

        if(isset($fields['isRounded'])) {
            $blockClass = 'icon-rounded';
            $svgCSS = 'icon-rounded__icon';
        }
    }

    

    $href = !empty($fields['file'] && $fields['iconName']) ? 'href="'. $fields['file'] . '#' . $fields['iconName'] .'"' : '';

    $blockSizes = ['30' => 'icon-rounded--size-30', '32' => 'icon-rounded--size-32', '38' => 'icon-rounded--size-38'];
    $blockStyles = ['primary' => 'icon-rounded--primary'];

    if(isset($blockSizes[$fields['size']])) {
        $blockClass .= ' ' . $blockSizes[$fields['size']];
    }

    if(isset($blockStyles[$fields['style']])) {
        $blockClass .= ' ' . $blockStyles[$fields['style']];
    }
?>
 
<?php if(!empty($fields['isRounded'])) : ?>
    <div class="<?=$blockClass?>">
<?php endif; ?>
    <svg class="<?=$svgCSS?>">
        <use <?=$href?> ></use>
    </svg>
<?php if(!empty($fields['isRounded'])) : ?>
    </div>
<?php endif; ?>