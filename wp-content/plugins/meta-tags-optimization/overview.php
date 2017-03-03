<?php  
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); }

function mto_admin_overview()  {
	?>
	<div class="wrap mto-wrap">
        <?php screen_icon( 'nextgen-gallery' ); ?>
		<h2><?php _e('Meta Tags Optimization Overview', 'mto') ?></h2>
        <?php if (version_compare(PHP_VERSION, '5.0.0', '<')) mto_check_for_PHP5(); ?>
		<div id="dashboard-widgets-container" class="mto-overview">
		    <div id="dashboard-widgets" class="metabox-holder">
				<div id="post-body">
					<div id="dashboard-widgets-main-content">
						<div class="postbox-container" id="main-container" style="width:75%;">
							<?php do_meta_boxes('mto_overview', 'left', ''); ?>
						</div>
			    		<div class="postbox-container" id="side-container" style="width:24%;">
							<?php do_meta_boxes('mto_overview', 'right', ''); ?>
						</div>						
					</div>
				</div>
		    </div>
		</div>
	</div>
	
	<?php
}


add_meta_box('dashboard_right_now', __('Welcome to Meta Tags Optimization !', 'mto'), 'mto_overview_right_now', 'mto_overview', 'left', 'core');
function mto_overview_right_now()
{
	echo "<div style='padding:0px 20px 0px;'>";
	echo "<p><h1>Moral of the Story : Search Engines are very Smart. Don't break the Rules</h1></p><p>Yes, it's true. Don't break the rules and Meta tags optimization plugin helps you to optimize your meta information and make sure they're accpeted by search engines. Second, Don't just make focus on your home page only, each and every posts/page is equally important for your site popularity using search engines. I started this project for eveyr blogger who writes awesome useful posts but they're not appearning in search engines.</p><p><h2>How it Works</h2>
	</p>
<p>You'll see a new section on each posts/page which shows you green or red status for title,keywords and description. Green with Correct Sign means everything is ok with your meta information. Red with Wrong Sign means something went wrong. so we needs all 3 green and then do same for next posts/page. </p>
<img src='".get_bloginfo('siteurl')."/wp-content/plugins/meta-tags-optimization/screenshot-1.png' width='858' height='360' >
<h2>How to Edit Meta Tags</h2>
<p>To Add or Edit meta tags, Please go with <a target='_blank' href='http://codecanyon.net/item/meta-tags-optimization/4915633'>Pro Version</a>. Another way is <a href='http://wordpress.org/extend/plugins/all-in-one-seo-pack/' >All IN ONE SEO</a> wordpress plugin lets you do this easily. 
</p>";
echo "</div>";

}
add_meta_box('mto_meta_box', __('Donate', 'mto'), 'mto_likeThisMetaBox', 'mto_overview', 'right', 'core');



function mto_likeThisMetaBox() {
?>
<style>
.upcoming li
{
margin-left:17px;
text-transform:capitalize;
background:url('<?php echo get_bloginfo('siteurl')."/wp-content/plugins/meta-tags-optimization"; ?>/success.png') no-repeat left top;
padding:5px 5px 12px 38px;
}
</style>
<?php
	
	echo '<p style="font-size:16px;line-height:24px;">';
    echo sprintf(__('We have developed <a target="_blank" href="http://codecanyon.net/item/meta-tags-optimization/4915633">Pro Version</a> on high demands by users for additional features.', 'mto'));
	echo '</p>';
}


?>