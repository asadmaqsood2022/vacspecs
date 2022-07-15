<?php
/**
 * The template for the home (front) page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#front-page-display
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since 1.0.0
 */

add_action('wp_head', function(){
    
   //You'll probably need this for your webp/nowebp logic :)
   
    
});

get_header();

 inet_page_builder_modules();


get_footer();