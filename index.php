<?php get_header(); ?>
<main class="layout <?= is_page() && !is_front_page() ? 'layout--' . esc_attr(strtolower(get_the_title())) : '' ?>">
    <?php if(have_posts()) : ?>
        <?php while(have_posts()) : the_post(); ?>
            <?php the_content(); ?>
        <?php endwhile; ?>
    <?php endif; ?>
</main>
<?php get_footer(); ?>