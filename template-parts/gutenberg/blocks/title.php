<?php
    $args = $args ?? null;

    if($args) {
        $blockClass = isset($args['blockClass']) ? 'class="'.$args['blockClass'].'__title"' : '';
    } else {
        $blockClass = '';
    }

    $fields = [
        'title' => wp_kses(get_field('title'), [
            'span' => []
        ]) ?? null,
        'type' => get_field('title_type') ?? 'h2',
        'color' => get_field('color') ?? '',
    ];

    $color = !empty($fields['color']) ? 'style="color: '. $fields['color'] .'"' : '';
?>

<?php if(!empty($fields['title'])) : ?>
    <<?=$fields['type']?> <?=$blockClass?> <?=$color?>>
        <?= $fields['title'] ?>
    </<?=$fields['type']?>>
<?php endif; ?>