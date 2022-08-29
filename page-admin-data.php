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
* Template Name: Admin Home
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
	<?php } elseif(current_user_can('administrator')) { ?>
		<?php
		$args = array(
			'role__in'    => array('subscriber', 'care-giver'),
			'orderby' => 'user_nicename',
			'order'   => 'ASC'
		);
		$users = get_users( $args );
		$current_selected_user = get_field("current_selected_user", 'user_'.$current_user->ID);
		?>
		<?php
		$selected_display = get_display_name($current_selected_user);
		?>
		<?php if( $users ) { ?>
			<div class="row">
				<div class="col-md-12">
					<h2>Sleep Diary Status</h2>
					<h3 class="collapse-title collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#target-sleep" aria-expanded="false" aria-controls="target-sleep" title="Sleep Diary Status" id="sleep">View Sleep Diary Status.</h3>
				</div>
			</div>
			<div class="row collapse-content collapse" id="target-sleep">
				<?php foreach( $users as $user ): ?>
					<div class="col-md-6">
						<?php $today = date('Y-m-d'); $yesterday = date('Y-m-d',strtotime("-1 days")); ?>
						<?php $last_completed = do_shortcode( '[frm-stats id=240 user_id='.$user->ID.' type=count 240="'.$today.'"]' ); ?>
						<?php $yeserday_last_completed = do_shortcode( '[frm-stats id=240 user_id='.$user->ID.' type=count 240="'.$yesterday.'"]' ); ?>

						<?php if ($last_completed >= '1') { $complete_text = '<span class="completed">Completed Today</span>'; } else { $complete_text = '<span class="not_completed">Not Completed Today</span>'; } ?>
						<?php if ($yeserday_last_completed >= '1') { $yesterday_complete_text = '<span class="completed">Completed Yesterday</span>'; } else { $yesterday_complete_text = '<span class="not_completed">Not Completed Yesterday</span>'; } ?>

						<h3><?php echo $user->display_name; ?>: <?php echo $complete_text; ?></h3>
						<h6><?php echo $yesterday_complete_text; ?></h6>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
	<div class="pagebreak">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h2>Select the participant you wish to view data for:</h2>
					<form method="post" id="adduser" action="<?php the_permalink(); ?>">
						<select aria-expanded="false" class="volunteers-list" name="current_selected_user">
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
							<input role="button" name="updateuser" type="submit" id="updateuser" class="submit button" value="<?php _e('Update Selected Participant', 'profile'); ?>" />
							<?php wp_nonce_field( 'update-user' ) ?>
							<input name="action" type="hidden" id="action" value="update-user" />
						</p><!-- .form-submit -->
					</form><!-- #adduser -->
					<?php the_content(); ?>
				</div>
			</div>
		</div>
	</div>
	<div class="pagebreak_fix">
		<div class="container">
		<?php } else { ?>
			<div class="row">
				<div class="col-md-12">
					<h2>Sorry, you have no related users to show data for.</h2>
				</div>
			</div>	
		<?php } ?>
			<div class="row">
				<?php if (($current_selected_user != 'none') || ($current_selected_user != '') || ($current_selected_user != '0')) { ?>
					<div class="col-md-12">
					<h2>User Data for <?php echo $selected_display; ?>:</h2>
					<div class="mod_graph_wrapper">
						<div id="capture_one">
							<?php //Time is recorded in military time (AKA 24-hour clock). EXAMPLE: 2:00PM is actually 14:00 ?>
							<?php //echo do_shortcode( '[frm-graph fields="332" type="bar" title="Sleep Efficiency" title_size="20" title_bold="1" title_color="#333" width="100%" y_title="Number of Entries" is_stacked="0" x_title="Sleep Efficiency Calculation" x_slanted_text="0" data_type="total" user_id="'.$current_selected_user.'"]' ); ?>
							<?php echo do_shortcode( '[frm-graph fields="332" type="line" title="Sleep Efficiency" title_size="20" title_bold="1" title_color="#333" width="100%" x_title="Date of Entries" is_stacked="0" y_title="Sleep Efficiency Calculation" x_slanted_text="0" data_type="total" x_axis="created_at" user_id="'.$current_selected_user.'"]' ); ?>
						</div>
						<button class="btn-mayecreate center" onclick="download_one()">Download Sleep Efficiency Screenshot</button>
						<div id="capture_two">
							<?php //echo do_shortcode( '[frm-graph fields="224" type="bar" title="Sleep Onset Latency" title_size="20" title_bold="1" title_color="#333" width="100%" y_title="Number of Entries" is_stacked="0" x_title="Time to Fall Asleep" x_slanted_text="0" data_type="total" user_id="'.$current_selected_user.'"]' ); ?>
							<?php echo do_shortcode( '[frm-graph fields="224" type="line" title="Sleep Onset Latency" title_size="20" title_bold="1" title_color="#333" width="100%" x_title="Date of Entries" is_stacked="0" y_title="Time to Fall Asleep" x_slanted_text="0" data_type="total" x_axis="created_at" user_id="'.$current_selected_user.'"]' ); ?>
						</div>
						<button class="btn-mayecreate center" onclick="download_two()">Download Sleep Onset Latency Screenshot</button>
						<div id="capture_three">
							<?php //echo do_shortcode( '[frm-graph fields="226" type="bar" title="Wake After Sleep Onset" title_size="20" title_bold="1" title_color="#333" width="100%" y_title="Number of Entries" is_stacked="0" x_title="Time Awake in the Middle of the Night" x_slanted_text="0" data_type="total" user_id="'.$current_selected_user.'"]' ); ?>
							<?php echo do_shortcode( '[frm-graph fields="226" type="line" title="Wake After Sleep Onset" title_size="20" title_bold="1" title_color="#333" width="100%" x_title="Date of Entries" is_stacked="0" y_title="Time Awake in the Middle of the Night" x_slanted_text="0" data_type="total" x_axis="created_at" user_id="'.$current_selected_user.'"]' ); ?>
						</div>
						<button class="btn-mayecreate center" onclick="download_three()">Download Wake After Sleep Onset Screenshot</button>
						<div id="capture_four">
							<?php //echo do_shortcode( '[frm-graph fields="233" type="bar" title="Total Sleep Time" title_size="20" title_bold="1" title_color="#333" width="100%" y_title="Number of Entries" is_stacked="0" x_title="Total Time Asleep (Minutes)" x_slanted_text="0" data_type="total" user_id="'.$current_selected_user.'"]' ); ?>
							<?php echo do_shortcode( '[frm-graph fields="233" type="line" title="Total Sleep Time" title_size="20" title_bold="1" title_color="#333" width="100%" x_title="Date of Entries" is_stacked="0" y_title="Total Time Asleep (Minutes)" x_slanted_text="0" data_type="total" x_axis="created_at" user_id="'.$current_selected_user.'"]' ); ?>
						</div>
						<button class="btn-mayecreate center" onclick="download_four()">Download Total Sleep Time Screenshot</button>
						<div id="capture_five">
							<?php //echo do_shortcode( '[frm-graph fields="235" type="bar" title="Sleep Quality Rating" title_size="20" title_bold="1" title_color="#333" width="100%" y_title="Number of Entries" is_stacked="0" x_title="Quality of Sleep Rating" x_slanted_text="0" data_type="total" user_id="'.$current_selected_user.'"]' ); ?>
							<?php echo do_shortcode( '[frm-graph fields="235" type="line" title="Sleep Quality Rating" title_size="20" title_bold="1" title_color="#333" width="100%" x_title="Date of Entries" is_stacked="0" y_title="Quality of Sleep Rating" x_slanted_text="0" data_type="total" x_axis="created_at" user_id="'.$current_selected_user.'"]' ); ?>
						</div>
						<button class="btn-mayecreate center" onclick="download_five()">Download Sleep Quality Rating Screenshot</button>
					</div>
				</div>
				<?php } else { ?>
					<div class="col-md-12">
					<h2>All User Data:</h2>
					<div class="mod_graph_wrapper">
						<div id="capture_one">
							<?php //echo do_shortcode( '[frm-graph fields="332" type="bar" title="Sleep Efficiency" title_size="20" title_bold="1" title_color="#333" width="100%" y_title="Number of Entries" is_stacked="0" x_title="Sleep Efficiency Calculation" x_slanted_text="0" data_type="total"]' ); ?>
							<?php echo do_shortcode( '[frm-graph fields="332" type="line" title="Sleep Efficiency" title_size="20" title_bold="1" title_color="#333" width="100%" x_title="Date of Entries" is_stacked="0" y_title="Sleep Efficiency Calculation" x_slanted_text="0" data_type="total" x_axis="created_at"]' ); ?>
						</div>
						<button class="btn-mayecreate center" onclick="download_one()">Download Sleep Efficiency Screenshot</button>
						<div id="capture_two">
							<?php //echo do_shortcode( '[frm-graph fields="224" type="bar" title="Sleep Onset Latency" title_size="20" title_bold="1" title_color="#333" width="100%" y_title="Number of Entries" is_stacked="0" x_title="Time to Fall Asleep" x_slanted_text="0" data_type="total"]' ); ?>
							<?php echo do_shortcode( '[frm-graph fields="224" type="line" title="Sleep Onset Latency" title_size="20" title_bold="1" title_color="#333" width="100%" x_title="Date of Entries" is_stacked="0" y_title="Time to Fall Asleep" x_slanted_text="0" data_type="total" x_axis="created_at"]' ); ?>
						</div>
						<button class="btn-mayecreate center" onclick="download_two()">Download Sleep Onset Latency Screenshot</button>
						<div id="capture_three">
							<?php //echo do_shortcode( '[frm-graph fields="226" type="bar" title="Wake After Sleep Onset" title_size="20" title_bold="1" title_color="#333" width="100%" y_title="Number of Entries" is_stacked="0" x_title="Time Awake in the Middle of the Night" x_slanted_text="0" data_type="total"]' ); ?>
							<?php echo do_shortcode( '[frm-graph fields="226" type="line" title="Wake After Sleep Onset" title_size="20" title_bold="1" title_color="#333" width="100%" x_title="Date of Entries" is_stacked="0" y_title="Time Awake in the Middle of the Night" x_slanted_text="0" data_type="total" x_axis="created_at"]' ); ?>
						</div>
						<button class="btn-mayecreate center" onclick="download_three()">Download Wake After Sleep Onset Screenshot</button>
						<div id="capture_four">
							<?php //echo do_shortcode( '[frm-graph fields="233" type="bar" title="Total Sleep Time" title_size="20" title_bold="1" title_color="#333" width="100%" y_title="Number of Entries" is_stacked="0" x_title="Total Time Asleep (Minutes)" x_slanted_text="0" data_type="total"]' ); ?>
							<?php echo do_shortcode( '[frm-graph fields="233" type="line" title="Total Sleep Time" title_size="20" title_bold="1" title_color="#333" width="100%" x_title="Date of Entries" is_stacked="0" y_title="Total Time Asleep (Minutes)" x_slanted_text="0" data_type="total" x_axis="created_at"]' ); ?>
						</div>
						<button class="btn-mayecreate center" onclick="download_four()">Download Total Sleep Time Screenshot</button>
						<div id="capture_five">
							<?php //echo do_shortcode( '[frm-graph fields="235" type="bar" title="Sleep Quality Rating" title_size="20" title_bold="1" title_color="#333" width="100%" y_title="Number of Entries" is_stacked="0" x_title="Quality of Sleep Rating" x_slanted_text="0" data_type="total"]' ); ?>
							<?php echo do_shortcode( '[frm-graph fields="235" type="line" title="Sleep Quality Rating" title_size="20" title_bold="1" title_color="#333" width="100%" x_title="Date of Entries" is_stacked="0" y_title="Quality of Sleep Rating" x_slanted_text="0" data_type="total" x_axis="created_at"]' ); ?>
						</div>
						<button class="btn-mayecreate center" onclick="download_five()">Download Sleep Quality Rating Screenshot</button>
					</div>
				</div>
				<?php } ?>
			</div>
			<?php if ($users) { ?>
			</div>
		</div>
	</div>
	<div class="pagebreak">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h2>My Messages:</h2>
					<?php // args
					$args = array(
					'posts_per_page'	=> -1,
					'order'			=> 'DESC', // ASC = OLDEST EVENT FIRST, DESC= NEWEST EVENT FIRST 
					'post_type' => 'llms_pa_post',
					'paged' => $paged,
					'author' => $current_user->ID
					
					); ?>

					<?php // query
					$wp_query = new WP_Query( $args );
					// loop
					if( $wp_query->have_posts() )
					{ ?>
					<h3 class="h4">Click on a post to edit or reply to the post.</h3>
					<div class="discussion_post_wrapper">
						<?php // loop
						while( $wp_query->have_posts() )
						{
						$wp_query->the_post();

						?>
						<?php $llms_pa_user_id = esc_html(get_field("_llms_pa_user_id", $post->ID)); ?>
						<?php $discussion_user = get_display_name($llms_pa_user_id); ?>
						<a class="discussion_post_inner" href="<?php echo get_edit_post_link(); ?>" target="_blank">
							<h3 class="h6"><?php the_title(); ?> - Discussion with <?php echo $discussion_user; ?></h3>
							<?php echo '<p>'. excerpt(55) . '</p>'; ?>
							<p><strong>Current Number of Replies:</strong> <span class="comment_number"><?php echo get_comments_number($post->ID); ?></span></p>
						</a>
						<?php } // end the loop ?>
						<!--Reset Query-->
						<?php wp_reset_query();?>
					</div>
					<?php } else { ?>
						<h3>Sorry, no discussion posts to show yet.</h3>
					<?php } // end the loop ?>
					<a href="<?php bloginfo('url'); ?>/wp-admin/post-new.php?post_type=llms_pa_post" class="btn-mayecreate center" target="_blank">Add a New Discussion Post</a>
				
			<?php } ?>
	<?php } else { ?>
		<div class="row">
		    <div class="col-md-12">
                <h2>Sorry, you need to be an admin to view this page.</h2>
            </div>
		</div>
	<?php } ?>
	</div><!-- / hfeed site container -->
</div><!-- / page -->

<script>

	const download_one = () => {
		html2canvas(document.querySelector('#capture_one')).then(canvas => {
			//document.getElementById('screenshots').appendChild(canvas);
			return Canvas2Image.saveAsJPEG(canvas);
		});
	}
	const download_two = () => {
		html2canvas(document.querySelector('#capture_two')).then(canvas => {
			//document.getElementById('screenshots').appendChild(canvas);
			return Canvas2Image.saveAsJPEG(canvas);
		});
	}
	const download_three = () => {
		html2canvas(document.querySelector('#capture_three')).then(canvas => {
			//document.getElementById('screenshots').appendChild(canvas);
			return Canvas2Image.saveAsJPEG(canvas);
		});
	}
	const download_four = () => {
		html2canvas(document.querySelector('#capture_four')).then(canvas => {
			//document.getElementById('screenshots').appendChild(canvas);
			return Canvas2Image.saveAsJPEG(canvas);
		});
	}
	const download_five = () => {
		html2canvas(document.querySelector('#capture_five')).then(canvas => {
			//document.getElementById('screenshots').appendChild(canvas);
			return Canvas2Image.saveAsJPEG(canvas);
		});
	}
   
</script>

<?php get_footer(); ?>