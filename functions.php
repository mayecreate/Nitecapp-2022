<?php

// NOTE: To overwrite the script file in the parent theme uncomment this section and copy the mayecreate_sripts.js file into a folder called js in your child theme. Then edit that file.
add_action('wp_enqueue_scripts', 'mayecreate_script_fix', 100);
function mayecreate_script_fix()
{
    wp_dequeue_script('mayecreatejs');
    wp_dequeue_script('mc-block-editor-script');
    wp_enqueue_script( 'mc-block-editor-script_child', get_stylesheet_directory_uri() . '/js/mayecreate_scripts.js', false, '1.0', 'all' );
    wp_enqueue_script('child_theme_mayecreatejs', get_stylesheet_directory_uri().'/js/mayecreate_scripts.js', array('jquery'));
}

add_action( 'wp_enqueue_scripts', 'mc_enqueue_child_theme_styles', PHP_INT_MAX);
function mc_enqueue_child_theme_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri().'/css/main.min.css' );
    wp_enqueue_style( 'child-style', get_stylesheet_directory_uri().'/css/main.min.css', array('parent-style')  );
}
function mayecreate_admin_scripts() {
	if (is_page_template( 'page-admin-data.php' || 'page-moderator-home.php' )) { 
		// Loads screenshot JavaScript files.
		wp_enqueue_script('html2canvas', 'https://html2canvas.hertzen.com/dist/html2canvas.min.js', array('jquery'),'3.0.0', true );
		wp_enqueue_script('canvas2image', get_stylesheet_directory_uri() . '/js/canvas2image.js', array('jquery'),'3.0.0', true );
	}

}
add_action('wp_enqueue_scripts', 'mayecreate_admin_scripts');

function parent_editor_style_setup() {
	// Add support for editor styles.
	add_editor_style(  get_template_directory_uri().'/css/main.min.css' );
}
add_action( 'after_setup_theme', 'parent_editor_style_setup' );

require_once 'includes/mayecreate_shortcodes.php';

$set_items_to_one_column = (get_field('set_items_to_one_column', 'option'));
if ($set_items_to_one_column == "Yes") {

	add_action( 'wp_enqueue_scripts', 'mc_enqueue_column_styles', PHP_INT_MAX);
	function mc_enqueue_column_styles() {
		wp_enqueue_style( 'column-style', get_stylesheet_directory_uri().'/css/single_column.css' );
	}
 
}
$additional_css = (get_field('additional_css', 'option'));
if ($additional_css) {

	add_action( 'wp_enqueue_scripts', 'mc_enqueue_additional_css_styles', PHP_INT_MAX);
	function mc_enqueue_additional_css_styles() {
		require_once 'css/additional_css.php';
	}

}

/* NOTE: These functions are functions that don't need to be in the parent theme because not every site will have them. */
function build_taxonomies() {
   register_taxonomy( 'faqcategory', 'menu', array( 'hierarchical' => true, 'label' => 'Categories', 'query_var' => true, 'rewrite' => true, 'show_in_rest' => true ) );
}
add_action( 'init', 'build_taxonomies', 0 );

function mayecreate_create_post_type_child() {
	
	// Register the "FAQ" custom post type if this is not needed, DELETE ME.
		register_post_type( 'mc-faq',
			array(
				'labels' => array(
					'name'              => __( 'FAQs'),
					'singular_name'     => __( 'FAQ' ),
					'add_new'           => __( 'Add FAQ' ),
					'add_new_item'      => __( 'Add New FAQ' ),
					'edit_item'         => __( 'Edit FAQ' ),  
					
				),
			'public' => true,
			'menu_position' => 10,
			'rewrite' => array('slug' => 'faq'),
			'supports' => array('title','revisions','editor'),
			'menu_icon'         => 'dashicons-editor-help',
			'taxonomies' => array('faqcategory'),
			'show_in_rest' => true,
			'has_archive' => true 
			)
		);
	
	// Register the "Moderator Notes" custom post type if this is not needed, DELETE ME.
		register_post_type( 'moderator-notes',
			array(
				'labels' => array(
					'name'              => __( 'Moderator Notes'),
					'singular_name'     => __( 'Moderator Note' ),
					'add_new'           => __( 'Add Note' ),
					'add_new_item'      => __( 'Add New Note' ),
					'edit_item'         => __( 'Edit Note' ),  
					
				),
			'public' => true,
			'menu_position' => 10,
			'rewrite' => array('slug' => 'moderator-note'),
			'supports' => array('title','revisions','editor'),
			'menu_icon'         => 'dashicons-format-aside',
			'show_in_rest' => true,
			'has_archive' => true 
			)
		);
}
add_action( 'init', 'mayecreate_create_post_type_child' );

