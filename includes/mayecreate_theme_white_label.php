<?php 
/*
 * White labels the theme login for first line of security
 * @return void
 */

function mayecreate_custom_login_logo() {
	//get the custom logo field
	$custom_logo = get_field('site_logo', 'option');
	//if you have the field, use it, else default to the one in the theme folder.
	if ($custom_logo) { $custom_logo = $custom_logo; } else { $custom_logo = get_template_directory_uri().'/img/login-logo.png'; }
	echo '<style type="text/css">
	body.login {
		background:url('.get_stylesheet_directory_uri().'/img/login-body-bg.jpg) !important;
		background-size: cover !important;
		background-position: bottom center !important;
		background-color: #334A58 !important;
	}
	#login {
		width: 95%;
		max-width:600px;
		padding: 70px 0 0 0;
		margin: auto;
	} 
	.login h1 a {
		max-width: 325px !important;
		width:100% !important;
		height: 98px !important;
		background:url('.$custom_logo.') !important;
		background-repeat: no-repeat !important;
		background-size: contain !important;
		margin-bottom: 0;
	}
	.login form {
		background: transparent;
		-webkit-box-shadow: none;
    	box-shadow: none;
		margin-top: 0;
        border: 0 none;
	}
	.login label, .login a:link, .login a:visited {
		/* Change the style of the login form labels here */
		color:#fff !important;
	}	
	.login a:hover, .login a:active {
		color:#18CDD1 !important;
	}
	.login form .forgetmenot label {
   		/* Change the remember me checkbox label here */
		color:#fff !important;
	}
	
	input[type=text]:focus, input[type=password]:focus, input[type=checkbox]:focus{
		/* Style the form field focus state */
		border-color: #FED700;
		-webkit-box-shadow: 0 0 12px rgba(0,0,0,.25);
		box-shadow: 0 0 12px rgba(0,0,0,.25);
	}
	.wp-core-ui .button-group.button-large .button, .wp-core-ui .button.button-large{
		padding: 18px 40px;
		line-height: 0;
		font-size: 18px;
	}
	.wp-core-ui .button-primary {
		background: #FED700;
		border-color: #FED700;
		-webkit-box-shadow: none;
		box-shadow: none;
		color: #334A58;
		text-decoration: none;
		text-shadow: none;
		border-radius:0;
		text-transform:uppercase;
		font-weight:700;
	}
	.wp-core-ui .button-primary:hover, .wp-core-ui .button-primary:active, .wp-core-ui .button-primary:focus {
		background: #008AA2;
		border-color: #008AA2;
		-webkit-box-shadow: none;
		box-shadow: none;
		color: #fff;
	}
	
</style>';
}
add_action('login_head', 'mayecreate_custom_login_logo'); 


add_action( 'wp_before_admin_bar_render', function() {
global $wp_admin_bar;
$wp_admin_bar->remove_menu('wp-logo');
}, 7 );

function my_login_logo_url() {
	return get_bloginfo( 'url' );
}
add_filter( 'login_headerurl', 'my_login_logo_url' );

function my_login_logo_url_title() {
return get_bloginfo( 'name' );
}
add_filter( 'login_headertitle', 'my_login_logo_url_title' ); 

function remove_footer_admin () {
 
echo 'Fueled by <a href="http://www.wordpress.org" target="_blank">WordPress</a> | <a href="http://www.mayecreate.com/what-we-do/web-design/" target="_blank">Web Design by MayeCreate Design</a></p>';
 
}
  
add_filter('admin_footer_text', 'remove_footer_admin');


remove_action('welcome_panel', 'wp_welcome_panel');




