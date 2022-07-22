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
}

$current_selected_user_routine = get_field("pleasant_activities", 'user_'.$current_selected_user_ID);
echo $current_selected_user_routine;
?>
