
class TWChat {
    sendMessage(phone, message = "") {
        // convert phone number to string
        phone = phone.toString();
        // remove all spaces from phone number
        phone = phone.replace(/\s/g, "");
        // remove + from phone number
        phone = phone.replace("+", "");
        // remove - from phone number
        phone = phone.replace("-", "");
        // remove () from phone number
        phone = phone.replace("(", "");
        phone = phone.replace(")", "");
        // remove 0 from start of phone number
        phone = phone.replace(/^0+/, "");

        // get options
        const options = this.getOptions();

        let appmode = "https://api.whatsapp.com/";
        if (options.appmode == "application" || this.isMobile()) {
          appmode = "whatsapp://";
        } else if (options.appmode == "browser") {
          appmode = "https://web.whatsapp.com/";
        }
        // if message not empty, encode message and add to url
        if (message !== "") {
            message = "&text=" + (message.replace(/\n/g,"%0D%0A")+"");
        }
        // redirect to whatsapp
        window.open( appmode + "send?phone=" + options.country_code + phone + message, "_blank");
    }

    // is mobile
    isMobile() {
      return /android|webos|iphone|ipad|ipod|blackberry|windows phone/i.test(
        navigator.userAgent
      );
    }
  
    // get data-attribute from .TWChat_send_message_section
    getOptions() {
      // if TWCH not exist, return empty object
      if (typeof TWCH == "undefined") {
        return {};
      }
      const options = {};
      // get appmode
      options["appmode"] = TWCH.appmode;
      // if appmode not exist, set false
      if (options["appmode"] == undefined || options["appmode"] == "false") {
        options["appmode"] = '';
      }
      // get country code
      options["country_code"] = TWCH.country_code;
      // if country code not exist, set false
      if (options["country_code"] == undefined || options["country_code"] == "false") {
        options["country_code"] = '';
      }
      return options;
    }
  }

// replace button location in order preview to after phone number
function replaceButtonLocation() {
  var tel = jQuery(".wc-order-preview-addresses a[href*=\"tel\"]");
  tel.after(jQuery("#twchat_woocommerce").remove());
}

const twchat = new TWChat();