add_action('after_setup_theme', 'remove_admin_bar');
 
function remove_admin_bar() {
if (!current_user_can('administrator') && !is_admin()) {
  show_admin_bar(false);
}
}
function get_display_name($user_id) {
    if (!$user = get_userdata($user_id))
        return false;
    return $user->data->display_name;
}
function wps_change_role_name() {
    global $wp_roles;
    if ( ! isset( $wp_roles ) )
        $wp_roles = new WP_Roles();
    $wp_roles->roles['subscriber']['name'] = 'Patients';
    $wp_roles->role_names['subscriber'] = 'Patients';           
}
add_action('init', 'wps_change_role_name');

/**
 * Declare explicit theme support for LifterLMS course and lesson sidebars
 * @return   void
 */
function my_llms_theme_support(){
	add_theme_support( 'lifterlms-sidebars' );
}
add_action( 'after_setup_theme', 'my_llms_theme_support' );

remove_action( 'lifterlms_single_course_after_summary', 'lifterlms_template_single_prerequisites', 55 );
add_action( 'lifterlms_single_course_before_summary', 'lifterlms_template_single_prerequisites', 10 );

add_action( 'lifterlms_single_course_before_summary', 'add_mod_notes', 11 );
function add_mod_notes(){
    get_template_part('partials/loop','notes');
}

function the_title_trim($title) {

	$title = attribute_escape($title);

	$findthese = array(
		'#Protected:#',
		'#Private:#'
	);

	$replacewith = array(
		'', // What to replace "Protected:" with
		'' // What to replace "Private:" with
	);

	$title = preg_replace($findthese, $replacewith, $title);
	return $title;
}
add_filter('the_title', 'the_title_trim');

add_filter('frm_setup_new_fields_vars', 'frm_populate_user_dropdown', 20, 2);
add_filter('frm_setup_edit_fields_vars', 'frm_populate_user_dropdown', 20, 2);
function frm_populate_user_dropdown( $values, $field ){
	 if ( $field->id == 174 ) {
		 $role = 'subscriber';
		 $users = get_users( array( 'role' => $role ) );
		 $values['options'] = array('');
		 foreach ( $users as $user ) {
			 /*$values['options'][] = array(
				 'label' => $user->display_name,
				 'value' => $user->ID
			 );*/
            $values['options'][$user->ID] = $user->display_name;
		 }
         $values['use_key'] = true;
	 }
	 return $values;
}

add_filter('frm_setup_new_fields_vars', 'frm_populate_posts', 20, 2);
add_filter('frm_setup_edit_fields_vars', 'frm_populate_posts', 20, 2); //use this function on edit too
function frm_populate_posts($values, $field){
  if($field->id == 173){ //replace 125 with the ID of the field to populate
    $posts = get_posts( array('post_type' => 'course', 'post_status' => array('publish'), 'numberposts' => 999, 'orderby' => 'title', 'order' => 'ASC', 'exclude' => '1770'));
    unset($values['options']);
    $values['options'] = array(''); //remove this line if you are using a checkbox or radio button field
    $values['options'][''] = ''; //remove this line if you are using a checkbox or radio button field
    foreach($posts as $p){
      $values['options'][$p->ID] = $p->post_title;
    }
    $values['use_key'] = true; //this will set the field to save the post ID instead of post title
    unset($values['options'][0]);
  }
  return $values;
}

