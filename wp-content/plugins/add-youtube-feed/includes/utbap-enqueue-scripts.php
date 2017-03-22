<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

add_action( 'wp_enqueue_scripts', 'utbap_enqueue_styles', 10);
add_action( 'admin_enqueue_scripts', 'utbap_admin_enqueue_styles', 10);
add_action( 'admin_enqueue_scripts', 'utbapload_wp_media_files' );

function utbap_enqueue_styles() {
	
		wp_enqueue_script('jquery');
		
		wp_register_script( 'utbap_lib_js', plugin_dir_url( __FILE__ ) . '../js/youmax-pro.min.js', array( 'jquery' ) );
		wp_enqueue_script( 'utbap_lib_js');
		
		wp_register_style( 'utbap_lib_css', plugin_dir_url( __FILE__ )  . '../css/youmax-pro.min.css', false, '1.0.0' );
		wp_enqueue_style( 'utbap_lib_css');

		

}


function utbap_admin_enqueue_styles() {
	
		wp_enqueue_script('jquery');
		
		wp_enqueue_style( 'wp-color-picker' );
    	wp_register_script( 'wp-color-picker-script',  plugin_dir_url(__FILE__) .'../js/script.js', array( 'wp-color-picker' ), false, true );
		wp_enqueue_script( 'wp-color-picker-script');
}

function utbapload_wp_media_files() {
    wp_enqueue_media();
}