function mayecreate_DBD() { 
	echo '<!--
	************
	DONT BE DUMB
	************
												@@@@@@@                                                 
											   @@@@@@@@@                                                
							 ,@@@              &@@@@@@@#                                                
						   @@@@@@@@,       /@            @@@@@@@@@@@@@@@                                
						   @@@@@@@@@   @@@@@@@@@@.   #@@@@@@@@@@@@@@@@@@@@@@@@@                         
							@@@@@@&   (@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@&                    
									 @@@@@@@@@@@@%                       ,@@@@@@@@@@@@@                 
						@@@@@@@@@@@@@@@@@@                                       @@@@@@@@@              
			@@@@@@    @@@@@@@@@@@@@@@            (@@@@@@@@@@@@@@@@@@@@@@@@@.          @@@@@@@           
		   @@@@@@@@@   @@@@@@@@@@          @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@*       @@@@@@         
		   @@@@@@@@/   @@@@@@@        &@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@(     #@@@@@       
			 @@@@     @@@@@%       @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@     @@@@@      
					@@@@@       @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@         @@@@@@@@@@.    @@@@@    
		   @@@@@@@@@@@@,      @@@@@@@@@@@@@&.  @@@@@          @@@@@@             ,@@@@@@@@@@    @@@@@   
		  @@@@@@@@@@@@      @@@@@@             @@@             @@@   @@@@@@@      @@@@@@@@@@@    @@@@&  
		 @@@@@@@@@@@#     %@@@@@@@            ,@  @@@@@@@,     &@  @@@@@@@@@      @@@@@@@@@@@@   #@@@@  
		@@@@@@@@@@@*     @@@@@@@@@@@@@@@      , &@@@@@@@@@       @@@@@@@@@@@      @@@@@@@@@@@@    @@@@@ 
	   /@@@@@@@@@@@     @@@@@@@@@@@@@@@@       @@@@@@@@@@@      @@@@@@@@@@@      @@@@@@@@@@@@@    @@@@@ 
	   @@@@@@@@@@@     /@@@@@@@@@@@@@@@@      @@@@@@@@@@@      @@@@@@@@@@@@      @@@@@@@@@@@@@    @@@@@ 
	   @@@@@@@@@@#     @@@@@@@@@@@@@@@@      @@@@@@@@@@@@      @@@@@@@@@@@      @@@@@@@@@@@@@@    @@@@@ 
	   @@@@@@@@@@      @@@@@@@@@@@@@@@@      @@@@@@@@@@@.     @@@@@@@@@@@       @@@@@@@@@@@@@,   %@@@@@ 
	   @@@@@@@@@@     .@@@@@@@@@@@@@@@      @@@@@@@@@@@@      @@@@@@@@@@@      @@@@@@@@@@@@@&    @@@@@( 
	   @@@@@@@@@@      @@@@@@@@@@@@@@@      @@@@@@@@@@@.     @@@@@@@@@@@      %@@@@@@@@@@@@     @@@@@@  
	   @@@@@@@@@@#     @@@@@@@@@@@@@@      @@@@@@@@@@@@      @@@@@@@@@@@      @@@@@@@@@@@@    @@@@@@@   
		@@@@@@@@@@     @@@@@@@@@@@@@@      @@@@@@@@@@@      @@@@@@@@@@@      @@@@@@@@@@#     @@@@@@@    
		%@@@@@@@@@(     @@@@@@@@@@@@      @@@@@@@@@@@@      @@@@@@@@@@@      @@@@@@@@      @@@@@@@@     
		 @@@@@@@@@@      @@@@@@@@@@@      @@@@@@@@@@@      @@@@@@@@@@@@      @@@@       %@@@@/          
		  (@@@@@@@@@      @@@@@@@@@      @@@@@@@@@@@@      @@@@@@@@@@@@@             @@@@@@   @@@@@     
			@@@@@@@@@@      @@@@@@@      @@@@@@@@@@@,     %@@@@@@@@@@@@@@@&. ,@@@@@@@@@@@    @@@@@@@    
			 %@@@@@@@@@#      @@@@      @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@        @@@@@@@    
			   @@@@@@@@@@@       @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@/        @@@             
				  @@@@@@@@@@@         @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@,          /@@@@                
					@@@@@@@@@@@@@                ,(&@@@@&/,                   @@@@@@@                   
					   .@@@@@@@@@@@@@@@.                               @@@@@@@@@@.                      
						   .@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@                           
								 @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@                                 
										 (@@@@@@@@@@@@@@@@@@@@,                                         
	-->
	';
}