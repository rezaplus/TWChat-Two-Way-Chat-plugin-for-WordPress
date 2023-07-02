// hide and show custom icon upload field
wp.customize('twchat_floating_widget_icon', function (value) {
    value.bind(function (newval) {
        twchat_floating_widget_icon_change(newval);
    });
    twchat_floating_widget_icon_change(value.get());
});

function twchat_floating_widget_icon_change(val) {
    if (val == 'custom') {
        jQuery('#customize-control-twchat_floating_widget_custom_icon').show();
    } else {
        jQuery('#customize-control-twchat_floating_widget_custom_icon').hide();
    }
}