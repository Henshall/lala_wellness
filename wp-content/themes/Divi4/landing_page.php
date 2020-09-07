<?php
/*
Template Name: landing_page
*/





$is_page_builder_used = et_pb_is_pagebuilder_used( get_the_ID() ); ?>

<div id="main-content">

<?php if ( ! $is_page_builder_used ) : ?>

	<div class="container">
		<div id="content-area" class="clearfix">
			<div id="left-area">

<?php endif; ?>

			<?php while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<?php if ( ! $is_page_builder_used ) : ?>

				<?php
					$thumb = '';

					$width = (int) apply_filters( 'et_pb_index_blog_image_width', 1080 );

					$height = (int) apply_filters( 'et_pb_index_blog_image_height', 675 );
					$classtext = 'et_featured_image';

					$thumb = $thumbnail["thumb"];

					if ( 'on' === et_get_option( 'divi_page_thumbnails', 'false' ) && '' !== $thumb )
						print_thumbnail( $thumb, $thumbnail["use_timthumb"], $titletext, $width, $height );
				?>

				<?php endif; ?>

					<div class="entry-content">
					<?php
						the_content();

						if ( ! $is_page_builder_used )
							wp_link_pages( array( 'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'Divi' ), 'after' => '</div>' ) );
					?>
					</div> <!-- .entry-content -->



				</article> <!-- .et_pb_post -->

			<?php endwhile; ?>

<?php if ( ! $is_page_builder_used ) : ?>

			</div> <!-- #left-area -->


		</div> <!-- #content-area -->
	</div> <!-- .container -->

<?php endif; ?>

</div> <!-- #main-content -->

<head>
<link rel="stylesheet" type="text/css" href="/wp-content/themes/Divi3/css/landing_page.css">
<meta name="viewport" content="width=device-width,initial-scale=1">

</head>

<div class="image_container">
  <img class="image" src="http://lalawellness.ca/wp-content/uploads/2017/02/background_image_small.jpg" alt=""  />

</div>


<div class="container">
  <div class="logo_div">
    <img id= "logo_leaf" src="http://lalawellness.ca/wp-content/uploads/2017/02/laLa-wellness-revamped-logo-2016-FINAL-white-tag-centered.png" alt="" width="300" height="232" class="alignnone size-medium wp-image-531" />
  </div>

<div class="button_div"><br><br>

  <form target="_blank" action="/yoga">
    <input class="button" type="submit" value="Kids Yoga Classes" />
</form>
<form target="_blank" action="/learning">
  <input class="button" type="submit" value="Teacher Resources" />
</form>

</div>
<div class="trademark">
  <br>
  ©2016 laLa wellness
</div>
<div class="pop_up1">
  Looking for <br> <a target="_blank" style="color: white;" href="/yoga"><u>kids yoga programs</u></a> <br> for your school or <br> daycare? Click Here!

</div>
<img class="left " src="http://lalawellness.ca/wp-content/uploads/2017/02/laLa-landing-pg-2017-arrow-left.png" alt="" width="300" height="300" />

<div class="pop_up2">
  Looking for <br><a target="_blank" style="color: white;" href="/learning"><u>PD and resources</u></a>  <br> for you and your <br> class? Click Here!

</div>
<img class="right" src="http://lalawellness.ca/wp-content/uploads/2017/02/laLa-landing-pg-2017-arrow-right.png" alt="" width="300" height="300" />


</div>


</div>
