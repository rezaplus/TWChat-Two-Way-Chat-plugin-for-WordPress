// Move the featured image meta after the profile image
jQuery(document).ready(function() {
  jQuery('#postimagediv').insertAfter('#TWChat_account_profile');
  
  // Event listener for profile image radio buttons
  jQuery(document).on('input', 'input[name="TWChat_account_profile[thumbnail]"]', function() {
    profile_image_control(this, true);
  });
  
  // Run the function on page load
  profile_image_control(jQuery('input[name="TWChat_account_profile[thumbnail]"]:checked'));
});

/**
 * Controls the profile image based on the selected option
 * @param {HTMLElement} element - The selected radio button element
 * @param {boolean} scroll - Indicates whether to scroll to the profile image element
 */
function profile_image_control(element, scroll = false) {
  if (jQuery(element).val() !== 'custom') {
    const checkedValue = jQuery('input[name="TWChat_account_profile[thumbnail]"]:checked').val();
    jQuery('#remove-post-thumbnail').click();
    jQuery('#postimagediv').hide();
  } else {
    jQuery('#profile_image').val('custom');
    jQuery('#postimagediv').show();
    
    // Scroll to the element if specified
    if (scroll) {
      jQuery('html, body').animate({
        scrollTop: jQuery("#postimagediv").offset().top
      }, 1000);
    }
  }
}

/**
 * Controls the display name options based on the nickname field
 */
function display_name_as_control() {
  const nicknameValue = jQuery('.twchat-field #nickname').val();
  
  if (nicknameValue === '') {
    jQuery('.twchat-field #display_name_as option[value="nickname"]').hide();
    
    // Change to the first option if nickname is selected
    if (jQuery('.twchat-field #display_name_as').val() === 'nickname') {
      jQuery('.twchat-field #display_name_as').val(jQuery('.twchat-field #display_name_as option:first').val());
    }
  } else {
    jQuery('.twchat-field #display_name_as option[value="nickname"]').show();
  }
}

// Run the display_name_as_control function when .twchat-field input is changed
jQuery(document).on('input', '.twchat-field input', function() {
  display_name_as_control();
}).ready(function() {
  display_name_as_control();
});
