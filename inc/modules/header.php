<?php 
	$page_id = ( !empty($page_id) ) ? $page_id : null;
	$title = ( !empty($title) ) ? $title : get_field('header_title', $page_id );

	$image_src = get_field('header_image', $page_id);
	$image_size = array('width' => 810, 'height' => 270);
	$image = bfi_thumb($image_src, $image_size );
 ?>
<div id="header" <?php if($image): ?>style="background: url(<?php echo $image; ?>) center top no-repeat"<?php endif; ?>>
	<h1 class="site-title"><?php echo $title; ?></h1>
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