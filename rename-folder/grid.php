<div id="webdrafter-grid">
		<?php

        // check if the flexible content field has rows of data
        if( have_rows('subpage_page_layout') ):
         
             // loop through the rows of data
            while ( have_rows('subpage_page_layout') ) : the_row();
         
                if( get_row_layout() == 'full_width_row' ) { ?>
         
                    <div class="first twelvecol clearfix">
                    <?php the_sub_field('full_width_content'); ?>
                    </div>
                
                <?php }
                if( get_row_layout() == 'two_column_row' ) { ?>
         
                    <div class="clearfix">
                    <div class="first sixcol clearfix">
                    <?php the_sub_field('two_column_left'); ?>
                    </div> 
                    <div class="sixcol clearfix">
                    <?php the_sub_field('two_column_right'); ?>
                    </div>
                    </div>
         
                <?php }
                if( get_row_layout() == 'eight-four_row' ) { ?>
         
                    <div class="first eightcol clearfix">
                    <?php the_sub_field('eight_column'); ?>
                    </div>
                    <div class="fourcol clearfix">
                    <?php the_sub_field('four_column'); ?>
                    </div>
         
                <?php }
                if( get_row_layout() == 'three_column_row' ) { ?>
         
                    <div class="first fourcol clearfix">
                    <?php the_sub_field('three_column_left'); ?>
                    </div>
                    <div class="fourcol clearfix">
                    <?php the_sub_field('three_column_middle'); ?>
                    </div>
                    <div class="fourcol clearfix">
                    <?php the_sub_field('three_column_right'); ?>
                    </div>
         
                <?php }
                if( get_row_layout() == 'four_column_row' ) { ?>
         
                    <div class="first threecol clearfix">
                    <?php the_sub_field('four_column_left'); ?>
                    </div>
                    <div class="threecol clearfix">
                    <?php the_sub_field('four_column_middle_left'); ?>
                    </div>
                    <div class="threecol clearfix">
                    <?php the_sub_field('four_column_middle_right'); ?>
                    </div>
                    <div class="threecol clearfix">
                    <?php the_sub_field('four_column_right'); ?>
                    </div>
         
                <?php }
                if( get_row_layout() == 'five_column_row' ) { ?>
         
                    <div class="first two_5col clearfix">
                    <?php the_sub_field('five_column_left'); ?>
                    </div>
                    <div class="two_5col clearfix">
                    <?php the_sub_field('five_column_middle_left'); ?>
                    </div>
                    <div class="two_5col clearfix">
                    <?php the_sub_field('five_column_middle'); ?>
                    </div>
                    <div class="two_5col clearfix">
                    <?php the_sub_field('five_column_middle_right'); ?>
                    </div>
                    <div class="two_5col clearfix">
                    <?php the_sub_field('five_column_right'); ?>
                    </div>
         
                <?php }
                if( get_row_layout() == 'six_column_row' ) { ?>
         
                    <div class="first twocol clearfix">
                    <?php the_sub_field('six_column_left_left'); ?>
                    </div>
                    <div class="twocol clearfix">
                    <?php the_sub_field('six_column_left'); ?>
                    </div>
                    <div class="twocol clearfix">
                    <?php the_sub_field('six_column_middle_left'); ?>
                    </div>
                    <div class="twocol clearfix">
                    <?php the_sub_field('six_column_middle_right'); ?>
                    </div>
                    <div class="twocol clearfix">
                    <?php the_sub_field('six_column_right'); ?>
                    </div>
                    <div class="twocol clearfix">
                    <?php the_sub_field('six_column_right_right'); ?>
                    </div>
         
                <?php }
                
            endwhile;
         
        else :
         
            // no layouts found
         
        endif;
         
        ?>
</div>