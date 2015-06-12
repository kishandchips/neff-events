<?php get_header(); ?>

<section id="school" class="content-area container">

		<?php 
			$term =	$wp_query->queried_object;
			$term_name = $term->name;
			$taxonomy = $term->taxonomy;
			$term_id = $term->term_id; 	
			$tax = 	$taxonomy . '_' . $term_id;

			$thumbnail_src = get_field('school_image', $tax);
			$thumbnail_size = array('width' => 242, 'height' => 242);
			$thumbnail = bfi_thumb($thumbnail_src, $thumbnail_size );

			$header_src = get_field('header_image', $tax);
			$header_size = array('width' => 850, 'height' => 269);
			$header = bfi_thumb($header_src, $header_size );			

			$description = $term->description;
			$content = get_field('content', $tax);
			$contact = get_field('contact_address', $tax);
			$url = get_field('website_address', $tax);

			$logo_src = get_field('school_logo', $tax);
			$logo_size = array('width' => 180);
			$logo = bfi_thumb($logo_src, $logo_size );			
		?>		

		<div id="header" <?php if($header): ?>style="background: url(<?php echo $header; ?>) center top no-repeat"<?php endif; ?>>
			<h1 class="site-title"><?php echo $term_name; ?></h1>
			<nav class="primary">
				<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'clearfix menu', 'container' => '' )); ?>			
				<ul>
					<li>
						<form id="searchform" action="<?php echo home_url( '/' ); ?>" method="get">
						        <input class="inlineSearch" type="text" name="s" value="Search" onblur="if (this.value == '') {this.value = 'Search';}" onfocus="if (this.value == 'Search') {this.value = '';}" />
						        <input type="hidden" name="post_type" value="events" />
						        <button type="submit" class="submit-btn search-btn"></button>
						</form>				
					</li>
				</ul>
			</nav>	
		</div>

		<div class="section">

			<div class="description">
				<?php echo $description; ?>
				<?php 
					$classes = Array('fish-jump', 'ravioli', 'leeks', 'corn');
					$class = $classes[array_rand($classes)];
				 ?>
				<div class="illustration icon icon-<?php echo $class; ?>"></div>
			</div>

			<div class="content">
				<?php if($thumbnail): ?>
					<?php 
						$positions = Array('top', 'middle', 'bottom');
						$position = $positions[array_rand($positions)];
					 ?>					
					<div class="thumbnail <?php echo $position; ?>">
						<div class="image">
							<img src="<?php echo $thumbnail; ?>" alt="">
						</div>
						
					</div>
				<?php endif; ?>


				<?php echo $content; ?>
				<h3 class="events"><?php _e('Events'); ?></h3>
				<a class="circle-arrow-btn events-btn" href="#"><?php echo 'View ' . $term_name . ' Events'; ?></a>
				<?php if ( have_posts() ) : ?>
					<div id="school-events">
						<ul>
							<?php while ( have_posts() ) : the_post(); ?>
								<li>
									<a href="<?php the_permalink(); ?>">
										<?php the_title(); ?>
									</a>
								</li>						
							<?php endwhile; ?>
						</ul>		
					</div>
				<?php endif; ?>
			</div>

			<div class="contact">
				<h3><?php echo 'Contact ' . $term_name;  ?></h3>
				<div class="inner">
					<?php if($contact): ?>
						<p>
							<b><?php echo $term_name;?></b>
							<?php echo $contact; ?> 
						</p>
					<?php endif; ?>
					<?php if($url): ?>
						<a href="http://<?php echo $url; ?>" target="_blank"><?php echo $url; ?></a>
					<?php endif; ?>
				</div>
				<?php if($logo): ?>
					<img  class="school-logo" src="<?php echo $logo; ?>" alt="">
				<?php endif; ?>		

				<?php 
					$classes = Array('ravioli', 'leeks', 'rollpin', 'strainer', 'carrots');
					$class = $classes[array_rand($classes)];
				 ?>
				<div class="illustration icon icon-<?php echo $class; ?>"></div>

			</div>
		</div>
		<a class="back-btn" onclick="window.history.back();"><?php _e('Back'); ?></a>	


</section>

<?php get_footer(); ?>
