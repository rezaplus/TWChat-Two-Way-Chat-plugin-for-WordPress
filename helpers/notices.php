<?php

/**
 * Manage the notice of the plugin in admin panel
 * 
 * for show notice use TWChat_notice function in helpers/notices.php file like this:
 * TWChat_notice('message', 'success', true, array('url' => '', 'text' => ''));
 *
 * @package TWChat
 * @since 4.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

class TWChat_notice
{

    public $message;
    public $type;
    public $dismissible;
    public $button;

    /**
     * Display notice
     * 
     * @param string $message
     * @param string $type
     * @param boolean $dismissible
     * @param array $button
     * 
     * @return html
     */
    public function add_notice($message, $type = 'info', $dismissible = true, $button = array())
    {
        $this->message = $message;
        $this->type = $type;
        $this->dismissible = $dismissible;
        $this->button = $button;
        return $this->display_notice();
    }


    /**
     * Display notice html code with message and type and button
     * 
     * @since 4.0.0
     * @return html
     */
    public function display_notice()
    {
        $class = 'notice notice-' . $this->type; // notice-error, notice-warning, notice-success, notice-info
        $message = '<strong> TWChat: </strong>' . $this->message;
        if ($this->dismissible) { // add dismissible class to notice
            $class .= ' is-dismissible';
        }
        $button = '';
        if (!empty($this->button)) { // add button to notice if button isset
            $button = sprintf('<p><a href="%1$s" class="button" target="%3$s" >%2$s</a></p>', $this->button['url'], $this->button['text'], isset($this->button['target']) ? $this->button['target'] : '_self');
        }
        // print notice html
        return sprintf('<div class="%1$s"><p>%2$s</p>%3$s</div>', esc_attr($class), $message, $button);
    }
}

/**
 * Display notice with message and type and button
 * 
 * @param string $message
 * @param string $type - error, warning, success, info
 * @param boolean $dismissible - show dismissible button or not
 * @param array $button - array('url' => '', 'text' => '')
 * 
 * @since 4.0.0
 * @return void
 */
if (!function_exists('TWChat_notice')) {
    function TWChat_notice($message, $type = 'info', $dismissible = true, $button = array())
    {
        $notice = new TWChat_notice();
        $notice_html = $notice->add_notice($message, $type, $dismissible, $button);
        add_action('admin_notices', function () use ($notice_html) {
            echo $notice_html;
        }, 10);
    }
}
