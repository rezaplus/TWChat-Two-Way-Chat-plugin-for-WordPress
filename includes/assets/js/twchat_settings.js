jQuery(function($) {
  // Cache frequently used elements
  var twchatSettingsTabs = $('#twchat-settings-tabs');
  var navTabs = twchatSettingsTabs.find('.nav-tab');
  var tabContent = $('.tab-content .tab-pane');
  var countryCodeSelect = $('#country_code_select');
  var twchatCountryCode = $('#twchat_country_code');
  var countryToggle = $('#static_country_code');
  var submitButton = $('#submit');

  // Tab click event handler
  navTabs.click(function() {
    // If submit button clicked, return
    if ($(this).hasClass('submitbtn')) return;

    navTabs.removeClass('nav-tab-active');
    $(this).addClass('nav-tab-active');
    tabContent.addClass('hidden');
    $('#' + $(this).attr('id').replace('-tab', '')).removeClass('hidden').addClass('active');

    // Change URL hash
    window.location.hash = $(this).attr('id').replace('-tab', '');

    // Update _wp_http_referer with the hash
    referer_url(window.location.hash);

    // Scroll to top
    $('html, body').scrollTop(0);
  });

  // Check if hash exists in the URL
  if (window.location.hash) {
    navTabs.removeClass('nav-tab-active');
    twchatSettingsTabs.find('.nav-tab' + window.location.hash + '-tab').addClass('nav-tab-active');
    tabContent.addClass('hidden');
    $(window.location.hash).removeClass('hidden').addClass('active');

    // Update _wp_http_referer with the hash
    referer_url(window.location.hash);

    // Scroll to top
    $('html, body').scrollTop(0);
  }


  $('.twchat-setting-field[data-conditional-id]').each(function() {
    var related = $(this).data('conditional-id');
    var relatedInput = $('#' + related);
    if (relatedInput.is(':checked')) {
      $(this).prop('disabled', false);
      // remove th color
      $(this).closest('tr').find('th').css('color', '');
    } else {
      $(this).prop('disabled', true);
      // change th color to gray
      $(this).closest('tr').find('th').css('color', '#999');
    }
  });

  // conditional-id values are the IDs of the checkboxes that control the input field
  $('.twchat-setting-field[data-conditional-id]').each(function() {
    var element = $(this);
    var related = $(this).data('conditional-id');
    var relatedInput = $('#' + related);
    $(relatedInput).on('change', function() {
      if (relatedInput.is(':checked')) {
        element.prop('disabled', false);
        // remove th color
        element.closest('tr').find('th').css('color', '');
      }else{
        element.prop('disabled', true);
        // change th color to gray
        element.closest('tr').find('th').css('color', '#999');
      }
    });
  });


  // Sync selected option in country code select with twchat_country_code input
  countryCodeSelect.on('input', function() {
    twchatCountryCode.val($(this).find(':selected').data('country-code'));
  });

  // Set selected option in country code select based on twchat_country_code value
  countryCodeSelect.find('option').each(function() {
    if ($(this).data('country-code') == twchatCountryCode.val()) {
      $(this).prop('selected', true);
    }
  });

  // Add new social field on button click
  $(".twchat-social-field-add").on("click", function() {
    var container = $(this).prev(".twchat-social-fields-container");
    var count = container.children(".twchat-social-field").length - 1;
    var field = container.children(".twchat-social-field:first-child").clone();

    // Reset input and select values, remove disabled attribute
    field.find("input, select").val("").removeAttr("disabled");

    var id = field.find("input").attr("name").split("[")[0];
    field.find("input").attr("name", id + "[social][" + count + "][url]");
    field.find("select").attr("name", id + "[social][" + count + "][icon]");
    field.removeClass("hidden");
    container.append(field);
  });

  // Remove social field on button click
  $(document).on("click", ".twchat-social-field-remove", function() {
    $(this).closest(".twchat-social-field").remove();
  });

  // Save on keyboard shortcut (Cmd+S/Ctrl+S)
  $(document).keydown(function(e) {
    if ((e.ctrlKey || e.metaKey) && e.keyCode == 83) {
      e.preventDefault();
      submitButton.click();
      return false;
    }
  });

  // Update _wp_http_referer with the hash
  function referer_url(hash) {
    var refererLink = $('input[name="_wp_http_referer"]');
    refererLink.val(refererLink.val().replace(/#.*$/, '') + hash);
  }
});