    <?php
    if (!defined('ABSPATH')) exit; // Exit if accessed directly

    wp_enqueue_style('TWCH-admin-style',  TWCH_assets . 'admin-style.css', array(), TWCH_plugin_version);

    if( isset( $_GET[ 'tab' ] ) ) {  
        $active_tab = sanitize_text_field( $_GET[ 'tab' ] );  
    } else {
        $active_tab = 'General';
    }
    ?>
    <div class="wrap <?php echo is_rtl() ?  'TWCH_RTL' : '' ?>">
        <div class="TWCH-header">
            <h1 class="Page_title"><?php esc_html_e('Settings', 'TWCHLANG'); ?></h1>
            <h2 class="nav-tab-wrapper">
            <a href="?page=TWCH_settings&tab=General" class="nav-tab <?php echo $active_tab == 'General' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e('General','TWCHLANG'); ?></a>  
                    <?php if(class_exists('WooCommerce')): ?>
           <a href="?page=TWCH_settings&tab=ready_message" class="nav-tab <?php echo $active_tab == 'ready_message' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e('Ready Message', 'TWCHLANG'); ?></a> 





                    <?php endif; ?>
     <a href="?page=TWCH_settings&tab=Float" class="nav-tab <?php echo $active_tab == 'Float' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e('Float','TWCHLANG'); ?></a>  
            <a href="?page=TWCH_settings&tab=Accessibility" class="nav-tab <?php echo $active_tab == 'Accessibility' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e('Accessibility','TWCHLANG'); ?></a>  

        </h2>
        </div>
        <form method="post">
            <?php
            //insert nonce field in form.
            wp_nonce_field( 'TWCH_nonce_field' ); 
            if (in_array($active_tab,array('General','ready_message','Float','Accessibility'))) {
                require_once "Settings/$active_tab.php";
            }
        ?>
 
        </form> 
    </div>
