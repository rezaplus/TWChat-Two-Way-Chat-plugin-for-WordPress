<div class="wrap twchat-admin-page">
    <h1>
        <?php _e('Two Way Chat Settings', 'twchatlang'); ?>
        <p class="description"><?php _e('Configure your TWChat settings below. For more information, you can follow the <a href="https://rellaco.com/docs/intro/" target="_blank">documentation</a>.', 'twchatlang'); ?></p>
    </h1>
    <form method="post" action="options.php">
        <?php
        settings_fields('TWChat_option_group');
        ?>
        <ul class="nav-tab-wrapper" id="twchat-settings-tabs">
            <?php
            foreach ($sections as $section) {
                echo '<li class="nav-tab ' . ('general' == $section['id'] ? 'nav-tab-active' : '') . '" id="twchat-' . $section['id'] . '-tab">' . $section['title'] . '</li>';
            }
            ?>
            <span class="nav-tab submitbtn"><?php submit_button(); ?></span>
        </ul>
        <!-- tabs on left side -->
        <div class="tab-content">
            <?php
            foreach ($sections as $section) {
                echo '<div id="twchat-' . $section['id'] . '" class="tab-pane ' . ('general' == $section['id'] ? 'active' : 'hidden') . '">';
                do_settings_sections('twchat-' . $section['id']);
                echo '</div>';
            }
            ?>
        </div>
    </form>
</div>
<p class="description shortcuts-tooltip"><?php _e('Press <strong>cmd + s</strong> or <strong>ctrl + s</strong> to save quickly.', 'twchatlang'); ?></p>