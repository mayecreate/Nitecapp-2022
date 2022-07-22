<?php
/**
 * The single file.
 *
 * This page template is setup so that you can modify the number of columns and there widths.  There are 12 available columns.
 * For example if you want to have them setup 2/3 you will set it up with two divs one
 * with the class of span8 and one with a class of span4
*/
get_header(); ?>
        
        <div class="row">
            <div class="col-lg-8 order-lg-2">
    
                <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>
            
                  
                       <?php the_content(); ?>
                
                <?php endwhile; ?>
                
               
                <?php else : ?>
                    
                    <h2>Not Found</h2>
                    <p>Sorry, nothing to show yet.</p>
                                            
                <?php endif; ?>
            
            </div><!-- 8 -->
			<div class="col-lg-4 order-lg-1 course_sidebar_wrapper">
				<?php dynamic_sidebar('Course Sidebar'); ?>
			</div>
           

        </div>
        </div>
    </div>
<?php get_footer(); ?>