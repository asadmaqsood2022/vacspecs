<?php
/*
*  Let's you unload all the script + style handles that plugins enqueue globally.
*
*/


#Show enqueued scripts/styles for dequeuing if needed
#add_action( 'wp_footer', 'show_enqueued_scripts_styles', 99999);
function show_enqueued_scripts_styles() {
    
    global $wp_scripts, $wp_styles;
    
    echo "<div style='border:1px solid blue; background:#D7EBFF; padding:2em; color:black;'>";
    
        echo 'SCRIPT Handles:'. "<br><br>";
           foreach($wp_scripts->queue as $handle) echo $handle . "<br>";

        echo 'STYLE Handles:'. "<br><br>";
           foreach($wp_styles->queue as $handle) echo $handle . "<br>";

    echo "</div>";
    
}


function inet_dequeue_descript() {
	
	
	/* Globals */	
	$descript = array();
	$destyle = array();

	/* Any specific page, or post-type logic should go here */
	if (is_front_page()) {
		
        
        $descript = array('');
        $destyle = array('');
        
	}
	

		
    if (!empty($descript))
    foreach($descript as $src) {
        wp_deregister_script($src);
        wp_dequeue_script($src);
    }
    
    if (!empty($destyle))
    foreach($destyle as $src) {
        wp_deregister_style($src);
        wp_dequeue_style($src) ;
    }
    	
}
add_action( 'wp_enqueue_scripts', 'inet_dequeue_descript', 99999 );



?>