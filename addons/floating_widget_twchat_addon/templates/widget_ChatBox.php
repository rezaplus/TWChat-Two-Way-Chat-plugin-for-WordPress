<?php ob_start(); ?>
<div class="TWCHFloatBox" id="TWCHFloatBox">
    <div class="TWCHBoxHeader">
        <span onclick="document.getElementById('TWCHFloatBox').classList.toggle('show');" class="TWCHCloseBtn">
            <?php TWChat_svg(TWCHAT_ADDON_FLOATING_IMG_URL . 'icons/close.svg', 'TWCHCloseBtnIcon'); ?>
        </span>
        <?php do_action('twchat/addon/floating/chatbox/header', $options); ?>
    </div>
    <div class="TWCHBox">
        <?php do_action('twchat/addon/floating/chatbox/body', $options); ?>
    </div>
    <div class="TWCHBoxFooter">
        <?php do_action('twchat/addon/floating/chatbox/footer', $options); ?>
        <p class="TWCHBoxFooterText"><?php esc_html_e('Powered by', 'twchat'); ?> <a href="https://rellaco.com/twchat" target="_blank">TWChat</a></p>
    </div>
</div>
<?php return ob_get_clean(); ?>