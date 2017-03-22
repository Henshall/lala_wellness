<?php 

add_shortcode( 'arrow_youtube', 'utbap_youtube_feed_shortcode' );

function utbap_youtube_feed_shortcode($atts , $content){

	extract( shortcode_atts( array( 'id' => null ) , $atts ) );
	$utbap_youtube_channel_link = get_post_meta( $id, '_utbap_youtube_channel_link', true);
	$utbap_videos_to_show = get_post_meta( $id, '_utbap_videos_to_show', true);
	$utbap_channel_style = get_post_meta( $id, '_utbap_channel_style', true);
	$utbap_video_display_mode = get_post_meta( $id, '_utbap_video_display_mode', true);
	$utbap_hide_header = get_post_meta( $id, '_utbap_hide_header', true);
	$utbap_load_more = get_post_meta( $id, '_utbap_load_more', true);
	$utbap_hide_tabs = get_post_meta($id, '_utbap_hide_tabs', true);
	$utbap_subscribe_button = get_post_meta( $id, '_utbap_subscribe_button', true);
	$utbap_subscriber_count = get_post_meta( $id, '_utbap_subscriber_count', true);
	$utbap_auto_play = get_post_meta( $id, '_utbap_auto_play', true);
	$utbap_sorting_order = get_post_meta( $id, '_utbap_sorting_order', true);
	$utbap_video_thumbnail_view = get_post_meta( $id, '_utbap_video_thumbnail_view', true);
	$utbap_loading_mechanism = get_post_meta( $id, '_utbap_loading_mechanism', true);
	$utbap_hide_search = get_post_meta( $id, '_utbap_hide_search', true);
	$utbap_hide_sorting = get_post_meta( $id, '_utbap_hide_sorting', true);
	$utbap_hide_switcher = get_post_meta( $id, '_utbap_hide_switcher', true);
	$utbap_hide_popup_details = get_post_meta( $id, '_utbap_hide_popup_details', true);
	$utbap_cta_button = get_post_meta( $id, '_utbap_cta_button', true);
	$utbap_default_tab = get_post_meta( $id, '_utbap_default_tab', true);
	$utbap_cta_button_text = get_post_meta( $id, '_utbap_cta_button_text', true);
	$utbap_cta_url = get_post_meta( $id, '_utbap_cta_url', true);
	$utbap_date_format = get_post_meta( $id, '_utbap_date_format', true);
	$utbap_hide_duration = get_post_meta( $id, '_utbap_hide_duration', true);
	$utbap_video_icon = get_post_meta( $id, '_utbap_video_icon', true);
	$utbap_video_icon_style = get_post_meta( $id, '_utbap_video_icon_style', true);
	$utbap_header_templates = get_post_meta( $id, '_utbap_header_templates', true);
	$utbap_header_templates = get_post_meta( $id, '_utbap_header_templates', true);
	$utbap_template1_bg = get_post_meta( $id, '_utbap_template1_bg', true);
	$utbap_template2_bg = get_post_meta( $id, '_utbap_template2_bg', true);


$utbap_background_color = get_post_meta( $id, '_utbap_background_color', true);
$utbap_thumbnail_background_color = get_post_meta( $id, '_utbap_thumbnail_background_color', true);
$utbap_header_background_color = get_post_meta( $id, '_utbap_header_background_color', true);
$utbap_header_text_color = get_post_meta( $id, '_utbap_header_text_color', true);
$utbap_thumbnail_title_color = get_post_meta( $id, '_utbap_thumbnail_title_color', true);
$utbap_thumbnail_description_color = get_post_meta( $id, '_utbap_thumbnail_description_color', true);
$utbap_view_date_color = get_post_meta( $id, '_utbap_view_date_color', true);
$utbap_tabs_color = get_post_meta( $id, '_utbap_tabs_color', true);
$utbap_loading_button_color = get_post_meta( $id, '_utbap_loading_button_color', true);
$utbap_base_font_size = get_post_meta( $id, '_utbap_base_font_size', true);
$utbap_title_font_family = get_post_meta( $id, '_utbap_title_font_family', true);
$utbap_title_boldness = get_post_meta( $id, '_utbap_title_boldness', true);
$utbap_general_font_family = get_post_meta( $id, '_utbap_general_font_family', true);

	ob_start();

	?>

	<style>

		#your-page-column {
			width: 100%;
			margin: 0px auto;
		}

