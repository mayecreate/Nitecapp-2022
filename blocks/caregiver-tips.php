<?php if(current_user_can('care-giver') || current_user_can('administrator') || current_user_can('instructors_assistant')) { ?>
	<div class="mod_note_wrapper">
		<?php $optional_title = esc_html(get_field("optional_title", $post->ID)); ?>
		<?php $tip_content = get_field("tip_content", $post->ID); ?>
		<?php if ($optional_title) { ?>
			<h2><?php echo $optional_title; ?></h2>
		<?php } else { ?>
			<h2>Tips for Caregivers:</h2>
		<?php } ?>
		<?php if ($tip_content) { ?>
			<?php echo $tip_content; ?>
		<?php } ?>
	</div>
<?php } else {} ?>