// add the filter for your relationship field
	add_filter('acf/update_value/key=field_5e00ff0f46fbd', 'acf_reciprocal_relationship', 10, 3);
	// if you are using 2 relationship fields on different post types
	// add second filter for that fields as well
	add_filter('acf/update_value/key=field_5e051593be3f7', 'acf_reciprocal_relationship', 10, 3);
	
	function acf_reciprocal_relationship($value, $post_id, $field) {
		
		// set the two fields that you want to create
		// a two way relationship for
		// these values can be the same field key
		// if you are using a single relationship field
		// on a single post type
		
		// the field key of one side of the relationship
		$key_a = 'field_5e00ff0f46fbd';
		// the field key of the other side of the relationship
		// as noted above, this can be the same as $key_a
		$key_b = 'field_5e051593be3f7';
		
		// figure out wich side we're doing and set up variables
		// if the keys are the same above then this won't matter
		// $key_a represents the field for the current posts
		// and $key_b represents the field on related posts
		if ($key_a != $field['key']) {
			// this is side b, swap the value
			$temp = $key_a;
			$key_a = $key_b;
			$key_b = $temp;
		}
		
		// get both fields
		// this gets them by using an acf function
		// that can gets field objects based on field keys
		// we may be getting the same field, but we don't care
		$field_a = acf_get_field($key_a);
		$field_b = acf_get_field($key_b);
		
		// set the field names to check
		// for each post
		$name_a = $field_a['name'];
		$name_b = $field_b['name'];
		
		// get the old value from the current post
		// compare it to the new value to see
		// if anything needs to be updated
		// use get_post_meta() to a avoid conflicts
		$old_values = get_post_meta($post_id, $name_a, true);
		// make sure that the value is an array
		if (!is_array($old_values)) {
			if (empty($old_values)) {
				$old_values = array();
			} else {
				$old_values = array($old_values);
			}
		}
		// set new values to $value
		// we don't want to mess with $value
		$new_values = $value;
		// make sure that the value is an array
		if (!is_array($new_values)) {
			if (empty($new_values)) {
				$new_values = array();
			} else {
				$new_values = array($new_values);
			}
		}
		
		// get differences
		// array_diff returns an array of values from the first
		// array that are not in the second array
		// this gives us lists that need to be added
		// or removed depending on which order we give
		// the arrays in
		
		// this line is commented out, this line should be used when setting
		// up this filter on a new site. getting values and updating values
		// on every relationship will cause a performance issue you should
		// only use the second line "$add = $new_values" when adding this
		// filter to an existing site and then you should switch to the
		// first line as soon as you get everything updated
		// in either case if you have too many existing relationships
		// checking end updated every one of them will more then likely
		// cause your updates to time out.
		//$add = array_diff($new_values, $old_values);
		$add = $new_values;
		$delete = array_diff($old_values, $new_values);
		
		// reorder the arrays to prevent possible invalid index errors
		$add = array_values($add);
		$delete = array_values($delete);
		
		if (!count($add) && !count($delete)) {
			// there are no changes
			// so there's nothing to do
			return $value;
		}
		
		// do deletes first
		// loop through all of the posts that need to have
		// the recipricol relationship removed
		for ($i=0; $i<count($delete); $i++) {
			$related_values = get_post_meta($delete[$i], $name_b, true);
			if (!is_array($related_values)) {
				if (empty($related_values)) {
					$related_values = array();
				} else {
					$related_values = array($related_values);
				}
			}
			// we use array_diff again
			// this will remove the value without needing to loop
			// through the array and find it
			$related_values = array_diff($related_values, array($post_id));
			// insert the new value
			update_post_meta($delete[$i], $name_b, $related_values);
			// insert the acf key reference, just in case
			update_post_meta($delete[$i], '_'.$name_b, $key_b);
		}
		
		// do additions, to add $post_id
		for ($i=0; $i<count($add); $i++) {
			$related_values = get_post_meta($add[$i], $name_b, true);
			if (!is_array($related_values)) {
				if (empty($related_values)) {
					$related_values = array();
				} else {
					$related_values = array($related_values);
				}
			}
			if (!in_array($post_id, $related_values)) {
				// add new relationship if it does not exist
				$related_values[] = $post_id;
			}
			// update value
			update_post_meta($add[$i], $name_b, $related_values);
			// insert the acf key reference, just in case
			update_post_meta($add[$i], '_'.$name_b, $key_b);
		}
		
		return $value;
		
	} // end function acf_reciprocal_relationship


function get_user_role() {
    global $current_user;
    $user_roles = $current_user->roles;
    $user_roles_list = implode(" ", $user_roles);
    return $user_roles_list;
}

add_filter('body_class','my_class_names');
function my_class_names($classes) {
    $classes[] = get_user_role();
    return $classes;
}

/**
 * Makes it so caregivers can mark their users lessons as completed 
**/
function my_llms_user_id() {
	
	global $current_user;
	$current_selected_user = get_field("current_selected_user", 'user_'.$current_user->ID);
	if (($current_selected_user == 'none') || ($current_selected_user == '') || ($current_selected_user == '0')) {
		$current_selected_user_ID = get_current_user_id();
	} elseif($current_selected_user) {
		$current_selected_user_ID = $current_selected_user;
	} else {
		$current_selected_user_ID = get_current_user_id();
	}
	return $current_selected_user_ID;
	
}
add_filter( 'llms_lesson_completion_user_id', 'my_llms_user_id' );
add_filter( 'llms_lesson_incomplete_user_id', 'my_llms_user_id' );

