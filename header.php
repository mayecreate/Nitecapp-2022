<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">


<?php 

/**
 * ==========================================================
 * MayeCreate Title
 * ==========================================================
 */
if ( ! $desc && is_llms_private_area() ) {
	
	echo '<title>'. get_bloginfo( 'name' ) .' | Discussion</title>';
	
} else {
	echo '<title>';
	
	/* Print the <title> tag based on what is being viewed. */
	global $page, $paged;
	
	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'skematik' ), max( $paged, $page ) );
	
	echo '</title>';
}
?>
<?php if ((get_theme_mod('facebook_opengraph', 'not-include') == 'include') && !is_llms_private_area() ) { 
		mayecreate_facebook_opengraph();
} ?>


<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<!-- Fonts -->
	
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" crossorigin="anonymous">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.4.2/css/all.css" crossorigin="anonymous">
<script src="https://kit.fontawesome.com/539078998e.js" crossorigin="anonymous" async></script>

<?php $google_font_embed_links = (get_field('google_font_embed_links', 'option')); ?>
<?php if ($google_font_embed_links) {
	echo $google_font_embed_links;
} else {
	echo '<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">';
} ?>

<?php wp_head(); ?>
    
<?php $ga_tag = (get_field('ga_tag', 'option')); ?>
<?php if ($google_font_embed_links) {
echo $ga_tag;
} ?>

<div id="skip"><a href="#content">Skip to Main Content</a></div>

</head>



<?php global $containerWidth; ?> 

<body <?php body_class(); ?>>
<?php $confetti = ('Yes' == get_field('confetti')); ?>
<?php if (is_page_template('page-confetti.php') || $confetti) { ?>
<div class="wrapper"></div>
<?php } ?>

<div id="pagewrapper">
<a id="top"></a>
<?php $navbar_style_fixed = ('fixed' == get_field('navbar_style', 'option')); ?>
<?php if ($navbar_style_fixed) {
	$navbar_style = "fixed";
} else {
	$navbar_style = "static";
} ?>
<div id="navigation" class="<?php echo $navbar_style; ?>">
	<?php get_template_part('partials/nav'); ?>	
</div>	


<?php if (is_front_page()) { ?>
		<div id="homeContentWrap">
<?php } else { ?>
		<div id="contentwrap">
<?php } ?>	

<div class="clear"></div>
<?php $default_header_image = get_field('default_header_image', 'option'); ?>
<?php if ($default_header_image) {
	$default_header_image = $default_header_image;
} else {
	$default_header_image = get_bloginfo('url') .'/wp-content/themes/mayecreate-child-theme/img/heading_bg.jpg';
} ?>
<?php if (is_front_page()){ ?>

	<div id="internalfeatured" class="home_internalfeatured" style="background-image: url('<?php echo $default_header_image; ?>')">
		<div aria-hidden="true" id="star_tr"></div>
		<div aria-hidden="true" id="star_tl"></div>
		<div aria-hidden="true" id="star_br"></div>
		<div aria-hidden="true" id="star_bl"></div>
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-sm-12 col-md-10 col-md-push-1 page-header">
					<?php $header_content = get_field("header_content"); ?>
					<?php echo $header_content; ?>
					<div class="clear"></div>
					<?php if(is_user_logged_in() ) { ?>
					<a class="btn-mayecreate" href="<?php bloginfo('url'); ?>/courses/">Get Started</a>
					<?php } else { ?>	
					<a class="btn-mayecreate" href="<?php bloginfo('url'); ?>/wp-admin/">Login to Get Started</a>
					<?php } ?>
				</div>
			</div>				
		</div>
	</div>

<?php } else { ?>
		<div id="internalfeatured" style="background-image: url('<?php echo $default_header_image; ?>')">
			<div aria-hidden="true" id="star_tr"></div>
			<div aria-hidden="true" id="star_tl"></div>
			<div aria-hidden="true" id="star_br"></div>
			<div aria-hidden="true" id="star_bl"></div>
			<div class="container">
				<?php if (is_home()) { ?>
					<div class="row">
						<div class="col-md-12 page-header">
							<h1 class="entry-title">Blog</h1>
						</div>
					</div>
				<?php } elseif (is_courses()) { ?>
					<div class="row">
						<div class="col-md-12 page-header">
							&nbsp;
						</div>
					</div>
				<?php } elseif (is_archive()) { ?>
					<div class="row">
						<div class="col-md-12 page-header">
							<h1 class="entry-title">
								<?php						
									if (taxonomy_exists('wpsc_product_category')){
										_e( 'Products in the', 'skematik' );

									} elseif ( is_category() ) {
										printf( __( '%s', 'skematik' ), '<span>' . single_cat_title( '', false ) . '</span>' );

									} elseif ( is_tag() ) {
										printf( __( 'Tag Archives: %s', 'skematik' ), '<span>' . single_tag_title( '', false ) . '</span>' );

									} elseif ( is_author() ) {
										/* Queue the first post, that way we know
										* what author we're dealing with (if that is the case).
										*/
										the_post();
										printf( __( 'Author Archives: %s', 'skematik' ), '<span class="vcard"><a class="url fn n" href="' . get_author_posts_url( get_the_author_meta( "ID" ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a></span>' );
										/* Since we called the_post() above, we need to
										* rewind the loop back to the beginning that way
										* we can run the loop properly, in full.
										*/
										rewind_posts();

									} elseif ( is_day() ) {
										printf( __( 'Daily Archives: %s', 'skematik' ), '<span>' . get_the_date() . '</span>' );

									} elseif ( is_month() ) {
										printf( __( 'Monthly Archives: %s', 'skematik' ), '<span>' . get_the_date( 'F Y' ) . '</span>' );

									} elseif ( is_year() ) {
										printf( __( 'Yearly Archives: %s', 'skematik' ), '<span>' . get_the_date( 'Y' ) . '</span>' );

									} elseif (taxonomy_exists('wpsc_product_category')){
										_e( 'Products in the', 'skematik' );

									} elseif (is_tax('peoplecategory')){
										printf( __( 'WK People: %s', 'skematik' ), '<span>' . single_cat_title( '', false ) . '</span>' );

									} else {
										echo "Archive";

									}
									?>
							</h1>
						</div>
					</div>
				<?php } elseif (is_search()) { ?>
					<div class="row">
						<div class="col-md-12 page-header">
							<h1 class="entry-title">Results for: <?php  echo get_search_query(); ?></h1>
						</div>
					</div>
				<?php } elseif (is_404()) { ?>
					<div class="row">
						<div class="col-md-12 page-header">
							<h1 class="entry-title">ERROR 404</h1>
						</div>
					</div>
				<?php } elseif (is_front_page()) {} else { ?>
					<?php mayecreate_page_title();?>
				<?php } ?>
			</div>		
		</div>
                
<?php } ?>

<main id="content">
<div id="page"> <!--Begin Page -->
<div class="pagebreak_fix">
<div class="hfeed site <?php echo $containerWidth; ?>">
