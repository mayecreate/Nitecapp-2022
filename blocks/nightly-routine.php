<?php if (is_admin()) { ?>
	<p class="center" style="color: #FF0004"><strong>============== Nightly Routine field will show here ==============</strong></p>
<?php } else { ?>
<?php acf_form_head(); ?>
	<?php
		global $current_user;
		if(current_user_can('care-giver') || current_user_can('administrator') || current_user_can('instructors_assistant')) {
		$current_selected_user = get_field("current_selected_user", 'user_'.$current_user->ID);
		if ($current_selected_user) {
			$current_selected_user_ID = $current_selected_user;
		} else {
			$current_selected_user_ID = get_current_user_id();
		} 
	} else {
		$current_selected_user_ID = get_current_user_id();
	} ?>
	<?php $update_routine = array(
		'post_id' => 'user_'.$current_selected_user_ID,
		'fields' => array('field_6144d2c5cee23'),
		'form' => true, 
		'return' => add_query_arg( 'Nightly Routine Updated', 'true', get_permalink() ), 
		'html_before_fields' => '',
		'html_after_fields' => '',
		'submit_value' => 'Update Nightly Routine' 
	);
	acf_form( $update_routine );
	?>	
<?php } ?>