<?php 
/*
Plugin Name: YouTube Embedded Chennal & Playlist
Plugin URI: https://wordpress.org/plugins/add-youtube-feed
Description: Add YouTube channel or YouTube Playlist into your WordPress site.
Author: Arrow Plugins
Author URI: https://www.arrowplugins.com
Version: 1.0
License: GplV2
Copyright: 2017 Arrow Plugins
*/
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
define( 'UTBAP_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
include_once('includes/utbap-post-type.php');
include_once('includes/utbap-custom-columns.php');
include_once('includes/utbap-post-meta-boxes.php');
include_once('includes/utbap-save-post.php');
include_once('includes/utbap-shortcode.php');
include_once('includes/utbap-enqueue-scripts.php');

add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'utbap_plugin_action_links' );

function utbap_plugin_action_links( $links ) {
   $links[] = '<a href="'. esc_url( get_admin_url(null, 'edit.php?post_type=utbap_youtube_feed') ) .'">Dashboard</a>';
   return $links;
}