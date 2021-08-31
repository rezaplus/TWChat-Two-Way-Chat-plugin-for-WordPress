<div class="dtwpFloatBox" id="dtwpFloatBox">
    <div class="dtwpBoxHeader">
    <svg onclick="document.getElementById('dtwpFloatBox').classList.toggle('show');" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M15.71,8.29a1,1,0,0,0-1.42,0L12,10.59,9.71,8.29A1,1,0,0,0,8.29,9.71L10.59,12l-2.3,2.29a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0L12,13.41l2.29,2.3a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42L13.41,12l2.3-2.29A1,1,0,0,0,15.71,8.29Zm3.36-3.36A10,10,0,1,0,4.93,19.07,10,10,0,1,0,19.07,4.93ZM17.66,17.66A8,8,0,1,1,20,12,7.95,7.95,0,0,1,17.66,17.66Z"/></svg>
    <div class="dtwpFloatBoxTitle"><?php esc_html_e($float_option['floatBoxHeaderTitle']); ?></div>
    <p><?php esc_html_e($float_option['floatBoxHeaderDecs']) ?></p>
    </div>
    <div class="dtwpBox">
        <div class="dtwpBoxFAQ">
            <ul>
                <?php 
                    $DTWP_FAQ_list = get_option('DTWP_FAQ_list');
                    if(!empty($DTWP_FAQ_list)){
                        foreach($DTWP_FAQ_list as $FAQInfos){
                            $FAQ = get_option($FAQInfos);
                ?>  
                        <li>
                            <div class="dtwpBoxQuestion">
                                <label for="<?php esc_attr_e($FAQInfos) ?>"> <span>⦿ </span><?php esc_html_e($FAQ['DTW_FAQ_Question']); ?></label>
                                <input type="checkbox" id="<?php esc_attr_e($FAQInfos); ?>">
                                <div class="dtwpBoxAnswer"><?php esc_html_e($FAQ['DTW_FAQ_Answer']) ?></div>
                            </div>
        
                        </li>
                <?php
                        } 
                    }
                ?>
            </ul>
        </div>
        <div class="dtwpBoxAccounts">
            <ul>
                <?php
                $Accounts_info = get_option('DTWP_Accounts_list'); 
                if(!empty($Accounts_info)){
                    foreach($Accounts_info as $Account){
                        $ACSInfo=get_option($Account);
                        $availableTime="";
                        $availableLiClass="";
                        $ACSWhatsapp="";
                        if(!empty($ACSInfo['Account-availableFrom']) 
                        and ($ACSInfo['Account-availableFrom'] > date("H:i",current_time('timestamp')) 
                        or date("H:i",current_time('timestamp')) > $ACSInfo['Account-availableTo'])){
                            $availableTime = __('Available from','DTWPLANG').' '. $ACSInfo['Account-availableFrom'] .' '.__('To','DTWPLANG').' '.$ACSInfo['Account-availableTo'];
                            $availableLiClass = 'notAvailable';
                        }else{
                            $floatApplication = get_option('DTWP_General_Option')['floatApplication'];
                            if(!wp_is_mobile()){
                                //Desktop
                                if($floatApplication=='app'){
                                    $floatApplication = 'whatsapp://';
                                }elseif($floatApplication = 'web'){
                                    $floatApplication = 'https://web.whatsapp.com/';
                                }else{
                                    $floatApplication = 'https://api.whatsapp.com/';
                                }
                            }else{
                                //Mobile
                                $floatApplication = 'https://api.whatsapp.com/';
                            }
                            
                            $ACSWhatsapp = $floatApplication.'send?phone='.$ACSInfo['Country_Code'].$ACSInfo['Account-whatsapp-number'].'&text='.$ACSInfo['DefaultText'];
                        }
                        ?>
                        <li class="<?php esc_attr_e($availableLiClass); ?>"><a href="<?php esc_attr_e($ACSWhatsapp); ?>" target="_blank">
                            <div class="dtwpBoxACSF">
                                <img alt="<?php esc_html_e($ACSInfo['Account-name']) ?>" src="<?php echo esc_url($ACSInfo['img-ACS']); ?>">
                            </div>
                            <div class="dtwpBoxACSL">
                                <div class="dtwBoxACSTitle"> <?php esc_html_e($ACSInfo['Account-title']); ?></div>
                                <div class="dtwBoxACSName"><?php esc_html_e($ACSInfo['Account-name']);?></div>
                                <div class="dtwBoxACSavailableTime"><?php echo isset($availableTime) ? esc_html($availableTime) : ''; ?></div>
                            </div>
                        </a></li>
            <?php
                    }
                }
            ?>
            </ul>
        </div>
    </div>
    <div class="dtwpBoxSocials">
        <?php
        $DTWP_social = get_option('DTWP_Float_social');
        if(!empty($DTWP_social)){
            foreach($DTWP_social as $key => $value){
                $link = DTWP_image.'socialIcons/'.$key.'.svg';
                echo "<a href='".esc_url($value)."' target='_blank'><img alt='Social' src='".esc_url($link)."'></a>";
            }
        }
        ?>
    </div>
</div>