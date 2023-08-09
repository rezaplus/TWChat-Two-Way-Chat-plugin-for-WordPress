<div class="TWCHBoxACSChatBtns">
    <?php
    if (!empty($account->contacts)) {
        $account->contacts = array_reverse($account->contacts);
        foreach ($account->contacts as $contact) {
            $button = apply_filters("twchat/floating_widget/contact_{$contact}", $account->ID);
            if (isset($button['Icon']) && isset($button['Link'])) {
                echo '<a href="' . esc_attr($button['Link']) . '" target="_blank" class="TWCHBoxACSChatBtn">';
                echo '<img src="' . esc_url($button['Icon']) . '" alt="' . esc_attr($contact) . '" title="' . esc_attr($contact) . '">';
                echo '</a>';
            }
        }
    }elseif(is_user_logged_in() && current_user_can('manage_options')){ //if contacts not found and user is logged in (admin)
        echo  '<p style="color: red ; font-size: 14px;">' .
        __('Available contacts not found, please check your account page.', 'twchat') .
        '</p>';
    }else{
        echo  '<p style="color: red ; font-size: 14px;">' .
        __('Available contacts not found.', 'twchat') .
        '</p>';
    }
    ?>
</div>