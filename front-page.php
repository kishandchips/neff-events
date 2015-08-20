<?php 
$page_id = 19;

get_header(); 
?>
<section id="front-page">

	<?php include_module('header', array(
		'page_id' => $page_id
	)); ?>		


	<div class="section">

	<?php 
		// List EVENT Categories, and their description
		$taxonomy = 'event_category';
		$args = array(
		    'orderby'           => 'date', 
		    'order'             => 'DESC',
		    'hide_empty'        => false, 
		    'number'            => 4, 
		);		
		$tax_terms = get_terms($taxonomy, $args);
	?>
	<?php if($tax_terms): ?>
		<ul class="categories">
		<?php foreach ($tax_terms as $tax_term): ?>
			<li>
				<div class="wrepp">
					<?php
						$taxonomy = $tax_term->taxonomy;
						$term_id = $tax_term->term_id; 		
						$thumbnail_src = get_field('category_image', $taxonomy . '_' . $term_id);
						$thumbnail_size = array('width' => 206, 'height' => 137);
						$thumbnail = bfi_thumb($thumbnail_src, $thumbnail_size );
						$term_link = get_term_link( $tax_term );
						$name = $tax_term->name;
						$title = str_replace(array('[sup]', '[/sup]'), array('<sup>', '</sup>'), $name);

					?>
					<h2 class="title"><?php echo $title; ?></h2>
					<img src="<?php echo $thumbnail; ?>" title="<?php echo $tax_term->name; ?>">
					<p><?php echo $tax_term->description; ?></p>
				</div>
					<a class="" href="<?php echo $term_link; ?>" title="<?php sprintf( __( "View all posts in %s" ), $tax_term->name ); ?>"></a>
			</li>
		<?php endforeach; ?>
		</ul>
	<?php endif; ?>


	<?php 
		// List Selected Featured EVENT
		$featured_event = get_field('featured_event', $page_id);

		if( $featured_event ): 
			$post = $featured_event;
			setup_postdata( $post ); 
			$image_size = array('width' => 206, 'height' => 186);
			$image_url = get_post_thumbnail_src($image_size);		
	?>
    <div class="event-list">
    	<ul>
    		<li>
    			<?php if ($image_url): ?>
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
								    $term_slugs_arr[] = $term->name;
								}
							endif;
							echo $term_slugs_arr[0];
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
    	</ul>
    </div>
    <?php wp_reset_postdata(); ?>
	<?php endif; ?>

	<?php include_module('search'); ?>

	<?php include_module('find_a_dealer'); ?>
	</div>
</section>
<?php get_footer(); ?>
