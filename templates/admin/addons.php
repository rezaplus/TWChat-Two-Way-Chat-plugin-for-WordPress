<div class="wrap twchat-admin-page twchat-addons-page">
    <h1>
        <?php _e('TWChat Add-ons', 'twchatlang'); ?>
        <p class="Description"><?php _e('Extend the functionality of TWChat with these add-ons.', 'twchatlang'); ?></p>
    </h1>

    <div class="twchat-addons-list">
        <?php foreach ($addons as $addon) : ?>
            <div class="twchat-addon">
                <div class="twchat-addon-detail">
                    <h3><?php echo $addon['Name']; ?></h3>
                    <p><?php echo $addon['Description']; ?></p>
                </div>
                <div class="twchat-addon-content">

                    <div class="twchat-addon-footer">
                        <div class="twchat-addon-priceDetails">
                            <span class="twchat-addon-price-amount"><?php echo isset($addon['button']['PriceDetails']) ? $addon['button']['PriceDetails'] : $addon['PriceDetails']; ?></span>
                            <?php if (isset($addon['ls'])) : ?>
                                <a href="<?php echo $addon['ls']['link'] ?>" style="color: <?php echo $addon['ls']['color']; ?>;"><?php echo $addon['ls']['status']; ?> </a>
                            <?php endif; ?>
                        </div>
                        <div class="twchat-addon-actions">
                            <?php if (isset($addon['infoButton'])) : ?>
                                <a href="<?php echo $addon['infoButton']['link']; ?>" class="twchat-addon-info-btn" target="_blank"><?php echo $addon['infoButton']['text']; ?></a>
                            <?php endif; ?>
                            <?php if (isset($addon['button'])) : ?>
                                <a href="<?php echo $addon['button']['link']; ?>" class="<?php echo $addon['button']['class']; ?>" target="<?php echo $addon['button']['target']; ?>"><?php echo $addon['button']['text']; ?></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>