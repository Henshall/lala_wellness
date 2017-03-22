<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

wp_nonce_field( 'utbap_ui_meta_box_nonce', 'utbap_meta_box_nonce' );

global $post;
$utbap_youtube_channel_link = get_post_meta($post->ID, '_utbap_youtube_channel_link', true);
$utbap_videos_to_show = get_post_meta($post->ID, '_utbap_videos_to_show', true);
$utbap_channel_style = get_post_meta($post->ID, '_utbap_channel_style', true);
$utbap_video_display_mode = get_post_meta($post->ID, '_utbap_video_display_mode', true);
$utbap_hide_header = get_post_meta($post->ID, '_utbap_hide_header', true);
$utbap_load_more = get_post_meta($post->ID, '_utbap_load_more', true);
$utbap_hide_tabs = get_post_meta($post->ID, '_utbap_hide_tabs', true);
$utbap_subscribe_button = get_post_meta($post->ID, '_utbap_subscribe_button', true);
$utbap_subscriber_count = get_post_meta($post->ID, '_utbap_subscriber_count', true);
$utbap_auto_play = get_post_meta($post->ID, '_utbap_auto_play', true);
$utbap_sorting_order = get_post_meta($post->ID, '_utbap_sorting_order', true);
$utbap_video_thumbnail_view = get_post_meta($post->ID, '_utbap_video_thumbnail_view', true);
$utbap_loading_mechanism = get_post_meta($post->ID, '_utbap_loading_mechanism', true);
$utbap_hide_search = get_post_meta($post->ID, '_utbap_hide_search', true);
$utbap_hide_sorting = get_post_meta($post->ID, '_utbap_hide_sorting', true);
$utbap_hide_switcher = get_post_meta($post->ID, '_utbap_hide_switcher', true);
$utbap_hide_popup_details = get_post_meta($post->ID, '_utbap_hide_popup_details', true);
$utbap_cta_button = get_post_meta($post->ID, '_utbap_cta_button', true);
$utbap_default_tab = get_post_meta($post->ID, '_utbap_default_tab', true);
$utbap_cta_button_text = get_post_meta($post->ID, '_utbap_cta_button_text', true);
$utbap_cta_url = get_post_meta($post->ID, '_utbap_cta_url', true);
$utbap_date_format = get_post_meta($post->ID, '_utbap_date_format', true);
$utbap_hide_duration = get_post_meta($post->ID, '_utbap_hide_duration', true);
$utbap_video_icon = get_post_meta($post->ID, '_utbap_video_icon', true);
$utbap_video_icon_style = get_post_meta($post->ID, '_utbap_video_icon_style', true);
$utbap_header_templates = get_post_meta($post->ID, '_utbap_header_templates', true);
$utbap_template1_bg = get_post_meta($post->ID, '_utbap_template1_bg', true);
$utbap_template2_bg = get_post_meta($post->ID, '_utbap_template2_bg', true);


$utbap_background_color = get_post_meta($post->ID, '_utbap_background_color', true);
$utbap_thumbnail_background_color = get_post_meta($post->ID, '_utbap_thumbnail_background_color', true);
$utbap_header_background_color = get_post_meta($post->ID, '_utbap_header_background_color', true);
$utbap_header_text_color = get_post_meta($post->ID, '_utbap_header_text_color', true);
$utbap_thumbnail_title_color = get_post_meta($post->ID, '_utbap_thumbnail_title_color', true);
$utbap_thumbnail_description_color = get_post_meta($post->ID, '_utbap_thumbnail_description_color', true);
$utbap_view_date_color = get_post_meta($post->ID, '_utbap_view_date_color', true);
$utbap_tabs_color = get_post_meta($post->ID, '_utbap_tabs_color', true);
$utbap_loading_button_color = get_post_meta($post->ID, '_utbap_loading_button_color', true);
$utbap_base_font_size = get_post_meta($post->ID, '_utbap_base_font_size', true);
$utbap_title_font_family = get_post_meta($post->ID, '_utbap_title_font_family', true);
$utbap_title_boldness = get_post_meta($post->ID, '_utbap_title_boldness', true);
$utbap_general_font_family = get_post_meta($post->ID, '_utbap_general_font_family', true);

?>

