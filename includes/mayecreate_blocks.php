<?php 

/**
 * Creates the functionality for custom blocks using Advanced Custom Fields Pro
 *
 */  

// THIS FUNCTION ALLOWS YOU TO SET THE COLOR SWATCHES IN THE COLOR PICKER ON THE PAGEBREAK BLOCK
function my_acf_collor_pallete_script() {
    ?>
    <script type="text/javascript">
    (function($){
        
        acf.add_filter('color_picker_args', function( args, $field ){

            // ADD THE HEX CODES FOR YOUR THEMES COLORS HERE
            args.palettes = ['#F1F7FD', '#EAECEE']
            
            console.log(args);
            // return
            return args;
        });
        
    })(jQuery);
    </script>
    <?php
}

add_action('acf/input/admin_footer', 'my_acf_collor_pallete_script');


function register_acf_block_types() {

    // register a simple pagebreak block.
    acf_register_block_type(
		array(
			'name'              => 'pagebreak',
			'title'             => __('Page Break - Simple'),
			'description'       => __('Add a simple pagebreak to your page.'),
			'render_template'   => 'blocks/pagebreak.php',
			'category'          => 'formatting',
			'icon'              => 'editor-insertmore',
			'keywords'          => array( 'page', 'break', 'pagebreak' ),
		)
	);
	
    // register a partial pagebreak block.
    acf_register_block_type(
		array(
			'name'              => 'pagebreak-start',
			'title'             => __('Page Break - Complex'),
			'description'       => __('Add a opening pagebreak block to your page. PLEASE NOTE: If this pagebreak is the last one on the page you DO NOT need the End Break block after. If this is not the last element on the page the you NEED to put the End Break block after.'),
			'render_template'   => 'blocks/pagebreak-complex.php',
			'category'          => 'formatting',
			'icon'              => 'editor-insertmore',
			'keywords'          => array( 'page', 'break', 'pagebreak' ),
		)
	);
	
    // register a endbreak block.
    acf_register_block_type(
		array(
			'name'              => 'endbreak',
			'title'             => __('End Break'),
			'description'       => __('Close a pagebreak block on your page.'),
			'render_template'   => 'blocks/endbreak.php',
			'category'          => 'formatting',
			'icon'              => 'editor-insertmore',
			'keywords'          => array( 'page', 'break', 'pagebreak' ),
		)
	);

    // register a button block.
    acf_register_block_type(
		array(
			'name'              => 'mc-button',
			'title'             => __('MC Button'),
			'description'       => __('Add a button to your page.'),
			'render_template'   => 'blocks/mc_button.php',
			'category'          => 'formatting',
			'icon'              => 'admin-links',
			'keywords'          => array( 'button' ),
		)
	);

    // register Nightly Routine block.
    acf_register_block_type(
		array(
			'name'              => 'nightly-routine',
			'title'             => __('Nightly Routine'),
			'description'       => __('Add Nightly Routine field to your page.'),
			'render_template'   => 'blocks/nightly-routine.php',
			'category'          => 'formatting',
			'icon'              => 'admin-links',
			'keywords'          => array( 'night', 'routine', 'nightly' ),
		)
	);

    // register Morning Routine block.
    acf_register_block_type(
		array(
			'name'              => 'morning-routine',
			'title'             => __('Morning Routine'),
			'description'       => __('Add Morning Routine field to your page.'),
			'render_template'   => 'blocks/morning-routine.php',
			'category'          => 'formatting',
			'icon'              => 'admin-links',
			'keywords'          => array( 'morning', 'routine' ),
		)
	);

    // register Pleasant Activities block.
    acf_register_block_type(
		array(
			'name'              => 'pleasant-activities',
			'title'             => __('Pleasant Activities'),
			'description'       => __('Add Pleasant Activities field to your page.'),
			'render_template'   => 'blocks/pleasant-activities.php',
			'category'          => 'formatting',
			'icon'              => 'admin-links',
			'keywords'          => array( 'pleasant', 'activities' ),
		)
	);

    // register Testimonials block.
    acf_register_block_type(
		array(
			'name'              => 'testimonials',
			'title'             => __('MC Testimonials'),
			'description'       => __('Add Testimonials to your page.'),
			'render_template'   => 'blocks/testimonials.php',
			'category'          => 'formatting',
			'icon'              => 'format-status',
			'keywords'          => array( 'testimonials', 'testimonial', 'quote' ),
		)
	);

    // register Tips for Caregivers block.
    acf_register_block_type(
		array(
			'name'              => 'caregiver-tips',
			'title'             => __('Tips for Caregivers'),
			'description'       => __('Add Caregiver Tips to your page.'),
			'render_template'   => 'blocks/caregiver-tips.php',
			'category'          => 'formatting',
			'icon'              => 'format-chat',
			'keywords'          => array( 'tips', 'tip', 'care', 'caregiver', 'giver' ),
		)
	);
}

// Check if function exists and hook into setup.
add_action('acf/init', 'register_acf_block_types');