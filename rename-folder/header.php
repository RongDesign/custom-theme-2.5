<!doctype html>

<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->

	<head>
		<meta charset="utf-8">

		<?php // Google Chrome Frame for IE ?>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<title><?php wp_title(''); ?></title>

		<?php // mobile meta (hooray!) ?>
		<meta name="HandheldFriendly" content="True">
		<meta name="MobileOptimized" content="320">
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        
		<?php // icons & favicons (http://www.favicon-generator.org/) ?>
        <link rel="apple-touch-icon" sizes="57x57" href="<?php echo get_template_directory_uri(); ?>/library/images/favicons/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="<?php echo get_template_directory_uri(); ?>/library/images/favicons/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="<?php echo get_template_directory_uri(); ?>/library/images/favicons/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="<?php echo get_template_directory_uri(); ?>/library/images/favicons/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="<?php echo get_template_directory_uri(); ?>/library/images/favicons/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="<?php echo get_template_directory_uri(); ?>/library/images/favicons/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="<?php echo get_template_directory_uri(); ?>/library/images/favicons/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="<?php echo get_template_directory_uri(); ?>/library/images/favicons/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_template_directory_uri(); ?>/library/images/favicons/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo get_template_directory_uri(); ?>/library/images/favicons/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="<?php echo get_template_directory_uri(); ?>/library/images/favicons/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="<?php echo get_template_directory_uri(); ?>/library/images/favicons/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="<?php echo get_template_directory_uri(); ?>/library/images/favicons/favicon-16x16.png">
        <link rel="manifest" href="<?php echo get_template_directory_uri(); ?>/library/images/favicons/manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri(); ?>/library/images/favicons/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">
 		<!--[if IE]>
			<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/library/images/favicons/favicon.ico">
		<![endif]-->

		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">


		<?php // wordpress head functions ?>
		<?php wp_head(); ?>
		<?php // end of wordpress head ?> 
        
        <style>
				#container {
					padding-bottom:
					<?php 
						$num1 = get_field('default_footer_height','options');
						$num2 = 10; 
						$total = $num1+$num2;
						echo $total.'px';
					?>
					;
				}
				.footer {
					height:<?php echo get_field('default_footer_height','options').'px'; ?>; 
				}
		</style>
	</head>

	<body <?php body_class(); ?>>
    
        <nav role="navigation" id="mobile-menu-wrap">
        	
            <a href="<?php echo home_url(); ?>"><img id="logo" src="<?php the_field('logo','options'); ?>" alt="<?php wp_title(''); ?>"/></a>
        	
            <p id="phone-link"><a href="tel:<?php the_field('phone_number','options'); ?>">Call Today!<br> <?php the_field('phone_number','options'); ?></a></p>
            
        	<div class="menu-toggle-button"><a id="menu-toggle" class="anchor-link icon-bars">Menu</a></div>
            
			<?php webdraftertheme_mobile_nav(); ?>
            
        </nav>    

    <div id="container">
    
        <div id="background-main">

			<header class="header" role="banner">

				<div id="inner-header" class="wrap clearfix">

					<div class="eightcol first">
                        <a href="<?php echo home_url(); ?>">
                            <img id="logo" src="<?php the_field('logo','options'); ?>" alt=""/>
                        </a>
                    </div>
                    <div class="fourcol contact-header last">
                    	<?php dynamic_sidebar( 'social_media_sidebar' ); ?>
                    	<p><?php the_field('header_slogan','options'); ?><br>
						<span>Ph: <?php the_field('phone_number','options'); ?></span><br>
						<?php the_field('hours','options'); ?></p>
                    </div>

                </div>
                
                <div id="background-navigation">
                
                    <div class="wrap clearfix">
        
                        <nav role="navigation">
                            <?php webdraftertheme_main_nav(); ?> 
						</nav>
        
                    </div>
                    
                </div>

			</header>