<script type="text/javascript">
  jQuery(document).ready( function($) {

    var selected_feed_style = $('input[name=utbap_channel_style]:checked', '#utbap_style_selection_option').val();
    if(selected_feed_style == 'double-list'){
      $('#utbap_thumbnails_image').css('border','3px inset RED');
      $('#utbap_masonry_image').css('border','none');
      $('#utbap_blog_image').css('border','none');
    }
    if(selected_feed_style == 'grid' ){
      $('#utbap_blog_image').css('border','3px inset RED');
      $('#utbap_thumbnails_image').css('border','none');
      $('#utbap_masonry_image').css('border','none');

    }
    if(selected_feed_style == 'masonry'){
      $('#utbap_masonry_image').css('border','3px inset RED');
      $('#utbap_blog_image').css('border','none');
      $('#utbap_thumbnails_image').css('border','none');


    }
    if(selected_feed_style == 'list' ){
      $('#utbap_vertical_image').css('border','3px inset RED');
      $('#utbap_blog_image').css('border','none');
      $('#utbap_thumbnails_image').css('border','none');
      $('#utbap_masonry_image').css('border','none');

    }
    $('#utbap_style_selection_option input').on('change', function() {
      var feed_style_selection = $('input[name=utbap_channel_style]:checked', '#utbap_style_selection_option').val(); 
      if(feed_style_selection == 'double-list'){
        $('#utbap_thumbnails_image').css('border','3px inset RED');
        $('#utbap_vertical_image').css('border','none');
        $('#utbap_masonry_image').css('border','none');
        $('#utbap_blog_image').css('border','none');
      }
      if(feed_style_selection == 'grid' ){
        $('#utbap_blog_image').css('border','3px inset RED');
        $('#utbap_vertical_image').css('border','none');
        $('#utbap_thumbnails_image').css('border','none');
        $('#utbap_masonry_image').css('border','none');
      }
      if(feed_style_selection == 'list' ){
        $('#utbap_vertical_image').css('border','3px inset RED');
        $('#utbap_blog_image').css('border','none');
        $('#utbap_thumbnails_image').css('border','none');
        $('#utbap_masonry_image').css('border','none');
      }
      if(feed_style_selection == 'masonry'){
        $('#utbap_vertical_image').css('border','none');
        $('#utbap_masonry_image').css('border','3px inset RED');
        $('#utbap_blog_image').css('border','none');
        $('#utbap_thumbnails_image').css('border','none');
      }
    });   


    var selected_feed_style = $('input[name=utbap_video_display_mode]:checked', '#utbap_style_selection_mode').val();
    if(selected_feed_style == 'inline'){
      $('#display_mode_inline').css('border','3px solid red');
      $('#display_mode_link').css('border','none');
      $('#display_mode_lightbox').css('border','none');
    }
    if(selected_feed_style == 'link' ){
      $('#display_mode_inline').css('border','none');
      $('#display_mode_link').css('border','3px solid red');
      $('#display_mode_lightbox').css('border','none');

    }
    if(selected_feed_style == 'popup'){
      $('#display_mode_inline').css('border','none');
      $('#display_mode_link').css('border','none');
      $('#display_mode_lightbox').css('border','3px solid red');

    }

    $('#utbap_style_selection_mode input').on('change', function() {
      var feed_style_selection = $('input[name=utbap_video_display_mode]:checked', '#utbap_style_selection_mode').val(); 
      if(feed_style_selection == 'inline'){
        $('#display_mode_inline').css('border','3px solid red');
        $('#display_mode_link').css('border','none');
        $('#display_mode_lightbox').css('border','none');
      }
      if(feed_style_selection == 'link' ){
        $('#display_mode_inline').css('border','none');
        $('#display_mode_link').css('border','3px solid red');
        $('#display_mode_lightbox').css('border','none');

      }
      if(feed_style_selection == 'popup'){
        $('#display_mode_inline').css('border','none');
        $('#display_mode_link').css('border','none');
        $('#display_mode_lightbox').css('border','3px solid red');

      }

    });




    var selected_feed_style = $('input[name=utbap_video_thumbnail_view]:checked', '#utbap_description_view').val();
    if(selected_feed_style == 'neat'){
      $('#utbap_video_thumbnail_view_compact_img').css('border','3px solid red');
      $('#utbap_video_thumbnail_view_minimum_img').css('border','none');
      $('#utbap_video_thumbnail_view_full_img').css('border','none');
    }
    if(selected_feed_style == 'simple' ){
      $('#utbap_video_thumbnail_view_compact_img').css('border','none');
      $('#utbap_video_thumbnail_view_minimum_img').css('border','3px solid red');
      $('#utbap_video_thumbnail_view_full_img').css('border','none');

    }
    if(selected_feed_style == 'full'){
      $('#utbap_video_thumbnail_view_compact_img').css('border','none');
      $('#utbap_video_thumbnail_view_minimum_img').css('border','none');
      $('#utbap_video_thumbnail_view_full_img').css('border','3px solid red');

    }

    $('#utbap_description_view input').on('change', function() {
      var feed_style_selection = $('input[name=utbap_video_thumbnail_view]:checked', '#utbap_description_view').val(); 
      if(feed_style_selection == 'neat'){
        $('#utbap_video_thumbnail_view_compact_img').css('border','3px solid red');
        $('#utbap_video_thumbnail_view_minimum_img').css('border','none');
        $('#utbap_video_thumbnail_view_full_img').css('border','none');
      }
      if(feed_style_selection == 'simple' ){
        $('#utbap_video_thumbnail_view_compact_img').css('border','none');
        $('#utbap_video_thumbnail_view_minimum_img').css('border','3px solid red');
        $('#utbap_video_thumbnail_view_full_img').css('border','none');

      }
      if(feed_style_selection == 'full'){
        $('#utbap_video_thumbnail_view_compact_img').css('border','none');
        $('#utbap_video_thumbnail_view_minimum_img').css('border','none');
        $('#utbap_video_thumbnail_view_full_img').css('border','3px solid red');

      }

    });




        var selected_feed_style = $('input[name=utbap_header_templates]:checked', '#utbap_header_templates_table').val();
    if(selected_feed_style == 'default'){
      $('#utbap_default_td').css('border','3px solid red');
      $('#utbap_template1_td').css('border','none');
      $('#utbap_template2_td').css('border','none');
    }
    if(selected_feed_style == 'template1' ){
      $('#utbap_default_td').css('border','none');
      $('#utbap_template1_td').css('border','3px solid red');
      $('#utbap_template2_td').css('border','none');

    }
    if(selected_feed_style == 'template2'){
      $('#utbap_default_td').css('border','none');
      $('#utbap_template1_td').css('border','none');
      $('#utbap_template2_td').css('border','3px solid red');

    }

    $('#utbap_header_templates_table input').on('change', function() {
      var feed_style_selection = $('input[name=utbap_header_templates]:checked', '#utbap_header_templates_table').val(); 
      if(feed_style_selection == 'default'){
        $('#utbap_default_td').css('border','3px solid red');
        $('#utbap_template1_td').css('border','none');
        $('#utbap_template2_td').css('border','none');
      }
      if(feed_style_selection == 'template1' ){
        $('#utbap_default_td').css('border','none');
        $('#utbap_template1_td').css('border','3px solid red');
        $('#utbap_template2_td').css('border','none');

      }
      if(feed_style_selection == 'template2'){
        $('#utbap_default_td').css('border','none');
        $('#utbap_template1_td').css('border','none');
        $('#utbap_template2_td').css('border','3px solid red');

      }

    });

    $('.utbap_image_uploader1').click(function(e) {
      e.preventDefault();
      var image = wp.media({ 
        title: 'Upload Image',
        multiple: false
      }).open()
      .on('select', function(e){
        var uploaded_image = image.state().get('selection').first();
          var image_url = uploaded_image.toJSON().url;
        
        $("#utbap_template1_bg").val(image_url);

      });

  });
          $('.utbap_image_uploader2').click(function(e) {
        e.preventDefault();
        var image = wp.media({ 
          title: 'Upload Image',
          multiple: false
        }).open()
        .on('select', function(e){
          var uploaded_image = image.state().get('selection').first();
          var image_url = uploaded_image.toJSON().url;

          $("#utbap_template2_bg").val(image_url);

        });
  });
  });
