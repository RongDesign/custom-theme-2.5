<div id="blog_sidebar" class="sidebar fourcol last clearfix" role="complementary">

<!---------------------------
DEFAULT PLUGINS FOR WEBDRAFTER.COM STYLE BLOGS
This area must be handed coded to assure their inclusion in every theme. <br>
Anything after Catagories and Recent Posts in controlled in Appearance > Widgets


<div class="category-links clearfix"> 
    <h4 class="widgettitle">Looking For More Information?</h4>
    <p>Here Are Topic We Have Written About</p>
    <ul>
        <?php //wp_list_categories('hide_empty=0&title_li=&order=ASC&use_desc_for_title=0'); ?>
    </ul>
</div>

    <div class="recent-post-links clearfix">
        <h4 class="widgettitle">What Have We Talked About?</h4>
        <p>Our Five Most Recent Articles</p>
        <ul>
            <?php
            //$args = array( 'numberposts' => '5' );
            //$recent_posts = wp_get_recent_posts( $args );
            //foreach( $recent_posts as $recent ){
           	//echo '<li><a href="' . get_permalink($recent["ID"]) . '" >' .   $recent["post_title"].'</a></li> ';
            //}
            ?> 
        </ul>
    </div>
----------------------------->                
<!------------------------------------------------------
CONTROL THIS THROUGH APPEARANCE > WIDGETS
Most personally installed plugins will have to be activated by all them to this sidebar.
------------------------------------------------------->

	<?php if ( is_active_sidebar( 'blog_sidebar' ) ) : ?>
    
        <?php dynamic_sidebar( 'blog_sidebar' ); ?>
    
    <?php else : ?>
    
    <?php endif; ?>

</div>