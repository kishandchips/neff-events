<div id="search" class="event-list">
<ul>
	<li>
		<h2><?php _e('Search for an Event'); ?></h2>
		<form method="get" class="searchandfilter" id="advanced-searchform" role="search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<input type="hidden" name="s" value="">
			<input type="hidden" name="post_type" value="events" />
			<ul>
				<li>
					<?php // List EVENT Regions
						$taxonomy = 'event_regions';
						$args = array(
						    'orderby'           => 'name', 
						    'order'             => 'ASC',
						    'hide_empty'        => false
						);		
						$tax_terms = get_terms($taxonomy, $args);
					?>		
					<label for="event_regions">Regions</label>
					<select name="event_regions" id="event_regions" class="postform">
						<option value="" selected="selected">All Regions</option>
						<?php if($tax_terms): ?>
							<?php foreach ($tax_terms as $tax_term): ?>
								<option value="<?php echo $tax_term->slug; ?>"><?php echo $tax_term->name; ?></option>
							<?php endforeach; ?>
							</ul>
						<?php endif; ?>				
					</select>			
				</li>

				<li>
					<?php // List EVENT Categories
						$taxonomy = 'event_category';
						$args = array(
						    'orderby'           => 'name', 
						    'order'             => 'ASC',
						    'hide_empty'        => false
						);		
						$tax_terms = get_terms($taxonomy, $args);
					?>
					<label for="event_category">Categories</label>
					<select name="event_category" id="event_category" class="postform">
						<option value="" selected="selected">All Categories</option>
						<?php if($tax_terms): ?>
							<?php foreach ($tax_terms as $tax_term): ?>
								<option value="<?php echo $tax_term->slug; ?>"><?php echo $tax_term->name; ?></option>
							<?php endforeach; ?>
							</ul>
						<?php endif; ?>				
					</select>
				</li>

				<li>
					<input type="hidden" name="search" value="advanced">

					<input class="double-arrow-btn" type="submit" value="Search Events">
				</li>

				<li>
					<label for="fromdate">Date from</label>
					<input type="text" name="fromdate" id="date_timepicker_start" data-beatpicker="true" data-beatpicker-position="['right','*']" data-beatpicker-format="['DD','MM','YYYY'],separator:'/'"/>
				</li>
				<li>
					<label for="todate">Date to</label>
					<input type="text" name="todate" id="date_timepicker_end" data-beatpicker="true">
				</li>
				<li>
					<?php 
						$events_page = get_field('events_page', 'options');
						$events_page_id = $events_page->ID;
					?>
					<a class="double-arrow-btn" href="<?php echo get_permalink($events_page_id); ?>">See all Events</a>
				</li>

			</ul>


			</form>
		</li>	
	</ul>
</div>