</script>
<style type="text/css">

  main {
    background: #FFF;
    width: 98%;
    padding: 1%;
    margin-top: 1%;
    box-shadow: 0 3px 5px rgba(0,0,0,0.2);
    border-top: 4px solid #e62117;
  }
  main p {
    font-size: 13px;
  }
  main #utbap-tab1, main #utbap-tab2, main #utbap-tab3, main #utbap-tab4, main section {
    clear: both;
    padding-top: 30px;
    display: none;
  }
  #utbap-tab1-label, #utbap-tab2-label,  #utbap-tab3-label,  #utbap-tab4-label {
    font-weight: bold;
    font-size: 14px;
    display: block;
    float: left;
    padding: 10px 30px;
    border-top: 2px solid transparent;
    border-right: 1px solid transparent;
    border-left: 1px solid transparent;
    border-bottom: 1px solid #DDD;
  }
  main label:hover {
    cursor: pointer;
    text-decoration: underline;
  }
  #utbap-tab1:checked ~ #utbap-content1, #utbap-tab2:checked ~ #utbap-content2, #utbap-tab3:checked ~ #utbap-content3, #utbap-tab4:checked ~ #utbap-content4 {
    display: block;
  }
  main input:checked + #utbap-tab1-label, main input:checked + #utbap-tab2-label, main input:checked +  #utbap-tab3-label, main input:checked +  #utbap-tab4-label {
    border-top-color: #2fc4ff;
    border-right-color: #DDD;
    border-left-color: #DDD;
    border-bottom-color: transparent;
    text-decoration: none;
  }
  #utbap_show_photos_from_id , #utbap_show_photos_from_location , #utbap_show_photos_from_hashtag{
    margin-top: 2px;
  }
  .utbap_checkbox{
    width: 25px !important;
    height: 25px !important;
    border: 1px solid lightgrey !important;
    border-radius: 5px !important;
    margin-left: 10px !important;
  }
  .utbap_checkbox:checked:before{
    font-size: 30px !important;
  }
  #utbap_theme_selection_table tr td{
    vertical-align: top;
    display: inline-block;
  }

  #MainContainer {
    position: relative;
    width: 100px;
    margin: 0;
    text-align: left;
    margin-top: -2px;
  }

  .Switch {
    position: relative;
    display: inline-block;
    font-size: 1.6em;
    font-weight: bold;
    color: #ccc;
    text-shadow: 0px 1px 1px rgba(255,255,255,0.8);
    height: 18px;
    padding: 6px 6px 5px 7px;
    border: 1px solid #ccc;
    border: 1px solid rgba(0,0,0,0.2);
    border-radius: 4px;
    background: #ececec;
    box-shadow: 0px 0px 4px rgba(0,0,0,0.1), inset 0px 1px 3px 0px rgba(0,0,0,0.1);
    cursor: pointer;
    font-size: 16px;
  }
  body.IE7 .Switch { width: 78px; }
  .Switch span {
    display: inline-block;
    width: 35px;
  }
  .Switch span.On { color: #e62117; }
  .Switch .Toggle {
    position: absolute;
    top: 1px;
    width: 37px;
    height: 25px;
    border: 1px solid #ccc;
    border: 1px solid rgba(0,0,0,0.3);
    border-radius: 4px;
    background: #fff;
    background: -moz-linear-gradient(top, #ececec 0%, #ffffff 100%);
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #ececec), color-stop(100%, #ffffff));
    background: -webkit-linear-gradient(top, #ececec 0%, #ffffff 100%);
    background: -o-linear-gradient(top, #ececec 0%, #ffffff 100%);
    background: -ms-linear-gradient(top, #ececec 0%, #ffffff 100%);
    background: linear-gradient(top, #ececec 0%, #ffffff 100%);
    box-shadow: inset 0px 1px 0px 0px rgba(255,255,255,0.5);
    z-index: 999;
    -webkit-transition: all 0.15s ease-in-out;
    -moz-transition: all 0.15s ease-in-out;
    -o-transition: all 0.15s ease-in-out;
    -ms-transition: all 0.15s ease-in-out;
  }
  .Switch.On .Toggle { left: 2%; }
  .Switch.Off .Toggle { left: 54%; }
  /* Round Switch */
  .Switch.Round {
    padding: 0px 20px;
    border-radius: 40px;
  }
  body.IE7 .Switch.Round { width: 1px; }
  .Switch.Round .Toggle {
    border-radius: 40px;
    width: 14px;
    height: 14px;
  }
  .Switch.Round.Off .Toggle {
    left: 3%;
    background: #33d2da;
  }
  .Switch.Round.On .Toggle { left: 58%; }
  .info {
    font-size: 1.2em;
    margin-bottom: 4px;
  }

  #utbap_general_options{
  }

  #utbap_sorting_order, #utbap_loading_mechanism, #utbap_default_tab{
    border-top-left-radius: 3px;
    color: #6b6b6b;
    border-top-right-radius: 3px;
    outline: none;
    height: 32px;
    font-size: 15px;
  }
</style>
<p style="text-align: center;
background: white;
border: 2px solid #e62117;
padding: 5px;
font-size: 17px;">Copy this shortcode & paste into your post, page or widget to show YouTube Channel Videos<br/> <strong>[arrow_youtube id='<?php echo $post->ID; ?>']</strong></p>
<main>
  <input id="utbap-tab1" type="radio" name="utbap-tabs" checked>
  <label id="utbap-tab1-label" for="utbap-tab1">General Settings</label>
  <input id="utbap-tab2" type="radio" name="utbap-tabs">
  <label id="utbap-tab2-label" for="utbap-tab2">More Settings</label>
  <input id="utbap-tab3" type="radio" name="utbap-tabs">
  <label id="utbap-tab3-label" for="utbap-tab3">Call-to-Action Button</label>
  <input id="utbap-tab4" type="radio" name="utbap-tabs">
  <label id="utbap-tab4-label" for="utbap-tab4">Style Editor</label>
  <section id="utbap-content1">
    <table id="utbap_general_options" style="">
      <tr>
        <td>
          <h3>Enter YouTube Channel Link: </h3> 
        </td>
        <td>
          <input style="width: 450px;height: 35px;" type="text" id="utbap_youtube_channel_link" name="utbap_youtube_channel_link"  value="<?php echo $utbap_youtube_channel_link; ?>" /> 
        </td>
      </tr>
    </table>
    <table>
      <tr>
        <td>
          <h3>Number of Videos to show: </h3> 
        </td>
        <td >
          <input style="height: 35px;" 
          type="number"
          min="1"
          max="100" 
          id="utbap_videos_to_show" 
          name="utbap_videos_to_show" 
          value="<?php if($utbap_videos_to_show == ''){ echo '9'; }else{ echo $utbap_videos_to_show; } ?>" 
          /> 
        </td>
      </tr>
      <tr>
        <td style="vertical-align: top;">
          <h3 style="margin: ;">AutoPlay Videos: </h3>
        </td>
        <td>
          <div id="MainContainer">
            <div>
              <div class="info">
                <input type="checkbox" name="utbap_auto_play" id="utbap_auto_play"  value='1'<?php checked(1, $utbap_auto_play); ?>  style="display: none;">
              </div>
              <div class="Switch disabled">
                <div class="Toggle"></div>
                <span class="On">ON</span> <span class="Off">OFF</span> </div>
              </div>
            </div>
          </td>
        </tr>
        <tr>
          <td style="vertical-align: top;">
            <h3 style="margin: ;">Videos Sorting Order: </h3>
          </td>
          <td>
            <select name="utbap_sorting_order" id="utbap_sorting_order" value='1'<?php checked(1, $utbap_sorting_order); ?> > 
              <option value="recent-first" <?php if ( $utbap_sorting_order == "recent-first" ) echo 'selected="selected"'; ?>>Recent Videos First</option>
              <option disabled >Popular Videos First (Premium Feature)</option>
            </select>
          </td>
        </tr>
       
      </table>
      <input style="margin: 0 auto;display: block;" name="save" type="submit" class="button button-primary button-large" id="publish" value="Save Changes">

      <br/>
      <hr/>
      <br/>
      <h3 style="margin-left: 3px;">Channel Display Modes:</h3>
      <table id="utbap_style_selection_option">
        <tr>
           <td style="vertical-align: top;">
            <p style="text-align: center;margin: 0;">
              <input id="utbap_feed_style_vertical" type="radio" name="utbap_channel_style" 
              value="list" <?php echo ($utbap_channel_style == 'list')? 'checked="checked"':''; ?> <?php if($utbap_channel_style == ''){ echo 'checked="checked"';} ?> /> 
              <label for="utbap_feed_style_vertical"><strong>List</strong></label>
            </p>
            <p style="text-align: center;margin: 5px;">
              <label for="utbap_feed_style_vertical">
                <img style="border-radius: 5px;" id="utbap_vertical_image" src="<?php echo plugins_url('images/list.png',__FILE__); ?>" />
              </label>
            </p>
          </td>

         <td style="vertical-align: top;">
            <p style="text-align: center;margin: 0;">
              <input disabled id="utbap_feed_style_thumbnails" type="radio" name="" /> 
              <label for="utbap_feed_style_thumbnails"><strong>Double-List  <a target="_blank" href="https://www.arrowplugins.com/youtube-feed"> Locked</a></strong></label>
            </p>
            <p style="text-align: center;margin: 5px;">
              <label for="utbap_feed_style_thumbnails">
                <img style="border-radius: 5px;" id="utbap_thumbnails_image" src="<?php echo plugins_url('images/double-list.png',__FILE__); ?>" />
              </label>
            </p>
          </td>
       
         
          <td style="vertical-align: top;">
            <p style="text-align: center;margin: 0;">
              <input disabled id="utbap_feed_style_blog_style" type="radio" name="" /> 
              <label for="utbap_feed_style_blog_style"><strong>Grid <a target="_blank" href="https://www.arrowplugins.com/youtube-feed"> Locked</a></strong></strong></label>
            </p>
            <p style="text-align: center;margin: 5px;">
              <label for="utbap_feed_style_blog_style">
                <img style="border-radius: 5px;" id="utbap_blog_image" class="utbap_style_image" src="<?php echo plugins_url('images/grid.png',__FILE__); ?>" />
              </label>
            </p>
          </td>
        </tr>

      </table>
      <input style="margin: 0 auto;display: block;" name="save" type="submit" class="button button-primary button-large" id="publish" value="Save Changes">

      <br/>
      <hr/>
      <br/>
      <h3 style="margin-left: 3px;">Video Display Mode: (How video will show up):</h3>
      <table id="utbap_style_selection_mode">
        <tr>
        <td>
            <p style="text-align: center;margin: 0;">
              <input id="utbap_video_display_mode_link" type="radio" name="utbap_video_display_mode" value="link" <?php echo ($utbap_video_display_mode == 'link')? 'checked="checked"':''; ?> <?php if($utbap_video_display_mode == ''){ echo 'checked="checked"';} ?>/> 
              <label for="utbap_video_display_mode_link"><strong>Link to YouTube</strong></label>
            </p>
            <p style="text-align: center;margin: 5px;">
              <label for="utbap_video_display_mode_link">
                <img style="border-radius: 5px;" id="display_mode_link" width="200px"  src="<?php echo plugins_url('images/link.png',__FILE__); ?>" />
              </label>
            </p>
          </td>
          <td>
            <p style="text-align: center;margin: 0;">
              <input disabled id="utbap_video_display_mode_inline" type="radio" name="" 
              value="inline" <?php echo ($utbap_video_display_mode == 'inline')? 'checked="checked"':''; ?>  /> 
              <label for="utbap_video_display_mode_inline"><strong>Inline Play  <a target="_blank" href="https://www.arrowplugins.com/youtube-feed"> Locked</a></strong></label>
            </p>
            <p style="text-align: center;margin: 5px;">
              <label for="utbap_video_display_mode_inline">
                <img style="border-radius: 5px;" id="display_mode_inline" width="200px"  src="<?php echo plugins_url('images/inline.png',__FILE__); ?>" />
              </label>
            </p>
          </td>
          <td>
            <p style="text-align: center;margin: 0;">
              <input disabled id="utbap_video_display_mode_lightbox" type="radio" name=""  /> 
              <label for="utbap_video_display_mode_lightbox"><strong>In Lightbox <a target="_blank" href="https://www.arrowplugins.com/youtube-feed"> Locked</a></strong></label>
            </p>
            <p style="text-align: center;margin: 5px;">
              <label for="utbap_video_display_mode_lightbox">
                <img style="border-radius: 5px;" id="display_mode_lightbox" width="200px"  class="utbap_style_image" src="<?php echo plugins_url('images/popup.png',__FILE__); ?>" />
              </label>
            </p>
          </td>
        </tr>
      </table>
      <input style="margin: 0 auto;display: block;" name="save" type="submit" class="button button-primary button-large" id="publish" value="Save Changes">

      <br/>
      <hr/>
      <br/>

      <h3 style="margin-left: 3px;">Thumbnail View Styles:</h3>
      <table id="utbap_description_view">
        <tr>

        
          <td style="vertical-align: top;">
            <p style="text-align: center;margin: 0;">
              <input id="utbap_video_thumbnail_view_minimum" type="radio" name="utbap_video_thumbnail_view" value="simple" <?php echo ($utbap_video_thumbnail_view == 'simple')? 'checked="checked"':''; ?> <?php if($utbap_video_thumbnail_view == ''){ echo 'checked="checked"';} ?>/> 
              <label for="utbap_video_thumbnail_view_minimum"><strong>Minimum</strong></label>
            </p>
            <p style="text-align: center;margin: 5px;">
              <label for="utbap_video_thumbnail_view_minimum">
                <img style="border-radius: 5px;" id="utbap_video_thumbnail_view_minimum_img" width="200px"  class="utbap_style_image" src="<?php echo plugins_url('images/Minimum.png',__FILE__); ?>" />
              </label>
            </p>
          </td>

            <td style="vertical-align: top;">
            <p style="text-align: center;margin: 0;">
              <input disabled id="utbap_video_thumbnail_view_compact" type="radio" name="" /> 
              <label for="utbap_video_thumbnail_view_compact"><strong>Compact <a target="_blank" href="https://www.arrowplugins.com/youtube-feed">Locked </a></strong></label>
            </p>
            <p style="text-align: center;margin: 5px;">
              <label for="utbap_video_thumbnail_view_compact">
                <img style="border-radius: 5px;" id="utbap_video_thumbnail_view_compact_img" width="200px"  src="<?php echo plugins_url('images/Compact.png',__FILE__); ?>" />
              </label>
            </p>
          </td>

          <td style="vertical-align: top;">
            <p style="text-align: center;margin: 0;">
              <input disabled id="utbap_video_thumbnail_view_full" type="radio" name=""   /> 
              <label for="utbap_video_thumbnail_view_full"><strong>Full Description <a target="_blank" href="https://www.arrowplugins.com/youtube-feed">Locked </a></strong></label>
            </p>
            <p style="text-align: center;margin: 5px;">
              <label for="utbap_video_thumbnail_view_full">
                <img style="border-radius: 5px;" id="utbap_video_thumbnail_view_full_img" width="200px" src="<?php echo plugins_url('images/Full.png',__FILE__); ?>" />
              </label>
            </p>
          </td>
        </tr>

      </table>
      <input style="margin: 0 auto;display: block;" name="save" type="submit" class="button button-primary button-large" id="publish" value="Save Changes">

      <br/>
      <hr/>
      <br/>

      <h2 style="    font-size: 18px; margin: 0;padding: 3px;">Select Header Template:</h2>
      <br/>

      <table id="utbap_header_templates_table" style="width: 100%"">
        <tr>

          <td id="utbap_default_td" style="vertical-align: top;border: 2px solid #cacaca;
    border-radius: 5px;
    padding-left: 10px;margin-bottom: 10px;">
            <p style="text-align: center;margin: 0;text-align: left;    font-size: 20px;">
              <input id="utbap_default" type="radio" name="utbap_header_templates" value="default" <?php echo ($utbap_header_templates == 'default')? 'checked="checked"':''; ?> <?php if($utbap_header_templates == ''){ echo 'checked="checked"';} ?>/> 
              <label for="utbap_default"><strong>Default (No header background image supported, only background color supported)</strong></label>
            </p>
            <p style="text-align: center;margin: 5px;">
              <label for="utbap_default">
                <img style="width: 100%" style="border-radius: 5px;" id="utbap_video_thumbnail_view_compact_img" width="200px"  src="<?php echo plugins_url('images/default.png',__FILE__); ?>" />
              </label>
            </p>
          </td>
        <tr>

          <td id="utbap_template1_td" style="vertical-align: top;border: 2px solid #cacaca;
    border-radius: 5px;
    padding-left: 10px;
    margin-bottom: 10px;">
            <p style="text-align: center;margin: 0;text-align: left;    font-size: 20px;">
              <input disabled id="utbap_template1" type="radio" name="" /> 
              <label for="utbap_template1"><strong>Template 1 ( with custom header background )</strong></label><a target="_blank"  href="https://www.arrowplugins.com/youtube-feed">Included in Premium</a>
            </p>
            <p style="text-align: center;margin: 5px;">
              <label for="utbap_template1">
                <img style="width: 100%" style="border-radius: 5px;" id="utbap_video_thumbnail_view_minimum_img" width="200px"  class="utbap_style_image" src="<?php echo plugins_url('images/template1.png',__FILE__); ?>" />
              </label>
            </p>
            <div id="utbap_template1_bg_image" style="margin-bottom: 20px;">
            <h2>Upload your Channel Header's Background</h2>
              <input id="utbap_template1_bg_button" type="button" name="utbap_template1_bg_button" class="utbap_image_uploader1 button-primary" value="Upload Background">
              <input disabled style="width: 60%;" id="utbap_template1_bg" type="text" name="" class="" >
            </div>
          </td>
          </tr>
        <tr>

          <td id="utbap_template2_td" style="vertical-align: top;border: 2px solid #cacaca;
    border-radius: 5px;
    padding-left: 10px;margin-bottom: 10px;">
            <p style="text-align: center;margin: 0;text-align: left;    font-size: 20px;">
              <input disabled id="utbap_template2" type="radio" name=""   /> 
              <label for="utbap_template2"><strong>Template 2 ( with custom header background )</strong></label><a target="_blank" href="https://www.arrowplugins.com/youtube-feed">Included in Premium</a>
            </p>
            <p style="text-align: center;margin: 5px;">
              <label for="utbap_template2">
                <img style="width: 100%" style="border-radius: 5px;" id="utbap_video_thumbnail_view_full_img" width="200px" src="<?php echo plugins_url('images/template2.png',__FILE__); ?>" />
              </label>
            </p>
            <div id="utbap_template2_bg_image" style="margin-bottom: 20px;">
            <h2>Upload your Channel Header's Background</h2>
              <input id="utbap_template2_bg_button" type="button" name="utbap_template2_bg_button" class="utbap_image_uploader2 button-primary" value="Upload Background">
              <input disabled style="width: 60%;" id="utbap_template2_bg" type="text" name="utbap_template2_bg" class="" value="<?php if($utbap_template2_bg == ''){echo plugins_url().'/images/theme2.png';}else{echo $utbap_template2_bg;} ?>">
            </div>
          </td>
        </tr>

      </table>
      <input style="margin: 0 auto;display: block;" name="save" type="submit" class="button button-primary button-large" id="publish" value="Save Changes">
    </section>
    <section id="utbap-content2">
      <table>
 <tr>
          <td style="vertical-align: top;">
            <h3 style="margin: ;">Loading Mechanism: </h3>
          </td>
          <td>
            <select name="utbap_loading_mechanism" id="utbap_loading_mechanism" value='1'<?php checked(1, $utbap_loading_mechanism); ?> > 
              <option value="load-more" <?php if ( $utbap_loading_mechanism == "load-more" ) echo 'selected="selected"'; ?>>Load More Button</option>
              <option disabled value="prev-next" >Pagination - Previous, Next Buttons (Premium Feature)</option>
            </select>
          </td>
        </tr>
         <tr>
          <td style="vertical-align: top;">
            <h3 style="margin: ;">Default Tab: </h3>
          </td>
          <td>
            <select name="utbap_default_tab" id="utbap_default_tab" value='1'<?php checked(1, $utbap_default_tab); ?> > 
              <option value="Uploads" <?php if ( $utbap_default_tab == "Uploads" ) echo 'selected="selected"'; ?>>Uploads</option>
              <option disabled value="Playlists" >Playlists (Premium Feature)</option>
            </select>
          </td>
        </tr>
        <tr>
          <td style="vertical-align: top;">
            <h3 style="margin: ;">Date Format: </h3>
          </td>
          <td>
            <select name="utbap_date_format" id="utbap_default_tab" value='1'<?php checked(1, $utbap_date_format); ?> > 
              <option value="specific" <?php if ( $utbap_date_format == "specific" ) echo 'selected="selected"'; ?>>Specific (Ex: 24 May 2016 )</option>
              <option disabled value="relative" >Relative (Ex: 4 days ago ) (Premium Feature)</option>
            </select>
          </td>
        </tr>
       
      
        
            <tr>
              <td style="vertical-align: top;">
                <h3 style="margin: ;">Hide Tabs: </h3>
              </td>
              <td>
                <div id="MainContainer">
                  <div>
                    <div class="info">
                      <input type="checkbox" name="utbap_hide_tabs" id="utbap_hide_tabs"  value='1'<?php checked(1, $utbap_hide_tabs); ?>  style="display: none;">
                    </div>
                    <div class="Switch">
                      <div class="Toggle"></div>
                      <span class="On">ON</span> <span class="Off">OFF</span> </div>
                    </div>
                  </div>
                </td>
              </tr>
           
                <tr>
                  <td style="vertical-align: top;">
                    <h3 style="margin: ;">Hide Sorting Tab Field: </h3>
                  </td>
                  <td>
                    <div id="MainContainer">
                      <div>
                        <div class="info">
                          <input type="checkbox" name="utbap_hide_sorting" id="utbap_hide_sorting"  value='1'<?php checked(1, $utbap_hide_sorting); ?>  style="display: none;">
                        </div>
                        <div class="Switch">
                          <div class="Toggle"></div>
                          <span class="On">ON</span> <span class="Off">OFF</span> </div>
                        </div>
                      </div>
                    </td>
                  </tr>
</table>
<br/>
<br/>
<hr/>
<h1><a target="_blank" href="https://www.arrowplugins.com/youtube-feed">Premium Features</a></h1>
<table>
                  <tr>
                    <td style="vertical-align: top;">
                      <h3 style="margin: ;">Show View Switcher: </h3>
                    </td>
                    <td>
                      <div id="MainContainer">
                        <div>
                          <div class="info">
                            <input type="checkbox" name="" id="utbap_hide_switcher"   style="display: none;">
                          </div>
                          <div class="Switch disabled">
                            <div class="Toggle"></div>
                            <span class="On">ON</span> <span class="Off">OFF</span> </div>
                          </div>
                        </div>
                      </td>
                    </tr>
   <tr>
                <td style="vertical-align: top;">
                  <h3 style="margin: ;">Hide Search Field: </h3>
                </td>
                <td>
                  <div id="MainContainer">
                    <div>
                      <div class="info">
                        <input type="checkbox" name="utbap_hide_search" id="utbap_hide_search"    style="display: none;">
                      </div>
                      <div class="Switch disabled">
                        <div class="Toggle"></div>
                        <span class="On">ON</span> <span class="Off">OFF</span> </div>
                      </div>
                    </div>
                  </td>
                </tr>
                  <tr>
          <td style="vertical-align: top;">
            <h3 style="margin: ;">Hide Top Header: </h3>
          </td>
          <td>
            <div id="MainContainer">
              <div>
                <div class="info">
                  <input type="checkbox" name="utbap_hide_header" id="utbap_hide_header"  value='1'<?php checked(1, $utbap_hide_header); ?>  style="display: none;">
                </div>
                <div class="Switch disabled">
                  <div class="Toggle"></div>
                  <span class="On">ON</span> <span class="Off">OFF</span> </div>
                </div>
              </div>
            </td>
          </tr>
                  <tr>
            <td style="vertical-align: top;">
              <h3 style="margin: ;">Hide Load More Button: </h3>
            </td>
            <td>
              <div id="MainContainer">
                <div>
                  <div class="info">
                    <input type="checkbox" name="utbap_load_more" id="utbap_load_more"  value='1'<?php checked(1, $utbap_load_more); ?>  style="display: none;">
                  </div>
                  <div class="Switch disabled">
                    <div class="Toggle"></div>
                    <span class="On">ON</span> <span class="Off">OFF</span> </div>
                  </div>
                </div>
              </td>
            </tr>
                 <tr>
          <td style="vertical-align: top;">
            <h3 style="margin: ;">Show Play Icon on Video Thumbnail: </h3>
          </td>
          <td>
            <div id="MainContainer">
            <div>
              <div class="info">
                <input type="checkbox" name="utbap_video_icon" id="utbap_video_icon"  value='1'<?php checked(1, $utbap_video_icon); ?>  style="display: none;">
              </div>
              <div class="Switch disabled">
                <div class="Toggle"></div>
                <span class="On">ON</span> <span class="Off">OFF</span> </div>
              </div>
            </div>
          </td>
        </tr>
         <tr>
          <td style="vertical-align: top;">
            <h3 style="margin: ;">Play Icon Style: </h3>
          </td>
          <td>
            <select name="utbap_video_icon_style" id="utbap_default_tab" value='1'<?php checked(1, $utbap_video_icon_style); ?> > 
              <option value="circle" <?php if ( $utbap_video_icon_style == "circle" ) echo 'selected="selected"'; ?>>Circle (Premium Feature)</option>
              <option disabled value="square" >Square (Premium Feature)</option>
            </select>
          </td>
        </tr>
                         <tr>
                    <td style="vertical-align: top;">
                      <h3 style="margin: ;">Show Video Details, Ability to Like & Comment on Videos </h3>
                    </td>
                    <td>
                      <div id="MainContainer">
                        <div>
                          <div class="info">
                            <input type="checkbox" name="" id="utbap_hide_popup_details"    style="display: none;">
                          </div>
                          <div class="Switch disabled">
                            <div class="Toggle"></div>
                            <span class="On">ON</span> <span class="Off">OFF</span> </div>
                          </div>
                        </div>
                      </td>
                    </tr>

                    <tr>
                      <td style="vertical-align: top;">
                        <h3 style="margin: ;">Show Time Duration: </h3>
                      </td>
                      <td>
                        <div id="MainContainer">
                          <div>
                            <div class="info">
                              <input type="checkbox" name="" id="utbap_hide_duration"    style="display: none;">
                            </div>
                            <div class="Switch disabled">
                              <div class="Toggle"></div>
                              <span class="On">ON</span> <span class="Off">OFF</span> </div>
                            </div>
                          </div>
                        </td>
                      </tr>
                       <tr>
                      <td style="vertical-align: top;">
                        <h3 style="margin: ;">Show Thumbnail Hover Animation: </h3>
                      </td>
                      <td>
                        <div id="MainContainer">
                          <div>
                            <div class="info">
                              <input type="checkbox" name="" id="utbap_hide_duration"    style="display: none;">
                            </div>
                            <div class="Switch disabled">
                              <div class="Toggle"></div>
                              <span class="On">ON</span> <span class="Off">OFF</span> </div>
                            </div>
                          </div>
                        </td>
                      </tr>
                      </table>
                    </section>
                    <section id="utbap-content3">
                       <table>

        <tr>
          <td style="vertical-align: top;">
          <a style="font-size: 20px;" target="_blank" href="https://www.arrowplugins.com/youtube-feed">Included in Premium Version</a>
            <h3 style="margin: ;">Show Call-to-Action Button: </h3> 
          </td>
          <td>
            <div id="MainContainer" style="margin-top: 27px;">
              <div>
                <div class="info">
                  <input disabled type="checkbox" name="" id="utbap_cta_button"   style="display: none;">
                </div>
                <div class="Switch disabled">
                  <div class="Toggle"></div>
                  <span class="On">ON</span> <span class="Off">OFF</span> </div>
                </div>
              </div>
            </td>
          </tr>


            <tr>
          <td style="vertical-align: top;">
            <h3 style="margin: ;">CTA Button Text: </h3>
          </td>
          <td>
            <input disabled style="width: 400px" type="text" name="" id="" value="">
            </td>
          </tr>

           <tr>
          <td style="vertical-align: top;">
            <h3 style="margin: ;">CTA Button URL: </h3>
          </td>
          <td>
            <input disabled style="width: 400px" type="url" name="utbap_cta_url" id="" placeholder="Example http://www.site.com" value="">
            </td>
          </tr>
          </table>
                    </section>
                    <section id="utbap-content4">
                      <table id="utbap_general_options" style="">
                        <tr>
                          <td>
                            <h3>Background Color: </h3> 
                          </td>
                          <td>
                            <input   class="color_picker" type="text" id="utbap_background_color" name="utbap_background_color"  value="<?php if($utbap_background_color == ''){echo '#ECEFF1';}else{echo $utbap_background_color;} ?>" /> 
                          </td>
                        </tr>
                        
                        <tr>
                          <td>
                            <h3>Header Background Color: </h3> 
                          </td>
                          <td>
                            <input   class="color_picker" type="text" id="utbap_header_background_color" name="utbap_header_background_color"  value="<?php if($utbap_header_background_color == ''){echo 'rgb(163, 79, 16)';}else{echo $utbap_header_background_color;} ?>" /> 
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <h3>Channel Name Text Color: </h3> 
                          </td>
                          <td>
                            <input   class="color_picker" type="text" id="utbap_header_text_color" name="utbap_header_text_color"  value="<?php if($utbap_header_text_color == ''){echo 'black';}else{echo $utbap_header_text_color;} ?>" /> 
                          </td>
                        </tr>
                        </table>


                        <table id="utbap_premium_feature_table" style="background: rgba(251, 251, 251, 0.9);
    border: 1px solid #ececec;
    border-radius: 5px;
    padding-left: 35px;">
    <tr><td colspan="2" style="padding-left: 15%;
    font-size: 20px;
    padding-top: 13px;"><a target="_blank" href="https://www.arrowplugins.com/youtube-feed">Included in Premium Version</a></td></tr>
                        <tr>
                          <td>
                            <h3>Thumbnail Background Color: </h3> 
                          </td>
                          <td>
                            <input   class="color_picker" type="text" id="utbap_thumbnail_background_color" name=""   /> 
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <h3>Thumbnail Title Color: </h3> 
                          </td>
                          <td>
                            <input   class="color_picker" type="text" id="utbap_thumbnail_title_color" name=""   /> 
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <h3>Thumbnail Description Color: </h3> 
                          </td>
                          <td>
                            <input   class="color_picker" type="text" id="utbap_thumbnail_description_color" name=""   /> 
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <h3>Views & Date Color: </h3> 
                          </td>
                          <td>
                            <input   class="color_picker" type="text" id="utbap_view_date_color" name=""  /> 
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <h3>Tabs Color: </h3> 
                          </td>
                          <td>
                            <input   class="color_picker" type="text" id="utbap_tabs_color" name=""   /> 
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <h3>Select & Loading Button's Text Color: </h3> 
                          </td>
                          <td>
                            <input   class="color_picker" type="text" id="utbap_loading_button_color" name=""   /> 
                          </td>
                        </tr>
                        <!-- <tr>
                          <td>
                            <h3>Base Font Size: </h3> 
                          </td>
                          <td>
                            <input  style="width: 50px;" type="number" id="utbap_base_font_size" name="utbap_base_font_size"  value="<?php if($utbap_base_font_size == ''){echo '16';}else{echo $utbap_base_font_size;} ?>" /> px
                          </td>
                        </tr>
                        <tr> -->
                          <td>
                            <h3>Title Font Family: </h3> 
                          </td>
                          <td>
                            <select name="utbap_title_font_family" id=""  > 
                              <option value="Roboto Condensed" >Roboto Condensed</option>
                              <option value="Open Sans" >Open Sans</option>
                              <option value="sans-serif">sans-serif</option>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <h3>Title Boldness: </h3> 
                          </td>
                          <td>
                            <select name="" id="utbap_title_boldness" > 
                              <option value="bold" >Bold</option>
                              <option value="normal">>Normal</option>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <h3>General Font Family: </h3> 
                          </td>
                          <td>
                            <select name="" id="utbap_general_font_family"  > 
                              <option value="Roboto Condensed">Roboto Condensed</option>
                              <option value="Open Sans">Open Sans</option>
                              <option value="sans-serif">sans-serif</option>
                            </select>
                          </td>
                        </tr>
                      </table>
                    </section>
                  </main>
                  <script type="text/javascript">

                    jQuery(document).ready(function() {

// Switch Click
jQuery('.Switch').click(function() {

if (jQuery(this).hasClass('disabled')){

alert('This is a **Premium Feature**');
}else{
// Check If Enabled (Has 'On' Class)

if (jQuery(this).hasClass('On')){

// Try To Find Checkbox Within Parent Div, And Check It
jQuery(this).parent().find('input:checkbox').attr('checked', true);

// Change Button Style - Remove On Class, Add Off Class
jQuery(this).removeClass('On').addClass('Off');

} else { // If Button Is Disabled (Has 'Off' Class)

// Try To Find Checkbox Within Parent Div, And Uncheck It
jQuery(this).parent().find('input:checkbox').attr('checked', false);

// Change Button Style - Remove Off Class, Add On Class
jQuery(this).removeClass('Off').addClass('On');

}
}

});

// Loops Through Each Toggle Switch On Page
jQuery('.Switch').each(function() {

// Search of a checkbox within the parent
if (jQuery(this).parent().find('input:checkbox').length){

// This just hides all Toggle Switch Checkboxs
// Uncomment line below to hide all checkbox's after Toggle Switch is Found
//jQuery(this).parent().find('input:checkbox').hide();

// For Demo, Allow showing of checkbox's with the 'show' class
// If checkbox doesnt have the show class then hide it
if (!jQuery(this).parent().find('input:checkbox').hasClass("show")){ jQuery(this).parent().find('input:checkbox').hide(); }
// Comment / Delete out the above line when using this on a real site

// Look at the checkbox's checkked state
if (jQuery(this).parent().find('input:checkbox').is(':checked')){

// Checkbox is not checked, Remove the 'On' Class and Add the 'Off' Class
jQuery(this).removeClass('On').addClass('Off');

} else { 

// Checkbox Is Checked Remove 'Off' Class, and Add the 'On' Class
jQuery(this).removeClass('Off').addClass('On');

}

}

});

});

////////////////////////////////////////////////////////
// Ignore This Bit - Only To Load Syntax Highlighting //
////////////////////////////////////////////////////////

</script>