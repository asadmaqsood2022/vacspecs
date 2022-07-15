
<?php

 
    //add_theme_support( 'wc-product-gallery-zoom' );
   // add_theme_support( 'wc-product-gallery-lightbox' );
   // add_theme_support( 'wc-product-gallery-slider' );


/**
 * Rename product data tabs
 */
add_filter( 'woocommerce_product_tabs', 'woo_rename_producttabs', 98 );
function woo_rename_producttabs( $tabs ) {

  $tabs['description']['title'] = __( 'Details' );    // Rename the description tab
  

  return $tabs;

}


add_filter( 'woocommerce_product_tabs', 'vaccum_custom_tab' );
 
function vaccum_custom_tab( $tabs ) {
 
  $tabs['vaccum_custom_tab'] = array(
    'title'    => 'Additional Information',
    'callback' => 'vacuum_custom_tab_content', // the function name, which is on line 15
    'priority' => 15,
  );
 
  return $tabs;
 
}
 
function vacuum_custom_tab_content( $slug, $tab ) {
 
  echo '<h2>' . $tab['title'] . '</h2><p>additional info</p>';
 
}


add_filter( 'woocommerce_product_tabs', 'vacuum_custom_tab_key' );
 
function vacuum_custom_tab_key( $tabs ) {
 
  $tabs['vacuum_custom_tab_key'] = array(
    'title'    => 'Key features',
    'callback' => 'vacuum_custom_tab_content_key', // the function name, which is on line 15
    'priority' => 20,
  );
 
  return $tabs;
 
}
 
function vacuum_custom_tab_content_key( $slug, $tab ) {
 
  echo '<h2>' . $tab['title'] . '</h2><p>Key Features content will be here.</p>';
 
}


/**
 * Reorder product data tabs
 */
add_filter( 'woocommerce_product_tabs', 'woo_reorder_tabs', 98 );
function woo_reorder_tabs( $tabs ) {

  
  $tabs['description']['priority'] = 5;      // Description second
  

  return $tabs;
}


// New Product Badge
add_action( 'woocommerce_before_shop_loop_item_title', 'new_product_badge_shop_page', 3 );
          
function new_product_badge_shop_page() {
   global $product;
   $newness_days = 30;
   $created = strtotime( $product->get_date_created() );
   if ( ( time() - ( 60 * 60 * 24 * $newness_days ) ) < $created ) {
      echo '<span class="itsnew onsale">' . esc_html__( 'New', 'woocommerce' ) . '</span>';
   }
}

//Remove Badge
add_filter( 'woocommerce_sale_flash', 'vcs_remove_on_sale_badge' );
 
function vcs_remove_on_sale_badge( $badge_html ){
    return '';
}

//Sale Badge
add_filter( 'woocommerce_sale_flash', 'vcs_change_on_sale_badge', 10, 2 );
 
function vcs_change_on_sale_badge( $badge_html, $post ) {
    return '<span class="onsale">Sale</span>';
}



//woocommerce sale badges
add_action( 'woocommerce_before_shop_loop_item_title', 'vacuum_show_sale_percentage_loop', 25 );
  
function vacuum_show_sale_percentage_loop() {
   global $product;
   if ( ! $product->is_on_sale() ) return;
   if ( $product->is_type( 'simple' ) ) {
      $max_percentage = ( ( $product->get_regular_price() - $product->get_sale_price() ) / $product->get_regular_price() ) * 100;
   } elseif ( $product->is_type( 'variable' ) ) {
      $max_percentage = 0;
      foreach ( $product->get_children() as $child_id ) {
         $variation = wc_get_product( $child_id );
         $price = $variation->get_regular_price();
         $sale = $variation->get_sale_price();
         if ( $price != 0 && ! empty( $sale ) ) $percentage = ( $price - $sale ) / $price * 100;
         if ( $percentage > $max_percentage ) {
            $max_percentage = $percentage;
         }
      }
   }
   if ( $max_percentage > 0 ) echo "<div class='sale-perc'>-" . round($max_percentage) . "%</div>"; 
}



//Recently Viewed Products
  function custom_track_product_view() {
    if ( ! is_singular( 'product' ) ) {
        return;
    }

    global $post;

    if ( empty( $_COOKIE['woocommerce_recently_viewed'] ) )
        $viewed_products = array();
    else
        $viewed_products = (array) explode( '|', $_COOKIE['woocommerce_recently_viewed'] );

    if ( ! in_array( $post->ID, $viewed_products ) ) {
        $viewed_products[] = $post->ID;
    }

    if ( sizeof( $viewed_products ) > 15 ) {
        array_shift( $viewed_products );
    }

    // Store for session only
    wc_setcookie( 'woocommerce_recently_viewed', implode( '|', $viewed_products ) );
}

