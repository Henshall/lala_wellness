<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

add_action( 'add_meta_boxes' , 'utbap_add_meta_boxes');

/* META BOXES */

function utbap_add_meta_boxes(){
// Shortcode meta box
		 add_meta_box( 'utbap_buy_premium_meta_box' , 'Buy Premium And:' , 'utbap_premium_version' , 'utbap_youtube_feed' , 'side' , 'high'); 
 add_meta_box( 'utbap_promotion_meta_box2' , 'You may also need:' , 'utbap_promotion2' , 'utbap_youtube_feed' , 'side'); 

}


function utbap_premium_version(){

 ?> <style type="text/css"> .utbap-action-button{ width: 93%; text-align: center; background: #e14d43; display: block; padding: 18px 8px; font-size: 16px; border-radius: 5px; color: white; text-decoration: none; border: 2px solid #e14d43;

 transition: all 0.2s; } .utbap-action-button:hover{ width: 93%; text-align: center; display: block; padding: 18px 8px; font-size: 16px; border-radius: 5px; color: white !important; text-decoration: none; background: #bb4138 !important; border: 2px solid #bb4138; }

 </style><strong> <ul> <li> - Unlock All Video Display Modes</li> <li> - Unlock All Templates</li> <li> - Unlock CTA Functionality</li><li> - Unlock Like Video Feature</li> <li> - Unlock Video Comments Feature</li><li> - Unlock Video Sharing (Facebook, Twitter & Google+) Feature</li> <li> - Unlock Video Details Feature</li> <li> - Unlock Hover Animation</li> <li> - Unlock Style Editor</li><li> - Get 24/7 Premium Support</li> <li> - Unlimited Updates</li> </ul> </strong> <a href="https://www.arrowplugins.com/youtube-feed" target="_blank" class="utbap-action-button">GET PREMIUM NOW</a> <?php }


 function utbap_promotion2(){ ?> <style type="text/css"> #utbap_promotion_meta_box2 .inside{ margin: 0 !important; padding:0; margin-top: 5px; } </style><p style="font-weight: bold; text-align: center;font-size: 20px;margin :0;padding: 0;"><a target="_blank" href="https://www.arrowplugins.com/subscribe-form">Subscribe Form</a></p> <a href="https://www.arrowplugins.com/subscribe-form" target="_blank"><img width="100%" src="<?php echo plugins_url('images/sub-product.png' , __FILE__); ?>" /></a> <p style="font-weight: bold; text-align: center;font-size: 20px;margin :0;padding: 0;"><a target="_blank" href="https://www.arrowplugins.com/instagram-feed">Instagram Feed</a></p><a href="https://www.arrowplugins.com/instagram-feed" target="_blank"><img width="100%" src="<?php echo plugins_url('images/promo.png' , __FILE__); ?>" /></a>
<p style="font-weight: bold; text-align: center;font-size: 20px;margin :0;padding: 0;"><a target="_blank" href="https://www.arrowplugins.com/facebook-feed">Facebook Feed</a></p><a href="https://www.arrowplugins.com/facebook-feed" target="_blank"><img width="100%" src="<?php echo plugins_url('images/fb-promo.png' , __FILE__); ?>" /></a>
 <strong> <ul style="margin-left: 10px;">  </ul> </strong> <?php }  

