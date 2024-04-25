<?php
/*
* Template Name: Sleep Prescription
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
            <?php $user_ID = get_current_user_id(); ?>
            <?php $sleep_prescription = get_field('sleep_prescription', 'user_'. $user_ID); ?>
            <?php if ($sleep_prescription) { ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="mod_note_wrapper">
                            <h2 class="margin_bottom_0 h3">New sleep prescription available</h2>
                            <?php echo $sleep_prescription; ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
		<div class="row">
		    <?php get_template_part('partials/loop','standard'); ?>
		</div>
        <?php } ?>
	</div><!-- / hfeed site container -->
</div><!-- / page -->


<?php get_footer(); ?>
