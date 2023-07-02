<div class="wrap twchat-direct-message-page">
    <h1>
        <?php _e('Direct Message', 'twchatlang'); ?>
        <p class="description"><?php  _e('Send a message to any number you want.', 'twchatlang'); ?></p>
    </h1>
    <div class="twchat-direct-message-form">
        <label for="message"><?php _e('Message:', 'twchatlang'); ?></label>
        <textarea id="message" name="message" rows="4" cols="50" placeholder="<?php _e('Enter your message here...', 'twchatlang'); ?>"></textarea>
        <label for="number"><?php _e('Number:', 'twchatlang'); ?></label>
        <input type="text" id="number" name="number" value="+" placeholder="+19876543210" onkeypress="return event.charCode >= 48 && event.charCode <= 57" oninput="if (this.value[0] !== '+') this.value = '+' + this.value;" required>
        <button id="send" name="send" class="button button-primary"><?php _e('Send', 'twchatlang'); ?></button>
    </div>
</div>
<script> 
// send message to custom number on click
document.getElementById("send").onclick = function() {
    // min length of number is 10
    if (document.getElementById("number").value.length < 8 || document.getElementById("number").value.length > 15) {
        alert("<?php _e('Please enter a valid number.', 'twchatlang'); ?>");
        return;
    }
    var number = document.getElementById("number").value;
    var message = document.getElementById("message").value;
    window.location.href = "https://api.whatsapp.com/send?phone=" + number + "&text=" + message;
};
</script>