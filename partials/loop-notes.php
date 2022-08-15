<?php $related_moderator_note = get_field('related_moderator_note'); ?>
<?php if( $related_moderator_note ): ?>
    <?php foreach( $related_moderator_note as $moderator_note ): ?>
		<?php if ( get_post_status($moderator_note->ID) == 'publish' ) { ?>
			<?php $related_user = get_field("related_user", $moderator_note->ID); ?>
			<?php $graph_option = get_field("graph_option", $moderator_note->ID); ?>
			<?php $current_user_id = get_current_user_id(); ?>
			<?php if ($related_user == $current_user_id) { ?>
				<div class="mod_note_wrapper">
					<h2 style="vertical-align: middle;font-size: 2.3em;"><i class="fas fa-thumbtack"></i> Let’s review your sleep.</h2>
					<h3><?php echo get_the_title( $moderator_note->ID ); ?></h3>
					<?php echo $moderator_note->post_content; ?>
				</div>
				<?php if ($graph_option) { ?>
					<div class="mod_graph_wrapper">
						<h2>Sleep Diary Tracking</h2><!-- NOTE TO TYLER: THESE ARE ALL STILL A LITTLE BROKEN -->
						<?php $sleep_efficiency = ('sleep_efficiency' == get_field('graph_option', $moderator_note->ID)); ?>
						<?php $sleep_onset_latency = ('sleep_onset_latency' == get_field('graph_option', $moderator_note->ID)); ?>
						<?php $wake_after_sleep_onset = ('wake_after_sleep_onset' == get_field('graph_option', $moderator_note->ID)); ?>
						<?php $total_sleep_time = ('total_sleep_time' == get_field('graph_option', $moderator_note->ID)); ?>
						<?php $sleep_quality_rating = ('sleep_quality_rating' == get_field('graph_option', $moderator_note->ID)); ?>
						<?php if ($sleep_efficiency) { ?>
							<?php echo do_shortcode( '[frm-graph fields="332" type="line" title="Sleep Efficiency" title_size="20" title_bold="1" title_color="#333" width="100%" x_title="Date of Entries" is_stacked="0" y_title="Sleep Efficiency Calculation" x_slanted_text="0" data_type="total" x_axis="created_at" user_id="'.$current_user_id.'"]' ); ?>
						<?php } elseif ($sleep_onset_latency) { ?>
							<?php echo do_shortcode( '[frm-graph fields="224" type="line" title="Sleep Onset Latency" title_size="20" title_bold="1" title_color="#333" width="100%" x_title="Date of Entries" is_stacked="0" y_title="Time to Fall Asleep" x_slanted_text="0" data_type="total" x_axis="created_at" user_id="'.$current_user_id.'"]' ); ?>
						<?php } elseif ($wake_after_sleep_onset) { ?>
							<?php echo do_shortcode( '[frm-graph fields="226" type="line" title="Wake After Sleep Onset" title_size="20" title_bold="1" title_color="#333" width="100%" x_title="Date of Entries" is_stacked="0" y_title="Time Awake in the Middle of the Night" x_slanted_text="0" data_type="total" x_axis="created_at" user_id="'.$current_user_id.'"]' ); ?>
						<?php } elseif ($total_sleep_time) { ?>
							<?php echo do_shortcode( '[frm-graph fields="233" type="line" title="Total Sleep Time" title_size="20" title_bold="1" title_color="#333" width="100%" x_title="Date of Entries" is_stacked="0" y_title="Total Time Asleep (Minutes)" x_slanted_text="0" data_type="total" x_axis="created_at" user_id="'.$current_user_id.'"]' ); ?>
						<?php } elseif ($sleep_quality_rating) { ?>
							<?php echo do_shortcode( '[frm-graph fields="235" type="line" title="Sleep Quality Rating" title_size="20" title_bold="1" title_color="#333" width="100%" x_title="Date of Entries" is_stacked="0" y_title="Quality of Sleep Rating" x_slanted_text="0" data_type="total" x_axis="created_at" user_id="'.$current_user_id.'"]' ); ?>
						<?php } ?>
					</div>
				<?php } ?>

			<?php } ?> 
	
        <?php } ?> 
 
    <?php endforeach; ?>
<?php wp_reset_postdata(); ?>
<?php endif; ?>
