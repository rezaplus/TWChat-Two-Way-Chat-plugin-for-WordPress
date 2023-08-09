// Move the featured image meta after the profile image
jQuery(document).ready(function() {
  jQuery('#postimagediv').insertAfter('#TWChat_account_profile');
  
  // Event listener for profile image radio buttons
  jQuery(document).on('input', 'input[name="TWChat_account_profile[thumbnail]"]', function() {
    profile_image_control(this, true);
  });


  // if one of date is filled, make the other required
  available_time_required();
  jQuery(document).on('input', 'input[name="TWChat_account_profile[available_from]"], input[name="TWChat_account_profile[available_to]"]', function() {
    available_time_required();
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

/**
 * required checkboxes
 * 
 * @param {string} selector - The selected checkbox selector
 * @returns {void}
 */
function required_checkboxes(selector) {
  const checkedCount = jQuery(selector + ':checked').length;
  
  if (checkedCount === 0) {
    // make the first checkbox required
    jQuery('input[name="TWChat_floating_contacts[available_contacts][]"]:first').prop('required', true);
  } else {
    jQuery('input[name="TWChat_floating_contacts[available_contacts][]"]:first').prop('required', false);
  }
}

/**
 * if one of available time is filled, make the other required otherwise not
 * if both are empty, make both not required
 * @returns {void}
 */
function available_time_required(){
  const available_from = jQuery('input[name="TWChat_account_profile[available_from]"]').val();
  const available_to = jQuery('input[name="TWChat_account_profile[available_to]"]').val();
  if (available_from == '' && available_to == '') {
    jQuery('input[name="TWChat_account_profile[available_from]"]').prop('required', false);
    jQuery('input[name="TWChat_account_profile[available_to]"]').prop('required', false);
  }else{
    jQuery('input[name="TWChat_account_profile[available_from]"]').prop('required', true);
    jQuery('input[name="TWChat_account_profile[available_to]"]').prop('required', true);
  }
}


// Run the display_name_as_control function when .twchat-field input is changed
jQuery(document).on('input', '.twchat-field input', function() {
  display_name_as_control();
}).ready(function() {
  display_name_as_control();
});
