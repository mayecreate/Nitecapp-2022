<?php
/*
* Template Name: FAQ
*
*/
get_header(); ?>
		
        
		<div class="row">
		    <?php get_template_part('partials/loop','standard'); ?>
		</div>
        <div class="row">
            <div class="col-md-12">
                <?php if(!is_user_logged_in() ) { ?> 
                    <?php // args PUBLIC FAQ ONLY
                    $args = array(
                    'posts_per_page'	=> -1,
                    'order'			=> 'DESC', // ASC = OLDEST EVENT FIRST, DESC= NEWEST EVENT FIRST 
                    'post_type' => 'mc-faq',
                    'paged' => $paged,
                    'tax_query' => array(
                    'relation' => 'OR',
                        array (
                            'taxonomy'  => 'faqcategory',
                            'field'     => 'ID',
                            'terms'     => '36'
                        )
                        )
                    ); ?>

                    <?php // query
                    $wp_query = new WP_Query( $args );

                    // loop
                    while( $wp_query->have_posts() )
                    {
                    $wp_query->the_post();

                    ?>

                    <h2 class="collapse-title collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#target-<?php the_ID(); ?>" aria-expanded="false" aria-controls="target-<?php the_ID(); ?>" title="Expand to learn <?php the_title(); ?>"><?php the_title(); ?></h2>
                    <div id="target-<?php the_ID(); ?>" class="collapse-content collapse"><?php the_content(); ?></div>
                    <div class="divider"></div>

                    <?php } // end the loop ?>
                    <!--Reset Query-->
                    <?php wp_reset_query();?>
                <?php } else { ?>
                    <?php // args LOGGED IN SHOWS ALL FAQs
                    $args = array(
                    'posts_per_page'	=> -1,
                    'order'			=> 'DESC', // ASC = OLDEST EVENT FIRST, DESC= NEWEST EVENT FIRST 
                    'post_type' => 'mc-faq',
                    'paged' => $paged,
                    ); ?>

                    <?php // query
                    $wp_query = new WP_Query( $args );

                    // loop
                    while( $wp_query->have_posts() )
                    {
                    $wp_query->the_post();

                    ?>

                    <h2 class="collapse-title collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#target-<?php the_ID(); ?>" aria-expanded="false" aria-controls="target-<?php the_ID(); ?>" title="Expand to learn <?php the_title(); ?>"><?php the_title(); ?></h2>
                    <div id="target-<?php the_ID(); ?>" class="collapse-content collapse"><?php the_content(); ?></div>
                    <div class="divider"></div>

                    <?php } // end the loop ?>
                    <!--Reset Query-->
                    <?php wp_reset_query();?>
                <?php } ?>
            </div>
        </div>
	</div><!-- / hfeed site container -->
</div><!-- / page -->


<?php get_footer(); ?>
