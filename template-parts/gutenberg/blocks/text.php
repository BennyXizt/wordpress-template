<?php
    $args = $args ?? null;

    if($args) {
        $blockClass = isset($args['blockClass']) ? $args['blockClass'].'__text' : 'text';

        $fields = [
            'text' => $args['data']['text'] ?? '',
            'color' => $args['data']['color'] ?? '',
            'size' => $args['data']['size'] ?? 'default'
        ];
    } else {
        $blockClass = 'text';

        $fields = [
            'text' => get_field('text') ?? '',
            'color' => get_field('color') ?? '',
            'size' => get_field('size') ?? 'default'
        ];
    }

    $text_sizes = ['12', '14', '18', '20', '24'];
    if($fields['size'] !== 'default' && in_array($fields['size'], $text_sizes)) {
        $blockClass .= " text--size-{$fields['size']}";
    }

    $color = $fields['color'] ? 'style="color: '. $fields['color'] .'"' : '';

?>

<?php if(!empty($fields['text'])) : ?>
    <div <?=$blockClass ? "class='$blockClass'" : ''?> <?=$color ?>>
        <?= wp_kses_post($fields['text']) ?>
    </div>
<?php endif; ?>