add_action( 'template_redirect', 'custom_track_product_view', 20 );
 function rc_woocommerce_recently_viewed_products( $atts, $content = null ) {
    // Get shortcode parameters
    extract(shortcode_atts(array(
        "per_page" => '5'
    ), $atts));
    // Get WooCommerce Global
    global $woocommerce;
    // Get recently viewed product cookies data
    $viewed_products = ! empty( $_COOKIE['woocommerce_recently_viewed'] ) ? (array) explode( '|', $_COOKIE['woocommerce_recently_viewed'] ) : array();
    $viewed_products = array_filter( array_map( 'absint', $viewed_products ) );
    // If no data, quit
    if ( empty( $viewed_products ) )
        return __( 'You have not viewed any product yet!', 'rc_wc_rvp' );
    // Create the object
    ob_start();
    // Get products per page
    if( !isset( $per_page ) ? $number = 5 : $number = $per_page )
    // Create query arguments array
    $query_args = array(
                    'posts_per_page' => $number,
                    'no_found_rows'  => 1,
                    'post_status'    => 'publish',
                    'post_type'      => 'product',
                    'post__in'       => $viewed_products,
                    'orderby'        => 'rand'
                    );
    // Add meta_query to query args
    $query_args['meta_query'] = array();
    // Check products stock status
    $query_args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
    // Create a new query
    $r = new WP_Query($query_args);

    // ----
    if (empty($r)) {
      return __( 'You have not viewed any product yet!', 'rc_wc_rvp' );

    }
    echo '<ul class="products">';
    while ( $r->have_posts() ) : $r->the_post(); 
   $url= wp_get_attachment_url( get_post_thumbnail_id($post->ID) );

   ?>

   <!-- //put your theme html loop hare -->
 <?php woocommerce_get_template_part( 'content', 'product' );?>
<!-- end html loop  -->
<?php endwhile; 
 echo '</ul>';?>


    <?php wp_reset_postdata();
    return '<div class="woocommerce columns-5 facetwp-template">' . ob_get_clean() . '</div>';
    // ----
    // Get clean object
    $content .= ob_get_clean();
    // Return whole content
    return $content;
}
// Register the shortcode
add_shortcode("woocommerce_recently_viewed_products", "rc_woocommerce_recently_viewed_products");
 

//Stock Availability 
add_filter( 'woocommerce_get_availability', 'vacuum_display_stock_availability', 1, 2);
 
function vacuum_display_stock_availability( $availability, $_product ) {
	
   global $product;
 
   // Change In Stock Text
    if ( $_product->is_in_stock() ) {
        $availability['availability'] = __('Availability: In Stock', 'woocommerce');
    }
 
    // Change Out of Stock Text
    if ( ! $_product->is_in_stock() ) {
    	$availability['availability'] = __('Availability: Out of Stock', 'woocommerce');
    }
 
    return $availability;
}

// Mini cart functionality
function add_item_to_minicart() {
	global $woocommerce;
   	$product_id  = intval( $_POST['product_id'] );
	$quantity  = intval( $_POST['quantity'] );
   	$woocommerce->cart->add_to_cart($product_id, $quantity);
    echo wc_get_template( 'cart/mini-cart.php' );
    die();
}
add_filter( 'wp_ajax_nopriv_add_item_to_minicart', 'add_item_to_minicart' );
add_filter( 'wp_ajax_add_item_to_minicart', 'add_item_to_minicart' );

//rename review cart
function woo_custom_change_cart_string($translated_text, $text, $domain) {
    $translated_text = str_replace("view cart", 'Review Cart >', $translated_text);
	

    $translated_text = str_replace("View cart", 'Review Cart >', $translated_text);
return $translated_text;
}
add_filter('gettext', 'woo_custom_change_cart_string', 100, 3);
add_filter('ngettext', 'woo_custom_change_cart_string', 100, 3);


//Rename checkout
add_filter('gettext', 'change_checkout_btn');
add_filter('ngettext', 'change_checkout_btn');

//function
function change_checkout_btn($checkout_btn){
  $checkout_btn= str_ireplace('Checkout', 'Checkout >', $checkout_btn);
  return $checkout_btn;
}

//Change Sequence
add_filter("woocommerce_checkout_fields", "custom_override_checkout_fields", 1);
function custom_override_checkout_fields($fields) {
    $fields['billing']['billing_first_name']['priority'] = 1;
    $fields['billing']['billing_last_name']['priority'] = 2;
    $fields['billing']['billing_email']['priority'] = 3;
    $fields['billing']['billing_phone']['priority'] = 4;
    $fields['billing']['billing_company']['priority'] = 5;
    $fields['billing']['billing_country']['priority'] = 6;
    $fields['billing']['billing_state']['priority'] = 10;
    $fields['billing']['billing_address_1']['priority'] = 11;
    $fields['billing']['billing_address_2']['priority'] = 7;
    $fields['billing']['billing_city']['priority'] = 8;
    $fields['billing']['billing_postcode']['priority'] = 9;
    
    
    return $fields;
}

//Menu Order
 add_filter( 'woocommerce_product_categories_widget_args', 'custom_woocommerce_product_subcategories_args' );
 function custom_woocommerce_product_subcategories_args( $args ) {
     $args['menu_order'] = 'ASC';
     return $args;
 }

add_filter( 'woocommerce_product_categories_widget_args', 'wpsites_exclude_product_cat_widget' );

//Exclude Categories
function wpsites_exclude_product_cat_widget( $args ) {

$args['exclude'] = array('38','18', '27');

return $args;
}