/*@media all and (max-width: 1400px) , screen and (max-device-width: 1400px) {

#your-page-column {
width: 65%;
}

}*/
.yl-channel-search input.yl-channel-search-input {
	padding-bottom: 0;
	margin-bottom: 0;
}
.yl-channel-search i.fa.fa-search {
	position: absolute;
	top: 11px;
	right: 10px;
}
.yl-channel-search {
	display: inline-block;
	float: right;
	margin-top: 1.5em;
	background-color: #fff;
	color: #000;
	padding: .3em .5em;
	position: relative;
	padding: 0;
}
.yl-list-title select#yl-sort-order {
	width: 200px;
	height: 32px;
	line-height: 1;
}

@media all and (max-width: 1100px) , screen and (max-device-width: 1100px) {

	#your-page-column {
		width: 70%;
	}

}

@media all and (max-width: 900px) , screen and (max-device-width: 900px) {

	#your-page-column {
		width: 90%;
	}

}

@media all and (max-width: 800px) , screen and (max-device-width: 800px) {

	#your-page-column {
		width: 100%;
	}

}

</style>


<div id="your-page-column" class="not-a-part-of-youmax-plugin">
	<div id="ymax" class="youmax-pro"></div>
</div>

<script>

	var utbap_youtube_channel_link = '<?php echo $utbap_youtube_channel_link; ?>';
	var utbap_videos_to_show = '<?php echo $utbap_videos_to_show; ?>';
	var utbap_auto_play = '<?php echo $utbap_auto_play; ?>';
	var utbap_sorting_order = '<?php echo $utbap_sorting_order; ?>';
	var utbap_loading_mechanism = '<?php echo $utbap_loading_mechanism; ?>';
	var utbap_default_tab = '<?php echo $utbap_default_tab; ?>';
	var utbap_channel_style = '<?php echo $utbap_channel_style; ?>';
	var utbap_video_display_mode = '<?php echo $utbap_video_display_mode; ?>';
	var utbap_video_thumbnail_view = '<?php echo $utbap_video_thumbnail_view; ?>';
	var utbap_hide_header = '<?php echo $utbap_hide_header; ?>';
	var utbap_load_more = '<?php echo $utbap_load_more; ?>';
	var utbap_hide_tabs = '<?php echo $utbap_hide_tabs; ?>';
	var utbap_hide_search = '<?php echo $utbap_hide_search; ?>';
	var utbap_hide_sorting = '<?php echo $utbap_hide_sorting; ?>';
	var utbap_hide_switcher = '<?php echo $utbap_hide_switcher; ?>';
	var utbap_hide_popup_details = '<?php echo $utbap_hide_popup_details; ?>';
	var utbap_cta_button = '<?php echo $utbap_cta_button; ?>';
	var utbap_date_format = '<?php echo $utbap_date_format; ?>';

	var cta_button = '';
	if(utbap_cta_button == 1){
		cta_button = false;
	}else{
		cta_button = true;
	}

	var utbap_cta_button_text = '<?php echo $utbap_cta_button_text; ?>';
	var utbap_cta_url = '<?php echo $utbap_cta_url; ?>';
	var utbap_date_format = '<?php echo $utbap_date_format; ?>';
	var utbap_hide_duration = '<?php echo $utbap_hide_duration; ?>';
	var utbap_video_icon = '<?php echo $utbap_video_icon; ?>';
	var utbap_video_icon_style = '<?php echo $utbap_video_icon_style; ?>';
	var utbap_header_templates = '<?php echo $utbap_header_templates; ?>';

	var utbap_template1_bg = '<?php echo $utbap_template1_bg; ?>';
	var utbap_template2_bg = '<?php echo $utbap_template2_bg; ?>';
	var utbap_background_color = '<?php echo $utbap_background_color; ?>';
	var utbap_thumbnail_background_color = '<?php echo $utbap_thumbnail_background_color; ?>';
	var utbap_header_background_color = '<?php echo $utbap_header_background_color; ?>';
	var utbap_header_text_color = '<?php echo $utbap_header_text_color; ?>';
	var utbap_thumbnail_title_color = '<?php echo $utbap_thumbnail_title_color; ?>';
	var utbap_thumbnail_description_color = '<?php echo $utbap_thumbnail_description_color; ?>';
	var utbap_view_date_color = '<?php echo $utbap_view_date_color; ?>';
	var utbap_tabs_color = '<?php echo $utbap_tabs_color; ?>';
	var utbap_loading_button_color = '<?php echo $utbap_loading_button_color; ?>';
	var utbap_base_font_size = '<?php echo $utbap_base_font_size; ?>';
	var utbap_title_font_family = '<?php echo $utbap_title_font_family; ?>';
	var utbap_title_boldness = '<?php echo $utbap_title_boldness; ?>';
	var utbap_general_font_family = '<?php echo $utbap_general_font_family; ?>';



	jQuery(document).ready(function(){

		jQuery(".youmax-pro").youmaxPro({
			apiKey:"AIzaSyCWcEqdAVwz6T-HZRT0Bc3cxULjcm09Vjw",
			channelLinkForHeader:utbap_youtube_channel_link,
			tabs:[
			{
				name:"Uploads",
				type:"youtube-channel-uploads",
				link:utbap_youtube_channel_link,
			},
			{
				name:"Playlists",
				type:"youtube-channel-playlists",
				link:utbap_youtube_channel_link
			},

			],
			defaultTab:utbap_default_tab,      
			videoDisplayMode:utbap_video_display_mode,  



			maxResults:utbap_videos_to_show,
			autoPlay:utbap_auto_play,
			minimumViewsPerDayForTrendingVideos:"100",  

			displayFirstVideoOnLoad:true,       
			defaultSortOrder:utbap_sorting_order,   
			youmaxDisplayMode:utbap_channel_style,          
			gridThumbnailType:utbap_video_thumbnail_view,       
			dateFormat:utbap_date_format,            

			youmaxBackgroundColor     :utbap_background_color,
			itemBackgroundColor       :utbap_thumbnail_background_color,
			headerBackgroundColor     :utbap_header_background_color,
			headerTextColor           :utbap_header_text_color,
			tabsColor                 :utbap_tabs_color,
			titleColor                :utbap_thumbnail_title_color,
			descriptionColor          :utbap_thumbnail_description_color,
			viewsColor                :utbap_view_date_color,
			controlsTextColor         :utbap_loading_button_color,

			offerBackgroundColor      :"#fbfbfb",
			offerTextColor            :"#686868",
			offerHighlightColor       :"#FFC107",

			titleFontFamily           :utbap_title_font_family,          
			generalFontFamily         :utbap_general_font_family,        
			titleFontSize             :"0.9",
			titleFontWeight           :utbap_title_boldness,             
			descriptionFontSize       :"0.85",
			viewsDateFontSize         :"0.75",
			baseFontSize              :"16px",               
			offerTitleFontSize          :"1.3",
			offerDescriptionFontSize    :"0.85",
			offerButtonFontSize         :"1",

			responsiveBreakpoints   :[600,900,1050,1600],

			loadingMechanism        :utbap_loading_mechanism,       
			loadMoreText            :"<i class=\"fa fa-plus\"></i>&nbsp;&nbsp;Load more..",
			ctaText                 :"<i class=\"fa fa-arrow-circle-right\"></i>&nbsp;&nbsp;"+utbap_cta_button_text,
			ctaLink                 :utbap_cta_url,
			previousButtonText      :"<i class=\"fa fa-angle-left\"></i>&nbsp;&nbsp;Previous",
			nextButtonText          :"Next&nbsp;&nbsp;<i class=\"fa fa-angle-right\"></i>",
			loadingText             :"loading...",
			allDoneText             :"<i class=\"fa fa-times\"></i>&nbsp;&nbsp;All done..",

	

			hideHeader              :utbap_hide_header,
			hideSearch              :utbap_hide_search,
			hideTabs                :utbap_hide_tabs,
			hideSorting             :utbap_hide_sorting,
			hideViewSwitcher        :true,
			hideLoadingMechanism    :utbap_load_more,
			hideCtaButton           :cta_button,
			hidePopupDetails        :true,
			hideDuration            :true,
			hideThumbnailShadow     :true,


			showFixedPlayIcon       :utbap_video_icon,
			iconShape               :utbap_video_icon_style,       
			showHoverAnimation      :false,

			playlistNavigation      :true,


	});	
});


</script>
<?php if($utbap_header_templates == 'default'){ ?>
<style type="text/css">
.yl-channel-search i.fa.fa-search {
    top: 5px;
    right: 10px;
}
.yl-channel-search {
    display: inline-block;
    float: right;
    margin-top: 1.5em;
    background-color: #fff;
    color: #000;
    /* padding: .3em .5em; */
    position: relative;
    /* padding: 0; */
    /* height: 30px; */
}
</style>
<?php } ?>


<?php
return ob_get_clean();
}