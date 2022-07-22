<?php global $containerWidth; ?> 
<?php $show_top_navbar = ('yes' == get_field('show_top_navbar', 'option')); ?>

<?php if ($show_top_navbar) { ?>
        <div id="navbarTop" class="navbar navbar-default">
            <div class="<?php echo $containerWidth; ?>" > 
                <?php  // Visit http://codex.wordpress.org/Function_Reference/wp_nav_menu for explanation of how this works.
                    
                    $topMenu = array(
                        'theme_location'  => 'top-menu',
                        'container'       => 'nav',
                        'container_class' => '',
                        'container_id'    => 'top_nav',
                        'menu_class'      => 'menu pull-right',
                        'menu_id'         => '',
                        'echo'            => true,
                        'fallback_cb'     => '',
                        'before'          => '',
                        'after'           => '',
                        'link_before'     => '<span>',
                        'link_after'      => '</span>',
                        'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                        'depth'           => 3,
                        'walker'          => ''
                        ); ?>
    
                    <?php wp_nav_menu($topMenu); ?>
            </div>
        </div>
<?php } ?>
   

<div id="navbarBottom" class="navbar navbar-default ">
	<div class="<?php echo $containerWidth; ?>" > 
		<div class="navbar-header">

			<div id="mobile_menu">
				<a href="#drawer-menu" class="nav-button nav-button-x">
					<span>toggle menu</span>
				</a>
			</div>

			<?php mayecreate_custom_logo(); ?>

		</div>
		
		<nav id="main_nav" class="menu-main-menu-container">
			<ul id="menu-main-menu" class="menu pull-right">
					
			<?php if(is_user_logged_in() && current_user_can('administrator')) {
				$theme_location = 'main-menu-admin';
			} elseif(is_user_logged_in() && current_user_can('instructors_assistant')) {
				$theme_location = 'main-menu-mod';
			} elseif(is_user_logged_in() && current_user_can('care-giver')) {
				$theme_location = 'main-menu-cargiver';
			} elseif(is_user_logged_in()) {
				$theme_location = 'main-menu-patient';
			} else {
				$theme_location = 'main-menu';
			} ?>

			<?php  // Visit http://codex.wordpress.org/Function_Reference/wp_nav_menu for explanation of how this works.

				$topMenu = array(
					'theme_location'  => $theme_location,
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
					'depth'           => 2,
					'walker'          => ''
					); ?>

				<?php wp_nav_menu($topMenu); ?>
				<?php if(is_user_logged_in() ) { ?>
				<li><a href="<?php echo wp_logout_url(); ?>">Logout</a></li>
				<?php } else { ?>	
				<li><a href="<?php bloginfo('url'); ?>/wp-admin/">Login</a></li>
				<?php } ?>
			</ul>
		</nav>
	</div>
		<?php $progress_bar = ('Yes' == get_field('progress_bar')); ?>
		<?php if (is_singular('lesson') || $progress_bar) { ?>
			<div class="progress">
				<div class="progress__highlight" id="js-highlight"></div>
			</div>
		<?php } ?>
</div>
	