<?php 
/*
==========================================================
FOOTER Menu, Social Media Bar and Credits
==========================================================
*/

global $containerWidth;
?>

<div class="<?php echo $containerWidth; ?>" >
	<div class="row align-items-center">

		<div class="col-md-12">
			<nav id="footer_nav" class="menu-main-menu-container">
				<ul id="menu-main-menu-1" class="menu">
					<?php  // Visit http://codex.wordpress.org/Function_Reference/wp_nav_menu for explanation of how this works.

					$footerMenu = array(
						'theme_location'  => 'footer-menu',
						'container'       => '',
						'container_class' => '',
						'container_id'    => '',
						'menu_class'      => '',
						'menu_id'         => '',
						'echo'            => true,
						'fallback_cb'     => '',
						'before'          => '',
						'after'           => '',
						'link_before'     => '<span>',
						'link_after'      => '</span>',
						'items_wrap'      => '%3$s',
						'depth'           => 1,
						); ?>

					<?php wp_nav_menu($footerMenu); ?>
					<?php if(is_user_logged_in() ) { ?>
					<li><a href="<?php echo wp_logout_url(); ?>">Logout</a></li>
					<?php } else { ?>	
					<li><a href="<?php bloginfo('url'); ?>/wp-admin/">Login</a></li>
					<?php } ?>
				</ul>
			</nav>
			
			<div class="clear"></div>

		</div>
		
	</div>	
</div>
