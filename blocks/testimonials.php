<?php if (is_admin()) { ?>
	<p class="center" style="color: #FF0004"><strong>============== Single Testimonial Will Display Here ==============</strong></p>
<?php } else { ?>
<?php
$testimonial_to_display = get_field('testimonial_to_display', $post->ID);
if( $testimonial_to_display ): ?>
<?php foreach( $testimonial_to_display as $testimonial ): ?>
<?php $postIDs []= $testimonial->ID; ?>
<?php endforeach; ?>
<?php endif; ?>

<?php // args
$args = array(
'posts_per_page'	=> 1,
'order'		=> 'rand',
'orderby'	=> 'rand',
'post_type' => 'testimonial',
'post__in' => $postIDs
); ?>

<?php // query
$wp_query = new WP_Query( $args );

// loop
while( $wp_query->have_posts() )
{
$wp_query->the_post();

?>
<div class="testimonial_wrapper">
	<h4><?php the_title(); ?></h4>
	<p><?php the_content(); ?></p>
</div>

<?php } // end the loop ?>
<!--Reset Query-->
<?php wp_reset_query();?>


<?php } ?>