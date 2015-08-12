<?php 
$page_id = $post->ID;
get_header(); ?>
<div id="single" class="container">
	<?php 
		$title = ( get_field('header_title', $page_id ) ) ? get_field('header_title', $page_id ) : get_the_title( $page_id ); 
		$logotype = ( get_field('header_logo_type', $page_id ) ) ? get_field('header_logo_type', $page_id ) : 'none';
	?>
	<?php include_module('header', array(
		'page_id' => $page_id,
		'title' => $title,
		'logotype' => $logotype
	)); ?>	

	<?php while ( have_posts() ) : the_post(); ?>
		<div class="section">
			<div class="content">
				<div class="wrap">
					<div class="left"></div>
					<div class="right"></div>
					<?php 
						$image_size = array('width' => 247, 'height' => 361);
						$image_url = get_post_thumbnail_src($image_size);		
					?>			    								

					<?php the_title( '<h1 class="title">', '</h1>'); ?>
					<img src="<?php echo $image_url; ?>" alt="" class="image">
					<div class="inner">
						<?php the_content(); ?>
					</div>
				</div>
			</div>

			<?php if(get_field('quote_text')): ?>
				<div class="quote">
					<div class="inner">
						<span class="quote-text">
							<?php the_field('quote_text'); ?>		
						</span>
						<span class="author">
							<b><?php the_field('quote_author'); ?></b>
						</span>
						<span class="rank">
							<?php the_field('quote_author_rank'); ?>		
						</span>
					</div>				
				</div>
			<?php endif; ?>

			
			<?php $terms = get_the_terms($post->ID, 'event_schools' );
			if ($terms && ! is_wp_error($terms)) : ?>
				<div class="tax-school">
						<?php $term_slugs_arr = array();
						foreach ($terms as $term) { ?>
							<?php
								$taxonomy = $term->taxonomy;
								$term_id = $term->term_id; 		
								$thumbnail_src = get_field('school_image', $taxonomy . '_' . $term_id);
								$thumbnail_size = array('width' => 160, 'height' => 180);
								$thumbnail = bfi_thumb($thumbnail_src, $thumbnail_size );
								$term_link = get_term_link( $term );
				    			$description = $term->description;
								$description = substr($description, 0, 110)."...";				
							?>
							
					    	<img src="<?php echo $thumbnail; ?>" alt="" class="image">
					    	<div class="inner">
						    	<a href="<?php echo $term_link; ?>"><h2><?php echo $term->name; ?></h2></a>
						    	<p>
						    		<span class="excerpt"><?php echo $description; ?></span>
						    	</p>
						    	<p>
						    		<a class="circle-arrow-btn" href="<?php echo $term_link; ?>"><?php _e('Find out More'); ?></a>
						    	</p>
					    	</div>
						<?php } ?>
				</div>	
			<?php endif; ?>					
			
			<a class="back-btn" onclick="window.history.back();"><?php _e('Back'); ?></a>					

	<?php endwhile; // end of the loop. ?>
	<?php //include_module('featured-posts'); ?>
</div><!-- #single -->

<?php get_footer(); ?>
