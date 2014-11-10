	<div id="above-footer" class="full-width clear"></div>
	
	<div id="footer-widgets-wrapper" class="full-width">
        <div id="sections" class="footer-widgets clearfix">            
            <div class="footer-widgets-wrap clearfix">        
                <?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer') ) : else : ?>		
                <?php endif; ?>
            </div>
        </div>
	</div>

	<div class="footer full-width">
		<div class="footer-text">
			<div class="footer-text-left">
		    	<?php wp_nav_menu( array( 'theme_location' => 'footer', 'menu_id' => 'nav-footer' ) ); ?>
		    </div>
		    
		    <div class="footer-text-right">
		    	<div class="copyright">
		    	    <a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a>
		    	     &copy; <?php echo date("Y"); ?>
		    	 </div>
		    	 | <span class="credits">Built by <a href="http://artsdigital.co">ArtsDigital.co</a></span>
           | <span class="credits">Crow art by <a href="http://crabscrambly.com">Crab Scrambly</a></span>
		    </div>
		    <div class="clear"></div>
		</div>
	</div>
</div><!-- main wrapper -->

<?php wp_footer(); ?>

</body>
</html>
