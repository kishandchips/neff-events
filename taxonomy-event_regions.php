<?php get_header(); ?>

<section id="cat" class="content-area container">

	<?php _e('TAX REgions'); ?>

		<?php
			if ( have_posts() ) :
				// Start the Loop.
				while ( have_posts() ) : the_post(); ?>

				<li>
				<a href="<?php the_permalink(); ?>">
					<?php the_title(); ?>
				</a>
				</li>
					
				<?php endwhile;

			else :

				echo 'no posts found';
			endif;
		?>
</section>

<?php get_footer(); ?>
