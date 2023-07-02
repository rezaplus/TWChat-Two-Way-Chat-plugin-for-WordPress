
class TWChat {
    constructor() {
      // add send message button to order each note 
      this.addSendMessageButtonAfterNote();
     // add send message button after new note added by ajax
     jQuery(document).ajaxComplete((event, xhr, settings) => {
      if (settings.data && settings.data.includes("action=woocommerce_add_order_note")) {
        this.addSendMessageButtonAfterNote();
        }
      });


    }

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

    // add send message button to order note 
    addSendMessageButtonAfterNote() {
     // get li.note elements
      const notes = jQuery("ul.order_notes li.note");
      // if notes exist
      if (notes.length > 0) {
        // for each note
        notes.each((index, note) => {
          // check if button already exists return 
          if (jQuery(note).find(".TWChatSendMessageNoteButton").length <= 0 ){
            var phone = TWCH.phone_number;

            // keep only numbers in phone number
            phone = phone.replace(/[^0-9]/g , "");
            // remove 0 from start of phone number
            phone = phone.replace(/^0+/, "");
            // remove ()
            phone = phone.replace(/\(/g, "");
            // remove )
            phone = phone.replace(/\)/g, "");

            var message = jQuery(note).find(".note_content").text();
            // remove spaces before and after message
            message = message.trim();
            message = message.replace(/\n/g,"%0D%0A");
            var onclick = "twchat.sendMessage('" + phone + "', '" + message + "');";
            jQuery(note).find(".meta").append("<a onclick=\"" + onclick + "\" href=\"javascript:void(0);\" class=\"TWChatSendMessageNoteButton\" >" + TWCH.button_text + "</a>");
          }
        });
      }
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
