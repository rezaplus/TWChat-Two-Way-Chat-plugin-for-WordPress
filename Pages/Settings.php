    <?php
    wp_enqueue_style('DTWP-admin-style',  DTWP_assets .'admin-style.css', array() , DTWP_plugin_version);

    if( isset( $_GET[ 'tab' ] ) ) {  
        $active_tab = sanitize_text_field( $_GET[ 'tab' ] );  
    } else {
        $active_tab = 'General';
    }
    ?>  
    <div class="wrap <?= is_rtl() ?  'DTWP_RTL' : '' ?>">
        <div class="DTW-header">
        <h1 class="Page_title"><?php esc_html_e('Settings','DTWPLANG'); ?></h1>
        <h2 class="nav-tab-wrapper">
            <a href="?page=DTWP_settings&tab=General" class="nav-tab <?=  $active_tab == 'General' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e('General','DTWPLANG'); ?></a>  
            <a href="?page=DTWP_settings&tab=Qmessage" class="nav-tab <?= $active_tab == 'Qmessage' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e('Quick message','DTWPLANG'); ?></a> 
            <a href="?page=DTWP_settings&tab=Float" class="nav-tab <?= $active_tab == 'Float' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e('Float','DTWPLANG'); ?></a>  
            <a href="?page=DTWP_settings&tab=Accessibility" class="nav-tab <?= $active_tab == 'Accessibility' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e('Accessibility','DTWPLANG'); ?></a>  

        </h2>  
        </div>
        <form method="post"> 
        <?php
            require_once "Settings/$active_tab.php";
        ?>
 
        </form> 
    </div>
     