<?php get_header(); ?>

<section id="cat" class="content-area container">

	<?php 
		$term =	$wp_query->queried_object;
		$term_name = $term->name;
		$term_name ? $term_name : 'Neff Events near you';
	?>

	<?php include_module('header', array(
		'page_id' => $page_id,
		'title' => $term_name
	)); ?>		

	<div class="section">

	    <?php 
		    global $wp_query;
			$args = array_merge( $wp_query->query_vars, array( 
	           'meta_key' => 'event_start_date', //name of custom field
	           'orderby' => 'meta_value_num', 
	           'order' => 'ASC'
			) );
			query_posts( $args );
		?>  	

		<?php if ( have_posts() ) : ?>
		    <div class="event-list">
		    	<ul>
					<?php while ( have_posts() ) : the_post(); ?>
						<?php 
							$image_size = array('width' => 206, 'height' => 186);
							$image_url = get_post_thumbnail_src($image_size);		
						?>			    								
			    		<li>
			    			<?php if($image_url): ?>
					    		<img src="<?php echo $image_url; ?>" alt="" class="image">
					    	<?php endif; ?>
					    	<a href="<?php the_permalink(); ?>"><h2><?php the_title(); ?></h2></a>
					    	<p>
					    		<?php 
									$date = DateTime::createFromFormat('Ymd', get_field('event_start_date'));
									$dateto = DateTime::createFromFormat('Ymd', get_field('event_end_date'));
					    		 ?>
					    		<span><strong>City: </strong><?php the_field('location'); ?></span>	    		
					    		<span><strong>Date: </strong><?php echo $date->format('d-m-Y'); ?><?php if(get_field('event_end_date')): ?> - <?php echo $dateto->format('d-m-Y'); ?><?php endif; ?></span>	    		
					    		<span><strong>Time: </strong><?php the_field('event_time'); ?></span>
					    		<span><strong>Category: </strong>
									<?php
										$terms = get_the_terms($post->ID, 'event_category' );
										if ($terms && ! is_wp_error($terms)) :
											$term_slugs_arr = array();
											foreach ($terms as $term) {
												$name = $term->name;
												$name = str_replace(array('[sup]', '[/sup]'), array('<sup>', '</sup>'), $name);
											    $term_slugs_arr[] = $name;
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
		<?php endif; ?>
	</div>
</section>

<?php get_footer(); ?>
