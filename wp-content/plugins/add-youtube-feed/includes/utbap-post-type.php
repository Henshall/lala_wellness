<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

add_action( 'init', 'utbap_youtube_feed_function' );
add_action('admin_menu', 'utbap_custom_menu_pages');

function utbap_youtube_feed_function() {
    $labels = array(
        'name'               => _x( 'YouTube Channel', 'post type general name' ),
        'singular_name'      => _x( 'YouTube Channel', 'post type singular name' ),
        'menu_name'          => _x( 'YouTube Channel', 'admin menu' ),
        'name_admin_bar'     => _x( 'YouTube Channel', 'add new on admin bar' ),
        'add_new'            => _x( 'Add New', 'Channel' ),
        'add_new_item'       => __( 'Add New YouTube Channel' ),
        'new_item'           => __( 'New YouTube Channel' ),
        'edit_item'          => __( 'Edit YouTube Channel' ),
        'view_item'          => __( 'View YouTube Channel' ),
        'all_items'          => __( 'All YouTube Feeds' ),
        'search_items'       => __( 'Search YouTube Feeds' ),
        'parent_item_colon'  => __( 'Parent YouTube Feeds:' ),
        'not_found'          => __( 'No Channel found.' ),
        'not_found_in_trash' => __( 'No Channel found in Trash.' )
        );

    $args = array(
        'labels'             => $labels,
        'description'        => __( 'Add YouTube channel or YouTube Playlist into your WordPress site' ),
        'public'             => true,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'rewrite'            => array( 'slug' => 'utbap_youtube_feed' ),
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 20,
        'menu_icon'		 => 'dashicons-playlist-video',
        'supports'           => array( 'title' )
        );

    register_post_type( 'utbap_youtube_feed', $args );
}

function utbap_custom_menu_pages() {

add_submenu_page(
    'edit.php?post_type=utbap_youtube_feed',
    'Support',
    'Support',
    'manage_options',
    'utbap_form_support',
    'utbap_support_page' );

}


function utbap_support_page(){
    include_once( 'utbap-support-page.php' );
}

function utbap_settings_after_title() {

    $scr = get_current_screen();
    
    if( $scr-> post_type !== 'utbap_youtube_feed' )
        return;

    include_once( 'utbap-settings-page.php' );
}

add_action( 'edit_form_after_title', 'utbap_settings_after_title' );
/*function admin_redirects() {
    global $pagenow;

    if($pagenow == 'edit.php' && isset($_GET['post_type']) && $_GET['post_type'] == 'utbap_youtube_feed' ){
        if (isset($_GET['access_token'])) {
            
        wp_redirect(admin_url('/edit.php?post_type=utbap_youtube_feed&page=utbap_settings&access_token='.$_GET["access_token"], 'http'));
        exit;
    }
}
}

add_action('admin_init', 'admin_redirects');
*/
/*    if (isset($_GET['access_token'])) {
$url = urlencode(admin_url('edit.php?post_type=utbap_twitter_feed&page=utbap_settings&access_token').$_GET["access_token"]) ;
wp_redirect( $url ); exit;
}
*/

add_action('load-post-new.php', 'utbap_limit_youtube_feed' );

function utbap_limit_youtube_feed()
{
global $typenow;

if( 'utbap_youtube_feed' !== $typenow )
return;

$total = get_posts( array( 
'post_type' => 'utbap_youtube_feed', 
'numberposts' => -1, 
'post_status' => 'publish,future,draft' 
));

if( $total && count( $total ) >= 2 )
wp_die(
'<p style="text-align:center;font-weight:bold;">Sorry, Creation of maximum number of YouTube Channel Feeds exceeds.<br/>Please <a href="https://www.arrowplugins.com/youtube-feed" target="_blank">Buy Premium Version</a> or Delete Previously Created Feeds to create more YouTube Channel Feeds With Awesome Features</p>', 
'Maximum reached',  
array( 
'response' => 500, 
'back_link' => true 
)
);  
}