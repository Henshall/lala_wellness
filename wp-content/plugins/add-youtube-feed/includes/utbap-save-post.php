<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

add_action( 'save_post', 'utbap_save_form' );

function utbap_save_form( $post_id ) {

	$post_type = get_post_type($post_id);
// If this isn't a 'sfba_subscribe_form' post, don't update it.
	if ( "utbap_youtube_feed" != $post_type ) {
		return;
	}

// Stop WP from clearing custom fields on autosave
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE){
		return;
	}

// Prevent quick edit from clearing custom fields
	if (defined('DOING_AJAX') && DOING_AJAX){
		return;
	}

   /* if( !isset( $_POST['wssf_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['wssf_meta_box_nonce'], 'wssf_ui_meta_box_nonce' ) ) return;
     
    if ( ! current_user_can( 'manage_options' ) )
        return;*/
     
// - Update the post's metadata.
	if ( isset( $_POST['utbap_youtube_channel_link'] ) ) {
		update_post_meta( $post_id, '_utbap_youtube_channel_link', sanitize_text_field( $_POST['utbap_youtube_channel_link'] ) );
	}
	if ( isset( $_POST['utbap_videos_to_show'] ) ) {
		update_post_meta( $post_id, '_utbap_videos_to_show', sanitize_text_field( $_POST['utbap_videos_to_show'] ) );
	}
	if ( isset( $_POST['utbap_sorting_order'] ) ) {
		update_post_meta( $post_id, '_utbap_sorting_order', sanitize_text_field( $_POST['utbap_sorting_order'] ) );
	}
	if ( isset( $_POST['utbap_header_templates'] ) ) {
		update_post_meta( $post_id, '_utbap_header_templates', sanitize_text_field( $_POST['utbap_header_templates'] ) );
	}
	if ( isset( $_POST['utbap_template1_bg'] ) ) {
		update_post_meta( $post_id, '_utbap_template1_bg', sanitize_text_field( $_POST['utbap_template1_bg'] ) );
	}
	if ( isset( $_POST['utbap_template2_bg'] ) ) {
		update_post_meta( $post_id, '_utbap_template2_bg', sanitize_text_field( $_POST['utbap_template2_bg'] ) );
	}
	if ( isset( $_POST['utbap_background_color'] ) ) {
		update_post_meta( $post_id, '_utbap_background_color', sanitize_text_field( $_POST['utbap_background_color'] ) );
	}
	if ( isset( $_POST['utbap_thumbnail_background_color'] ) ) {
		update_post_meta( $post_id, '_utbap_thumbnail_background_color', sanitize_text_field( $_POST['utbap_thumbnail_background_color'] ) );
	}
	if ( isset( $_POST['utbap_header_background_color'] ) ) {
		update_post_meta( $post_id, '_utbap_header_background_color', sanitize_text_field( $_POST['utbap_header_background_color'] ) );
	}
	if ( isset( $_POST['utbap_header_text_color'] ) ) {
		update_post_meta( $post_id, '_utbap_header_text_color', sanitize_text_field( $_POST['utbap_header_text_color'] ) );
	}
	if ( isset( $_POST['utbap_thumbnail_title_color'] ) ) {
		update_post_meta( $post_id, '_utbap_thumbnail_title_color', sanitize_text_field( $_POST['utbap_thumbnail_title_color'] ) );
	}
	if ( isset( $_POST['utbap_thumbnail_description_color'] ) ) {
		update_post_meta( $post_id, '_utbap_thumbnail_description_color', sanitize_text_field( $_POST['utbap_thumbnail_description_color'] ) );
	}
	if ( isset( $_POST['utbap_view_date_color'] ) ) {
		update_post_meta( $post_id, '_utbap_view_date_color', sanitize_text_field( $_POST['utbap_view_date_color'] ) );
	}
	if ( isset( $_POST['utbap_tabs_color'] ) ) {
		update_post_meta( $post_id, '_utbap_tabs_color', sanitize_text_field( $_POST['utbap_tabs_color'] ) );
	}
	if ( isset( $_POST['utbap_loading_button_color'] ) ) {
		update_post_meta( $post_id, '_utbap_loading_button_color', sanitize_text_field( $_POST['utbap_loading_button_color'] ) );
	}
	if ( isset( $_POST['utbap_base_font_size'] ) ) {
		update_post_meta( $post_id, '_utbap_base_font_size', sanitize_text_field( $_POST['utbap_base_font_size'] ) );
	}
	if ( isset( $_POST['utbap_title_font_family'] ) ) {
		update_post_meta( $post_id, '_utbap_title_font_family', sanitize_text_field( $_POST['utbap_title_font_family'] ) );
	}
	if ( isset( $_POST['utbap_title_boldness'] ) ) {
		update_post_meta( $post_id, '_utbap_title_boldness', sanitize_text_field( $_POST['utbap_title_boldness'] ) );
	}
	if ( isset( $_POST['utbap_general_font_family'] ) ) {
		update_post_meta( $post_id, '_utbap_general_font_family', sanitize_text_field( $_POST['utbap_general_font_family'] ) );
	}

	if ( isset( $_POST['utbap_channel_style'] ) ) {
		update_post_meta( $post_id, '_utbap_channel_style', sanitize_text_field( $_POST['utbap_channel_style'] ) );
	}
	if ( isset( $_POST['utbap_video_display_mode'] ) ) {
		update_post_meta( $post_id, '_utbap_video_display_mode', sanitize_text_field( $_POST['utbap_video_display_mode'] ) );
	}
	if ( isset( $_POST['utbap_loading_mechanism'] ) ) {
		update_post_meta( $post_id, '_utbap_loading_mechanism', sanitize_text_field( $_POST['utbap_loading_mechanism'] ) );
	}
	if ( isset( $_POST['utbap_video_thumbnail_view'] ) ) {
		update_post_meta( $post_id, '_utbap_video_thumbnail_view', sanitize_text_field( $_POST['utbap_video_thumbnail_view'] ) );
	}
	if ( isset( $_POST['utbap_default_tab'] ) ) {
		update_post_meta( $post_id, '_utbap_default_tab', sanitize_text_field( $_POST['utbap_default_tab'] ) );
	}
	if ( isset( $_POST['utbap_cta_button_text'] ) ) {
		update_post_meta( $post_id, '_utbap_cta_button_text', sanitize_text_field( $_POST['utbap_cta_button_text'] ) );
	}
	if ( isset( $_POST['utbap_cta_url'] ) ) {
		update_post_meta( $post_id, '_utbap_cta_url', sanitize_text_field( $_POST['utbap_cta_url'] ) );
	}
	if ( isset( $_POST['utbap_date_format'] ) ) {
		update_post_meta( $post_id, '_utbap_date_format', sanitize_text_field( $_POST['utbap_date_format'] ) );
	}

	
	if ( isset( $_REQUEST['utbap_hide_duration'] ) ) {
		update_post_meta($post_id, '_utbap_hide_duration', TRUE);
	} else {
		update_post_meta($post_id, '_utbap_hide_duration', FALSE);
	}
	if ( isset( $_REQUEST['utbap_video_icon'] ) ) {
		update_post_meta($post_id, '_utbap_video_icon', TRUE);
	} else {
		update_post_meta($post_id, '_utbap_video_icon', FALSE);
	}
	if ( isset( $_REQUEST['utbap_video_icon_style'] ) ) {
		update_post_meta($post_id, '_utbap_video_icon_style', TRUE);
	} else {
		update_post_meta($post_id, '_utbap_video_icon_style', FALSE);
	}

	
	if ( isset( $_REQUEST['utbap_hide_header'] ) ) {
		update_post_meta($post_id, '_utbap_hide_header', TRUE);
	} else {
		update_post_meta($post_id, '_utbap_hide_header', FALSE);
	}
	if ( isset( $_REQUEST['utbap_hide_search'] ) ) {
		update_post_meta($post_id, '_utbap_hide_search', TRUE);
	} else {
		update_post_meta($post_id, '_utbap_hide_search', FALSE);
	}
		if ( isset( $_REQUEST['utbap_hide_sorting'] ) ) {
		update_post_meta($post_id, '_utbap_hide_sorting', TRUE);
	} else {
		update_post_meta($post_id, '_utbap_hide_sorting', FALSE);
	}
	if ( isset( $_REQUEST['utbap_hide_switcher'] ) ) {
		update_post_meta($post_id, '_utbap_hide_switcher', TRUE);
	} else {
		update_post_meta($post_id, '_utbap_hide_switcher', FALSE);
	}
	if ( isset( $_REQUEST['utbap_hide_popup_details'] ) ) {
		update_post_meta($post_id, '_utbap_hide_popup_details', TRUE);
	} else {
		update_post_meta($post_id, '_utbap_hide_popup_details', FALSE);
	}
	if ( isset( $_REQUEST['utbap_cta_button'] ) ) {
		update_post_meta($post_id, '_utbap_cta_button', TRUE);
	} else {
		update_post_meta($post_id, '_utbap_cta_button', FALSE);
	}



	if ( isset( $_REQUEST['utbap_auto_play'] ) ) {
		update_post_meta($post_id, '_utbap_auto_play', TRUE);
	} else {
		update_post_meta($post_id, '_utbap_auto_play', FALSE);
	}
	if ( isset( $_REQUEST['utbap_load_more'] ) ) {
		update_post_meta($post_id, '_utbap_load_more', TRUE);
	} else {
		update_post_meta($post_id, '_utbap_load_more', FALSE);
	}
	if ( isset( $_REQUEST['utbap_hide_tabs'] ) ) {
		update_post_meta($post_id, '_utbap_hide_tabs', TRUE);
	} else {
		update_post_meta($post_id, '_utbap_hide_tabs', FALSE);
	}
	if ( isset( $_REQUEST['utbap_subscribe_button'] ) ) {
		update_post_meta($post_id, '_utbap_subscribe_button', TRUE);
	} else {
		update_post_meta($post_id, '_utbap_subscribe_button', FALSE);
	}
	if ( isset( $_REQUEST['utbap_subscriber_count'] ) ) {
		update_post_meta($post_id, '_utbap_subscriber_count', TRUE);
	} else {
		update_post_meta($post_id, '_utbap_subscriber_count', FALSE);
	}


}