/**
 * ADDS CUSTOM ROLE TO LIST THAT CAN ADD COMMENTS 
**/
function my_llms_discuss_role($role) {
	
	$role[] = 'instructors_assistant';
	return $role;
	
}
add_filter( 'llms_pa_post_roles_can_discuss', 'my_llms_discuss_role' );

/**
 * Customize the number of columns displayed on LifterLMS Course and Membership Catalogs
 * Note that LifterLMS has native support for 1 - 6 columns
 * If you require 7 or more columns you will need to write custom CSS to accommodate
 * @param    int     $cols  default number of columns (3)
 * @return   int
 */
function my_llms_loop_cols( $cols ) {
	$set_items_to_one_column = (get_field('set_items_to_one_column', 'option'));
	if ($set_items_to_one_column == "Yes") {
		return 1; // change this to be the number of columns you want
	} else {		
		return 3; // change this to be the number of columns you want
	}
}
add_filter( 'lifterlms_loop_columns', 'my_llms_loop_cols' );

function mc_role_admin_body_class( $classes ) {
    global $current_user;
    foreach( $current_user->roles as $role )
        $classes .= ' role-' . $role;
    return trim( $classes );
}
add_filter( 'admin_body_class', 'mc_role_admin_body_class' );

add_action('admin_head', 'my_custom_fonts');

function my_custom_fonts() {
  echo '<style>
    .role-instructors_assistant .ab-top-menu li, .role-instructors_assistant #adminmenu > li, .role-instructors_assistant #poststuff #postexcerpt, .role-instructors_assistant #poststuff #authordiv, .role-instructors_assistant #poststuff #advanced-sortables {
      display:none !important;
    } 
	.role-instructors_assistant .ab-top-menu li#wp-admin-bar-site-name, .role-instructors_assistant .ab-top-menu li#wp-admin-bar-my-account, .role-instructors_assistant  #adminmenu > li#menu-posts-llms_pa_post, .role-instructors_assistant  #adminmenu > li#menu-posts-course, .role-instructors_assistant  #adminmenu > li#menu-users, .role-instructors_assistant  #adminmenu > li#menu-dashboard {
		display:block !important;
	}
  </style>';
}

/*add_filter('frm_validate_field_entry', 'calculate_time', 11, 3);
function calculate_time($errors, $field, $value){
    if($field->id == 333){ //Time In Bed
        $st = strtotime($_POST['item_meta'][222]); //change 23 to the ID of the first field
        $start_hour = (date('H',$st));
        $start_min = (date('i',$st));
        $start_total = (($start_hour * 60) + $start_min);
        $et = strtotime($_POST['item_meta'][231]); //change 24 to the ID of the second field
        $end_hour = (date('H',$et));
        $end_min = (date('i',$et));
        $end_total = (($end_hour * 60) + $end_min);
        if ($start_total < $end_total) {
            $final_time = $end_total - $start_total;
        } else {
            $final_time = ($end_total + (1440 - $start_total));
        }
        
        $value = $_POST['item_meta'][$field->id] = $final_time;
    }
}

add_filter('frm_validate_field_entry', 'calculate_time_part_2', 11, 3);
function calculate_time_part_2($errors, $field, $value){
    if($field->id == 332){ //Sleep Efficiency
        $part_one = $_POST['item_meta'][233]; //change 23 to the ID of the first field
        $st = strtotime($_POST['item_meta'][222]); //change 23 to the ID of the first field
        $start_hour = (date('H',$st));
        $start_min = (date('i',$st));
        $start_total = (($start_hour * 60) + $start_min);
        $et = strtotime($_POST['item_meta'][231]); //change 24 to the ID of the second field
        $end_hour = (date('H',$et));
        $end_min = (date('i',$et));
        $end_total = (($end_hour * 60) + $end_min);
        if ($start_total < $end_total) {
            $part_two = $end_total - $start_total;
        } else {
            $part_two = ($end_total + (1440 - $start_total));
        }
        $calc = $part_one / $part_two;
        $sleep_efficiency = round($calc, 2);
        $value = $_POST['item_meta'][$field->id] = $sleep_efficiency;
    }
    return $errors;
}*/