<?php 
global $current_user, $wp_roles;
/* Load the registration file. */
//require_once( ABSPATH . WPINC . '/registration.php' ); //deprecated since 3.1
$error = array();    
/* If profile was saved, update profile. */
if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'update-user' ) {
	if ( !empty( $_POST['current_selected_user'] ) )
	update_user_meta( $current_user->ID, 'current_selected_user', esc_attr( $_POST['current_selected_user'] ) );
	
	/* Redirect so the page will show updated info.*/
	/*I am not Author of this Code- i dont know why but it worked for me after changing below line to if ( count($error) == 0 ){ */
    if ( count($error) == 0 ) {
        //action hook for plugins and extra fields saving
        do_action('edit_user_profile_update', $current_user->ID);
        wp_redirect( get_permalink() );
        exit;
    }
}
?>
<?php
/*
* Template Name: Care Giver Home
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
	<?php } elseif(current_user_can('care-giver') || current_user_can('administrator')) { ?>
		<?php
		$users = get_field("related_user", 'user_'.$current_user->ID);
		$current_selected_user = get_field("current_selected_user", 'user_'.$current_user->ID);
		?>
		<?php
		$selected_display = get_display_name($current_selected_user);
		?>
		<?php if( $users ): ?>
			<div class="row">
				<div class="col-md-12">
					<h2>Select the participant you wish to view data for:</h2>
					<form method="post" id="adduser" action="<?php the_permalink(); ?>">
						<select class="volunteers-list" name="current_selected_user">
							<?php if (($current_selected_user != 'none') || ($current_selected_user != '') || ($current_selected_user != '0')) { ?>
							<option value="<?php $current_selected_user; ?>">Current Selected Participant: <?php echo $selected_display; ?></option>
							<option value="none">View All</option>
							<option value="<?php echo $current_user->ID ?>">Myself</option>
							<?php } else { ?>
							<option value="0">Select User</option>
							<option value="<?php echo $current_user->ID ?>">Myself</option>
							<?php } ?>
							<?php foreach( $users as $user ): ?>
								<option value="<?php echo $user->ID; ?>"><?php echo $user->display_name; ?></option>
							<?php endforeach; ?>
						</select>
						<p class="form-submit">
							<?php echo $referer; ?>
							<input name="updateuser" type="submit" id="updateuser" class="submit button" value="<?php _e('Update Selected Participant', 'profile'); ?>" />
							<?php wp_nonce_field( 'update-user' ) ?>
							<input name="action" type="hidden" id="action" value="update-user" />
						</p><!-- .form-submit -->
					</form><!-- #adduser -->
					<?php the_content(); ?>
				</div>
			</div>
		<?php endif; ?>
	<?php } else { ?>
		<div class="row">
		    <div class="col-md-12">
                <h2>Sorry, you need to be a logged in care giver to view this page.</h2>
            </div>
		</div>
	<?php } ?>
	</div><!-- / hfeed site container -->
</div><!-- / page -->


<?php get_footer(); ?>