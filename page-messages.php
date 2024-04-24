<?php
/*
* Template Name: Messages
*
*/
get_header(); ?>		
        
        <?php if(!is_user_logged_in() ) { ?> 
        <div class="row">
            <div class="col-md-12">
                <h2>Sorry, you need to be logged in to view this page.</h2>	
                <h4>Please login below.</h4>
                <?php $login_form_args = array(
                    'echo'           => true,
                    'remember'       => true,
                    'redirect'       => ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
                    'form_id'        => 'loginform',
                    'id_username'    => 'user_login',
                    'id_password'    => 'user_pass',
                    'id_remember'    => 'rememberme',
                    'id_submit'      => 'wp-submit',
                    'label_username' => __( 'Username or Email Address' ),
                    'label_password' => __( 'Password' ),
                    'label_remember' => __( 'Remember Me' ),
                    'label_log_in'   => __( 'Log In' ),
                    'value_username' => '',
                    'value_remember' => false
                ); ?>
                <?php wp_login_form( $login_form_args ); ?> 
            </div>
        </div>
        <?php } else { ?>
		<div class="row">
		    <?php get_template_part('partials/loop','standard'); ?>
            <?php $message_submit_form_id = esc_html(get_field("message_submit_form_id", $post->ID)); ?>
            <?php $related_therapistcaregiver = get_user_meta($user_ID, 'related_therapistcaregiver', true); ?>
            <?php if ($related_therapistcaregiver != "") { ?>
                <a class="btn-mayecreate center" data-bs-toggle="collapse" href="#collapseMessage" role="button" aria-expanded="false" aria-controls="collapseMessage">Send a Message to Your Therapist</a>
                <div class="collapse" id="collapseMessage">
                    <?php echo FrmFormsController::get_form_shortcode( array( 'id' => $message_submit_form_id ) ); ?>
                </div>
                <div class="divider"></div>
            <?php } ?>

		</div>
        <div class="row justify-content-center">
            <div class="col-9">
                <h2>My Messages</h2>
            </div>
            <?php $user_ID = get_current_user_id(); $user_read_post_message = get_user_meta($user_ID, 'read_posts', true); ?>
            <?php // args
            $args = array(
            'posts_per_page'	=> -1,
            'order'			=> 'DESC', // ASC = OLDEST EVENT FIRST, DESC= NEWEST EVENT FIRST 
            'post_type' => 'moderator-notes',
            'paged' => $paged,
            'meta_query'    => array(
                'relation'    => 'OR',
                array(
                    'field'   => 'author',
                    'value'   => $user_ID,
                    'compare' => '==',
                ),
                array(
                    'key'       => 'related_user',
                    'value'     => $user_ID,
                    'compare'   => '=',
                ),
            ),
            ); ?>

            <?php // query
            $wp_query = new WP_Query( $args );

            // loop
            while( $wp_query->have_posts() )
            {
            $wp_query->the_post();

            ?>          
            <?php $post_ID = get_the_ID(); ?>  
            <?php if (in_array($post_ID , $user_read_post_message)) { $unred_class_post = ""; } else { $unred_class_post = "unread"; } ?>
                <div class="col-9">
                    <div class="mod_note_wrapper <?php echo $unred_class_post; ?>">
                        <?php if (in_array($post_ID , $user_read_post_message)) { } else { ?>
                            <i class="fa-solid fa-star"></i>
                        <?php } ?>
                        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        <?php echo '<p>'. excerpt(50) . '</p>'; ?>
                    </div>
                </div>

            <?php } // end the loop ?>
            <!--Reset Query-->
            <?php wp_reset_query();?>
        </div>   
        <div class="divider"></div>     
		<div class="row">
		    <a href="<?php bloginfo('url'); ?>/dashboard/notifications/" class="btn-mayecreate large center">View All Your Course Notifications</a>
		</div>
        <?php } ?>
	</div><!-- / hfeed site container -->
</div><!-- / page -->


<?php get_footer(); ?>

