<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package neff-events
 * @since neff-events 1.0
 */
?>
	</div><!-- #main .site-main -->
	
	<footer id="footer" class="site-footer" role="contentinfo">
		<div class="top">
	</footer><!-- #footer .site-footer -->
</div><!-- #wrap -->

<?php wp_footer(); ?>


<div id="fb-root"></div>
    <script type="text/javascript" src="https://connect.facebook.net/en_US/all.js"></script> 
    <script type="text/javascript">

    FB.init({
        appId: '730943577049540', 
        status: true, 
        cookie: true, 
        xfbml: true
    });

	FB.Canvas.setSize({height:700});
	setTimeout("FB.Canvas.setAutoGrow()",500); 
    </script>


</body>
</html>