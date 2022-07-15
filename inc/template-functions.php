<?php


function inet_custom_logo( $blog_id = 0 ) {
    	
	$html          = '';
    $switched_blog = false;
 
    if ( is_multisite() && ! empty( $blog_id ) && get_current_blog_id() !== (int) $blog_id ) {
        switch_to_blog( $blog_id );
        $switched_blog = true;
    }
 
    $custom_logo_id = get_theme_mod( 'custom_logo' );
 
    // We have a logo. Logo is go.
    if ( $custom_logo_id ) {
		
        $custom_logo_attr = array(
            'class' => 'logo nolazy',
        );
 
        /*
         * If the logo alt attribute is empty, get the site title and explicitly
         * pass it to the attributes used by wp_get_attachment_image().
         */
        $image_alt = get_post_meta( $custom_logo_id, '_wp_attachment_image_alt', true );
        if ( empty( $image_alt ) ) {
            $custom_logo_attr['alt'] = get_bloginfo( 'name', 'display' );
        }
 
        /*
         * If the alt attribute is not empty, there's no need to explicitly pass
         * it because wp_get_attachment_image() already adds the alt attribute.
         */
        $html = sprintf(
            '<a href="%1$s" rel="home">%2$s</a>',
            esc_url( home_url( '/' ) ),
            wp_get_attachment_image( $custom_logo_id, 'full', false, $custom_logo_attr )
        );
    } elseif ( is_customize_preview() ) {
        // If no logo is set but we're in the Customizer, leave a placeholder (needed for the live preview).
        $html = sprintf(
            '<a href="%1$s" style="display:none;"><img class="custom-logo"/></a>',
            esc_url( home_url( '/' ) )
        );
    }
 
    if ( $switched_blog ) {
        restore_current_blog();
    }
	
	return $html;
}




/**
 * Functions which enhance the theme by hooking into WordPress
 */
function lightspeed_nav_menu_link_attributes( $atts, $item, $args, $depth ) {

	// Add [aria-haspopup] and [aria-expanded] to menu items that have children
	$item_has_children = in_array( 'menu-item-has-children', $item->classes );
	if ( $item_has_children ) {
		$atts['aria-haspopup'] = 'true';
		$atts['aria-expanded'] = 'false';
	}

	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'lightspeed_nav_menu_link_attributes', 10, 4 );




/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function lightspeed_body_classes( $classes ) {

	if ( is_singular() ) {
		// Adds `singular` to singular pages.
		$classes[] = 'singular';
	} else {
		// Adds `hfeed` to non singular pages.
		$classes[] = 'hfeed';
	}
	
	return $classes;
}
add_filter( 'body_class', 'lightspeed_body_classes' );



/**
 * Adds custom class to the array of posts classes.
 */
function lightspeed_post_classes( $classes, $class, $post_id ) {
	$classes[] = 'entry';
	return $classes;
}
add_filter( 'post_class', 'lightspeed_post_classes', 10, 3 );


/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function lightspeed_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'lightspeed_pingback_header' );

/**
 * Changes comment form default fields.
 */
function lightspeed_comment_form_defaults( $defaults ) {
	$comment_field = $defaults['comment_field'];

	// Adjust height of comment form.
	$defaults['comment_field'] = preg_replace( '/rows="\d+"/', 'rows="5"', $comment_field );
	return $defaults;
}
add_filter( 'comment_form_defaults', 'lightspeed_comment_form_defaults' );

/**
 * Filters the default archive titles.
 */
function lightspeed_get_the_archive_title() {
	if ( is_category() ) {
		$title = __( 'Category Archives: ', 'lightspeed' ) . '<span class="page-description">' . single_term_title( '', false ) . '</span>';
	} elseif ( is_tag() ) {
		$title = __( 'Tag Archives: ', 'lightspeed' ) . '<span class="page-description">' . single_term_title( '', false ) . '</span>';
	} elseif ( is_author() ) {
		$title = __( 'Author Archives: ', 'lightspeed' ) . '<span class="page-description">' . get_the_author_meta( 'display_name' ) . '</span>';
	} elseif ( is_year() ) {
		$title = __( 'Yearly Archives: ', 'lightspeed' ) . '<span class="page-description">' . get_the_date( _x( 'Y', 'yearly archives date format', 'lightspeed' ) ) . '</span>';
	} elseif ( is_month() ) {
		$title = __( 'Monthly Archives: ', 'lightspeed' ) . '<span class="page-description">' . get_the_date( _x( 'F Y', 'monthly archives date format', 'lightspeed' ) ) . '</span>';
	} elseif ( is_day() ) {
		$title = __( 'Daily Archives: ', 'lightspeed' ) . '<span class="page-description">' . get_the_date() . '</span>';
	} elseif ( is_post_type_archive() ) {
		$title = __( 'Post Type Archives: ', 'lightspeed' ) . '<span class="page-description">' . post_type_archive_title( '', false ) . '</span>';
	} elseif ( is_tax() ) {
		$tax = get_taxonomy( get_queried_object()->taxonomy );
		/* translators: %s: Taxonomy singular name */
		$title = sprintf( esc_html__( '%s Archives:', 'lightspeed' ), $tax->labels->singular_name );
	} else {
		$title = __( 'Archives:', 'lightspeed' );
	}
	return $title;
}
add_filter( 'get_the_archive_title', 'lightspeed_get_the_archive_title' );



/**
 * Determines if post thumbnail can be displayed.
 */
function lightspeed_can_show_post_thumbnail() {
	return apply_filters( 'lightspeed_can_show_post_thumbnail', ! post_password_required() && ! is_attachment() && has_post_thumbnail() );
}


/**
 * Returns the size for avatars used in the theme.
 */
function lightspeed_get_avatar_size() {
	return 60;
}

