<?php
    $filteredKeywords = sanitize_key(wp_get_theme()->get('Name') . '_header_keywords');
    $keywords = get_theme_mod($filteredKeywords, 'wordpress, blog');
    $filteredAuthor = sanitize_key(wp_get_theme()->get('Name') . '_header_site_owner');
    $author = get_theme_mod($filteredAuthor, '');
?>

<!DOCTYPE html>
<html <?= language_attributes(); ?> >

<head>
    <!-- Encoding + Compatibility -->
    <meta charset="<?= bloginfo('charset'); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Title & head_component -->
    <title><?= bloginfo('name'); ?></title>

    <meta name="description" content="<?= bloginfo('description'); ?>" />
    <meta name="keywords" content="<?= esc_attr($keywords); ?>" />
    <meta name="author" content="<?= esc_attr($author); ?>" />

    <!-- Open Graph (for social previews) -->
    <meta property="og:title" content="<?= bloginfo('name'); ?>" />
    <meta property="og:description" content="<?= bloginfo('description'); ?>" />

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="<?= bloginfo('name'); ?>" />
    <meta name="twitter:description" content="<?= bloginfo('description'); ?>"/>
    <?php wp_head(); ?>
</head>

<body>
    <div class="wrapper">
        <?php get_template_part('template-parts/header/header'); ?>