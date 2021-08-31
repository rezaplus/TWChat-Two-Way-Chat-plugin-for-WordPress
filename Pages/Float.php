<?php
$float_option = get_option('DTWP_float_options');
$float_padding1 = $float_option['floatSize']*$float_option['floatPadding1']/100;
$float_padding2 = $float_option['floatSize']*$float_option['floatPadding2']/100;
$float_width = $float_option['floatSize']-$float_padding1-$float_padding2;
?>
<style>
.dtwpFloatContainer{
    <?php echo esc_html($float_option['float-location']).':'.esc_html($float_option['dtwp_SideSpace']).'px'; ?>;
    bottom:<?php esc_attr_e($float_option['dtwp_bottomDistance']).'px'; ?>;
}
.dtwpFloatBox {
    transform: scale(0);
    <?php echo esc_html($float_option['float-location']).':'.esc_html($float_option['dtwp_SideSpace']-1).'px'; ?>;
    bottom:<?php echo esc_html($float_option['dtwp_bottomDistance']-1).'px'; ?>;
    transform-origin: <?php echo esc_html($float_option['float-location']); ?> bottom;
}
.dtwpFloatBtn{
    float:<?php echo esc_html($float_option['float-location']); ?>;
    border-radius:<?php echo esc_html($float_option['floatRadius2']).'%'; ?>;
    padding:<?php echo esc_html($float_padding2).'px'; ?>;
    <?php if($float_option['floatBackground2'] != 0){ ?>
    background-color:<?php echo esc_html($float_option['floatBackground2']); }?>;
}
.dtwpFloatBtn .dtwp-icon{
    width:<?php echo esc_html( $float_width).'px'; ?>;
	height:<?php echo esc_html( $float_width).'px'; ?>;
    display: block;
}
.dtwpFloatBtn div{
    padding:<?php echo esc_html( $float_padding1).'px'; ?>;
    border-radius:<?php echo esc_html($float_option['floatRadius1']).'%'; ?>;
    <?php if($float_option['floatBackground1'] != 0){ ?>
    background-color:<?php echo esc_html($float_option['floatBackground1']); }?>;
}
.dtwpBoxHeader{
    background-color:<?php echo esc_html($float_option['floatBoxHeaderBackground']); ?>;
    color:<?php echo esc_html($float_option['floatBoxTextColor']); ?>;
}
.dtwpBoxHeader svg{
    fill:<?php esc_html_e($float_option['floatBoxCloseBtnColor']); ?>;
}
@media only screen and (max-width: 768px) {
  .dtwpFloatContainer{
    <?php esc_html_e( $float_option['float-locationMobile']).':'. esc_html($float_option['dtwp_SideSpaceMobile']).'px !important'; ?>;
    bottom:<?php echo esc_html($float_option['dtwp_bottomDistanceMobile']).'px !important'; ?>;
}
.dtwpFloatBtn{
    float:<?php echo esc_html($float_option['float-locationMobile']).' !important'; ?>;
}
}
</style>
<div class="dtwpFloatContainer <?php echo is_rtl() ? 'RTL' : ''?>">
    <?php require_once DTWP_DIR_path.'Pages/FloatBox.php'; ?>
    <div class="dtwpFloatBtn">
        <div>
            <img src="<?php echo esc_url(DTWP_image."float-icon/".$float_option['float-icon']); ?>" class="dtwp-icon" onclick="document.getElementById('dtwpFloatBox').classList.toggle('show');">
        </div>
    </div>
</div>