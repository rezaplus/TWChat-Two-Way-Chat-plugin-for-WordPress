<div class="TWCHBoxAccounts">
    <ul>
        <?php foreach ($accounts as $account) : ?>
            <?php
            if (count($account->contacts) == 1) {
                $onclickEvent = "this.querySelector('.TWCHBoxACSChatBtn').click();";
            } else {
                $onclickEvent = "this.classList.add('active');";
            }
            ?>
            <li class="TWChatAccount <?php echo $account->is_available ? 'TWCHBoxACSAvailable' : 'TWCHBoxACSnotAvailable' ?>" data-id="<?php esc_attr_e($account->ID); ?>" onclick="<?php esc_attr_e($onclickEvent); ?>">
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