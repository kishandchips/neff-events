<?php
	$page_id = get_field('events_page', 'options');
	get_header(); 
?>
<section id="search-results">

	<?php include_module('header', array(
		'page_id' => '',
		'title' => 'Search'
	)); ?>	

	<div class="section">

			<?php if ( have_posts() ) : ?>
			    <div class="event-list">
			    	<ul>
						<?php while ( have_posts() ) : the_post(); ?>
							<?php 
								$image_size = array('width' => 206, 'height' => 186);
								$image_url = get_post_thumbnail_src($image_size);		
							?>			    								
				    		<li>
						    	<img src="<?php echo $image_url; ?>" alt="" class="image">
						    	<a href="<?php the_permalink(); ?>"><h2><?php the_title(); ?></h2></a>
						    	<p>
						    		<span><strong>City: </strong><?php the_field('location'); ?></span>	    		
						    		<span><strong>Date: </strong><?php the_field('event_start_date'); ?><?php if(get_field('event_end_date')): ?> - <?php the_field('event_end_date'); ?><?php endif; ?></span>	    		
						    		<span><strong>Time: </strong><?php the_field('event_time'); ?></span>
						    		<span><strong>Category: </strong>
										<?php
											$terms = get_the_terms($post->ID, 'event_category' );
											if ($terms && ! is_wp_error($terms)) :
												$term_slugs_arr = array();
												foreach ($terms as $term) {
												    $term_slugs_arr[] = $term->name;
												}
											endif;
											echo implode(", ", $term_slugs_arr);
										?>	    		
						    		</span>
						    		<span class="excerpt"><?php echo get_excerpt(100); ?></span>
						    	</p>
						    	<?php if(get_field('event_external_url')): ?>
							    	<p>
							    		<a class="external" href="http://<?php the_field('event_external_url'); ?>" target="_blank"><?php the_field('event_external_url'); ?></a>
							    	</p>
					   			<?php endif; ?>
				    		</li>
						<?php endwhile; ?>
			    	</ul>
			    </div>		
			<?php include_module('pagination'); ?>	
			<a class="back-btn" onclick="window.history.back();"><?php _e('Back'); ?></a>	
			<?php else: ?>		
				<h1 class="noposts">Sorry, No posts found for Search : <?php the_search_query(); ?></h1>
			<?php endif; ?>

	</div>
</section>
<?php get_footer(); ?>