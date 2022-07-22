<?php 
/*
 * Instantiates wordpress menus
 */
if (!function_exists( 'mayecreate_wp_bootstrapwp_theme_setup' ) ):
  		function mayecreate_wp_bootstrapwp_theme_setup() {
			// Adds the main menu
			register_nav_menus( array(
				  'top-menu' 		=> __( 'Top Menu', 'mayecreate_wp_bootstrapwp' ),
				  'main-menu'		=> __( 'Main Menu', 'mayecreate_wp_bootstrapwp' ),
				  'main-menu-admin'		=> __( 'Main Menu - Admins', 'mayecreate_wp_bootstrapwp' ),
				  'main-menu-mod'		=> __( 'Main Menu - Moderator', 'mayecreate_wp_bootstrapwp' ),
				  'main-menu-patient'		=> __( 'Main Menu - Patient', 'mayecreate_wp_bootstrapwp' ),
				  'main-menu-cargiver'		=> __( 'Main Menu - Care Giver', 'mayecreate_wp_bootstrapwp' ),
				  'footer-menu' 	=> __( 'Footer Menu', 'mayecreate_wp_bootstrapwp' ),
				  'mobile-menu' 	=> __( 'Mobile Menu', 'mayecreate_wp_bootstrapwp' ),
				  'mobile-menu-admin'		=> __( 'Mobile Menu - Admins', 'mayecreate_wp_bootstrapwp' ),
				  'mobile-menu-mod'		=> __( 'Mobile Menu - Moderator', 'mayecreate_wp_bootstrapwp' ),
				  'mobile-menu-patient'		=> __( 'Mobile Menu - Patient', 'mayecreate_wp_bootstrapwp' ),
				  'mobile-menu-cargiver'		=> __( 'Mobile Menu - Care Giver', 'mayecreate_wp_bootstrapwp' ),
			));
}
endif;
add_action( 'after_setup_theme', 'mayecreate_wp_bootstrapwp_theme_setup' );