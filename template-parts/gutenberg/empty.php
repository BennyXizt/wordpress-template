

<?php if (is_admin() || (isset($is_preview) && $is_preview)) : ?>
    <div style="border: 1px solid black; padding: 30px">
        <p style="text-align: center; color: #999; font-style: italic;">
            <?= wp_kses_post($localized_message) ?>
        </p>
    </div>
<?php endif; ?>
