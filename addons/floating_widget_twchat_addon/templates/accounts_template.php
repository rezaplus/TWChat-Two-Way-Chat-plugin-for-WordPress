<div class="TWCHBoxAccounts">
    <ul>
        <?php foreach ($accounts as $account) : ?>
            <li class="TWChatAccount <?php echo $account->is_available ? 'TWCHBoxACSAvailable' : 'TWCHBoxACSnotAvailable' ?>" data-id="<?php esc_attr_e($account->ID); ?>"  onclick="<?php count($account->contacts) == 1 ? esc_attr_e("document.querySelector('.TWCHBoxACSChatBtn').click();") : esc_attr_e("this.classList.add('active');") ?>">
                <div class="TWCHBoxACSF">
                    <img alt="<?php esc_html_e($account->name); ?>" src="<?php esc_attr_e($account->thumbnail); ?>">
                </div>
                <div class="TWCHBoxACSL">
                    <?php do_action('twchat/addon/floating/chatbox/accounts/details', $account); ?>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</div>