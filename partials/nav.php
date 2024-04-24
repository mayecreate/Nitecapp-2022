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
<?php $user_id = get_current_user_id(); ?>
<?php if (!empty($user_id)) { ?>
	<?php $user_read_post_header = get_user_meta($user_id, 'read_posts', true); ?>
	<?php //print_r($user_read_post_header); ?>
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
			'value'     => $user_id,
			'compare'   => '=',
		),
	),
	); ?>
	<?php // query
	$wp_query = new WP_Query( $args );
	// loop
	while( $wp_query->have_posts() ) { $wp_query->the_post(); ?>
		<?php $post_ids []= get_the_ID(); ?>
	<?php } // end the loop ?>
	<?php wp_reset_query();?> 
	<?php if ($post_ids != "") { $post_ids = $post_ids; } else { $post_ids = array(); }; ?>
	<?php if (empty(array_diff($post_ids, $user_read_post_header))) { 
		$unred_class = ""; 
	} else { 
		$unred_class = "unread"; 
	} ?>
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
					<?php if (!empty($user_id)) { ?>
						<li class="navigation_notification <?php echo $unred_class; ?>"><a href="<?php bloginfo('url'); ?>/messages/"><i class="fa-solid fa-bell"></i></a></li> 
					<?php } ?>
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
	