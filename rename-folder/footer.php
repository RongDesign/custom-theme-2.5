		</div> <!-- end #background-main -->
            
			<footer class="footer clearfix" role="contentinfo">

				<div id="inner-footer" class="wrap clearfix">
                
                    <div class="fivecol clearfix first">
                    
                    	<h3>Recent Posts</h3>
                    	<ul>
						<?php $the_query = new WP_Query( 'showposts=1' ); ?>
                        <?php while ($the_query -> have_posts()) : $the_query -> the_post(); ?>
                            <li><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></li>
                            <li><a href="<?php the_permalink() ?>"><?php the_date(); ?> | <?php the_author(); ?></a></li>
                            <li><?php the_excerpt(__('(more…)')); ?></li>
                        <?php endwhile;?>
                        </ul>
    
                    </div>
                
                    <div class="threecol clearfix">
    
                        <h3>Sitemap</h3>
						<nav>
						<?php webdraftertheme_footer_links(); ?>
                        </nav>
    
                    </div>
                
                    <div class="fourcol clearfix">
                    
                        <h3>Connect With Us</h3>
                    	<?php dynamic_sidebar( 'social_media_sidebar' ); ?>
    
                    </div>
                
                </div>
                
				<div class="author-credits wrap clearfix">
                
	                <div class="divider clearfix"></div> 

					<!--nav role="navigation">
							<?php //webdraftertheme_footer_links(); ?>
					</nav-->
                    
					<p class="source-org copyright">
                    	&copy; <?php echo date('Y'); ?> <?php bloginfo( 'name' ); ?>
                   	</p>
					
					<p class="source-org credits">
                   		<a target="_blank" href="http://www.webdrafter.com/" >Website Design &amp; SEO by WebDrafter.com, Inc</a>
                    </p>

				</div>

			</footer>

		</div>

		<?php // all js scripts are loaded in library/webdraftertheme.php ?>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
		<?php wp_footer(); ?>

	</body>

</html>
