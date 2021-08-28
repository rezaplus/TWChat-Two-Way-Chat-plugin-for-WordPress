        <?php  
        if( isset( $_GET[ 'sT' ] ) ) {  
            $active_Stab = $_GET[ 'sT' ];  
        } else {
            $active_Stab = 'Style';
        }
        ?>  
        <div class="wrap">
            <?php settings_errors(); ?> 
            <h2 class="nav-tab-wrapper">  
                <a href="?page=DTWP_settings&tab=Float&sT=Style" class="nav-tab <?= $active_Stab == 'Style' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e('Style','DTWPLANG'); ?></a> 
                <a href="?page=DTWP_settings&tab=Float&sT=FAQ" class="nav-tab <?= $active_Stab == 'FAQ' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e('FAQ List','DTWPLANG'); ?></a> 
                <a href="?page=DTWP_settings&tab=Float&sT=Accounts" class="nav-tab <?= $active_Stab == 'Accounts' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e('Accounts','DTWPLANG'); ?></a> 
                <a href="?page=DTWP_settings&tab=Float&sT=Social" class="nav-tab <?= $active_Stab == 'Social' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e('Social','DTWPLANG'); ?></a>  
            </h2>  
            </div>
            <form method="post"> 
            <?php
                require_once "Float/$active_Stab.php";

            ?>

                
            </form> 

        </div>