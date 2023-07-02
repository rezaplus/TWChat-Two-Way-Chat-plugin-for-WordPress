<div class="TWCHSocial">
    <?php foreach ($social_links as $social) {
        if ($social->link) {
            echo '<a href="' . esc_attr($social->link) . '" target="_blank"><img src="' . esc_url($social->icon) . '" alt="' . esc_attr($social->name) . '"></a>';
        }
    } ?>
</div>