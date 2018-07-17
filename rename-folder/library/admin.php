<?php
/*
This file handles the admin area and functions.
You can use this file to make changes to the
dashboard. Updates to this page are coming soon.
It's turned off by default, but you can call it
via the functions file.

Produced by: WebDrafter.com @webdrafter
URL: http://www.webdrafter.com/

Base on Bones Theme by: Eddie Machado
URL: http://themble.com/

*/

/************* CUSTOM LOGIN PAGE *****************/

// calling your own login css so you can style it

//Updated to proper 'enqueue' method
//http://codex.wordpress.org/Plugin_API/Action_Reference/login_enqueue_scripts
function webdraftertheme_login_css() {
	wp_enqueue_style( 'webdraftertheme_login_css', get_template_directory_uri() . '/library/css/login.css', false );
}

// changing the logo link from wordpress.org to your site
function webdraftertheme_login_url() {  return home_url(); }

// changing the alt text on the logo to show your site name
function webdraftertheme_login_title() { return get_option( 'blogname' ); }

// calling it only on the login page
add_action( 'login_enqueue_scripts', 'webdraftertheme_login_css', 10 );
add_filter( 'login_headerurl', 'webdraftertheme_login_url' );
add_filter( 'login_headertitle', 'webdraftertheme_login_title' );


/************* CUSTOMIZE ADMIN *******************/

/*
I don't really recommend editing the admin too much
as things may get funky if WordPress updates. Here
are a few funtions which you can choose to use if
you like.
*/

// Custom Backend Footer
function webdraftertheme_custom_admin_footer() {
	_e( '<span id="footer-thankyou">Developed for <a href="http://www.[CLIENT DOMAIN].com" target="_blank">[CLIENT NAME]</a></span>. Built by <a href="http://www.webdrafter.com" target="_blank">WebDrafter.com</a>.', 'webdraftertheme' );
}

// adding it to the admin area
add_filter( 'admin_footer_text', 'webdraftertheme_custom_admin_footer' );

?>