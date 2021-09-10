<?php
$float_option = get_option('TWCH_float_options');
$float_padding1 = $float_option['floatSize']*$float_option['floatPadding1']/100;
$float_padding2 = $float_option['floatSize']*$float_option['floatPadding2']/100;
$float_width = $float_option['floatSize']-$float_padding1-$float_padding2;
?>
<style>
.TWCHFloatContainer{
    <?php echo esc_html($float_option['float-location']).':'.esc_html($float_option['TWCH_SideSpace']).'px'; ?>;
    bottom:<?php echo esc_html($float_option['TWCH_bottomDistance']).'px'; ?>;
}
.TWCHFloatBox {
    transform: scale(0);
    <?php echo esc_html($float_option['float-location']).':'.esc_html($float_option['TWCH_SideSpace']-1).'px'; ?>;
    bottom:<?php echo esc_html($float_option['TWCH_bottomDistance']-1).'px'; ?>;
    transform-origin: <?php echo esc_html($float_option['float-location']); ?> bottom;
}
.TWCHFloatBtn{
    float:<?php echo esc_html($float_option['float-location']); ?>;
    border-radius:<?php echo esc_html($float_option['floatRadius2']).'%'; ?>;
    padding:<?php echo esc_html($float_padding2).'px'; ?>;
    <?php if($float_option['floatBackground2'] != 0){ ?>
    background-color:<?php echo esc_html($float_option['floatBackground2']); }?>;
}
.TWCHFloatBtn .TWCH-icon{
    width:<?php echo esc_html( $float_width).'px'; ?>;
	height:<?php echo esc_html( $float_width).'px'; ?>;
    display: block;
}
.TWCHFloatBtn div{
    padding:<?php echo esc_html( $float_padding1).'px'; ?>;
    border-radius:<?php echo esc_html($float_option['floatRadius1']).'%'; ?>;
    <?php if($float_option['floatBackground1'] != 0){ ?>
    background-color:<?php echo esc_html($float_option['floatBackground1']); }?>;
}
.TWCHBoxHeader{
    background-color:<?php echo esc_html($float_option['floatBoxHeaderBackground']); ?>;
    color:<?php echo esc_html($float_option['floatBoxTextColor']); ?>;
}
.TWCHBoxHeader svg{
    fill:<?php esc_html_e($float_option['floatBoxCloseBtnColor']); ?>;
}
@media only screen and (max-width: 768px) {
  .TWCHFloatContainer{
    <?php echo esc_html( $float_option['float-locationMobile']).':'. esc_html($float_option['TWCH_SideSpaceMobile']).'px !important'; ?>;
    bottom:<?php echo esc_html($float_option['TWCH_bottomDistanceMobile']).'px !important'; ?>;
}
.TWCHFloatBtn{
    float:<?php echo esc_html($float_option['float-locationMobile']).' !important'; ?>;
}
}
</style>
<div class="TWCHFloatContainer <?php echo is_rtl() ? 'RTL' : ''?>">
    <?php require_once TWCH_DIR_path.'Pages/FloatBox.php'; ?>
    <div class="TWCHFloatBtn">
        <div>
            <img src="<?php echo esc_url(TWCH_image."float-icon/".$float_option['float-icon']); ?>" class="TWCH-icon" onclick="document.getElementById('TWCHFloatBox').classList.toggle('show');">
        </div>
    </div>
</div>