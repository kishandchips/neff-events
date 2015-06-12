<?php

$page_id = get_field('schools_page', 'options');

get_header(); 
?>
<section id="schools">

	<?php include_module('header', array(
		'page_id' => $page_id
	)); ?>	

	<div class="section">

	<?php 
		$taxonomy = 'event_schools';
		$args = array(
		    'orderby'           => 'name', 
		    'order'             => 'ASC',
		    'hide_empty'        => false,
		);		
		$tax_terms = get_terms($taxonomy, $args);
	?>
	<?php if($tax_terms): ?>
		<ul class="school-list">
		<?php foreach ($tax_terms as $tax_term): ?>
			<li>
				<?php
					$taxonomy = $tax_term->taxonomy;
					$term_id = $tax_term->term_id; 		
					$tax = $taxonomy . '_' . $term_id;
					$thumbnail_src = get_field('school_image', $tax);
					$thumbnail_size = array('width' => 304, 'height' => 304);
					$thumbnail = bfi_thumb($thumbnail_src, $thumbnail_size );
					$term_link = get_term_link( $tax_term );
					$location = $thumbnail_src = get_field('location', $tax);
					$description = $tax_term->description;
					$description = substr($description, 0, 120)."...";				
				?>

				<?php if($thumbnail): ?>
					<a class="thumbnail" href="<?php echo $term_link; ?>">
						<div class="image">
							<img src="<?php echo $thumbnail; ?>" title="<?php echo $tax_term->name; ?>" alt="<?php echo $tax_term->name; ?>">
						</div>			
					</a>
				<?php endif; ?>
				<div class="desc">
					<h2 class="title"><a href="<?php echo $term_link; ?>"><?php echo $tax_term->name; ?></a></h2>
					<div class="location"><?php echo $location; ?></div>
					<p><?php echo $description; ?></p>
				</div>
			</li>
		<?php endforeach; ?>
		</ul>
	<?php endif; ?>


	</div>
</section>
<?php get_footer(); ?>
