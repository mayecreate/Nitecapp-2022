<?php
/**
 * The single file.
 *
 * This page template is setup so that you can modify the number of columns and there widths.  There are 12 available columns.
 * For example if you want to have them setup 2/3 you will set it up with two divs one
 * with the class of span8 and one with a class of span4
*/
get_header(); ?>
        
        <div class="row justify-content-center">
            <div class="col-9">
                <?php 
                    $current_user = wp_get_current_user();
                    $post_author_id = $post->post_author;
                ?>
                <?php $related_user = get_field("related_user", $post->ID); ?>
                <?php if (($current_user->ID == $post_author_id) || ($current_user->ID == $related_user)) { ?>
                    <?php if (have_posts()) : ?>
                    <?php while (have_posts()) : the_post(); ?>
                        <?php the_content(); ?>
                        <div class="divider"></div>
                        <?php comments_template(); ?>
                    <?php endwhile; ?>                                            
                    <?php endif; ?>
                <?php } else { ?>
                    <h2 class="center">Sorry, this note isn't for your current user.</h2>
                <?php } ?>
            
            </div><!-- 8 -->
           

        </div>
        </div>
    </div>
<?php get_footer(); ?>