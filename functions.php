<?php
/**
* LightSpeed Child functions
*
* @package WordPress
* @since 1.0.0
     __    ____________  _____________ ____  ________________
    / /   /  _/ ____/ / / /_  __/ ___// __ \/ ____/ ____/ __ \
   / /    / // / __/ /_/ / / /  \__ \/ /_/ / __/ / __/ / / / /
  / /____/ // /_/ / __  / / /  ___/ / ____/ /___/ /___/ /_/ /
 /_____/___/\____/_/ /_/ /_/  /____/_/   /_____/_____/_____/

*/

#Debugging if needed
#!--- comment these out on production/live environments
ini_set('display_errors', 1);
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);


/**
 * Enqueue styles.
 */
add_action( 'wp_enqueue_scripts', 'lightspeed_child_styles');
function lightspeed_child_styles() {
	
    
	//Global Critical-CSS
	wp_enqueue_style( 'preload', get_stylesheet_directory_uri() . '/css/style.css', array(), '1.0');
  wp_enqueue_style( 'preload2', get_stylesheet_directory_uri() . '/style.css', array(), '1.0');
   
  if( is_front_page()) { 
    wp_enqueue_style( 'front-critical-css', get_stylesheet_directory_uri() . '/css/front-page-critical.css', false, '1.0' );
  }

	if ( is_product()) {
        wp_enqueue_style( 'singular', get_stylesheet_directory_uri() . '/css/single-product.css', array('preload'), '1.0');
        wp_enqueue_style( 'fancycss', get_stylesheet_directory_uri() . '/lib/fancyBox/jquery.fancybox.min.css', false, '1.0' );
    }
    
    if (is_woocommerce() || is_cart() || is_checkout() || is_account_page() ) {
      wp_enqueue_style( 'singular', get_stylesheet_directory_uri() . '/css/woocommerce.css', array('preload'), '1.0');
  }

}


/**
 * Enqueue Scripts
 */
add_action( 'wp_enqueue_scripts', 'lightspeed_child_scripts', 9999); //Run late to let inet-core enqueue libraries first
function lightspeed_child_scripts() {
	
	
	wp_enqueue_script( 'bootstrap','https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js', array('jquery'), '', true );
	
if( is_front_page()) { 
		 wp_enqueue_script('front-page', get_stylesheet_directory_uri().'/js/front-page.js', array('jquery'), '', true);
	}

if ( is_product()) {
        wp_enqueue_script( 'fancy', get_stylesheet_directory_uri() . '/lib/fancyBox/jquery.fancybox.min.js', false, '3.5.7');
    }
    

    
	// Template page specific JS 
	// Use W3 to combine based on your page template ---
	if (get_page_template_slug()) {

		$js_handle = str_replace('.php','', basename(get_page_template_slug()) );
		$js_file = str_replace('.php','.js', basename(get_page_template_slug()));

		if (file_exists(get_stylesheet_directory()."/js/".$js_file)) {
			wp_enqueue_script($js_handle, get_stylesheet_directory_uri().'/js/'.$js_file, array('jquery'), '', true);
		}

	}
	
	
	//Enqueue your custom post type scripts here
	//eg: if (get_post_type() == 'services' ....
	//-------------------------------------------

}

add_action('wp_head', 'add_rel_preload', 1);
function add_rel_preload() {

	//Add rel=preload hinting for these handles
	$global_preload_styles = $GLOBALS['INET_PRELOAD_STYLES'];
	$preload_styles = array_merge($global_preload_styles, array('lightspeed', 'lightspeed-child'));

    global $wp_styles;
    foreach($wp_styles->queue as $handle) {

        $style = $wp_styles->registered[$handle];
        $source = $style->src;

		//-- Spit out the tag if it's in our preload array
        if (in_array($handle, $preload_styles)) echo "<link rel='preload' href='{$source}' as='style'/>\n";

	}

}


/**
 * Your Custom Post Types
 */
require get_stylesheet_directory() . '/inc/custom-post-types.php';


/**
 * Custom Template functions
 */
require get_stylesheet_directory() . '/inc/template-functions.php';

/**
 * Custom Woocommerce functions
 */
if (class_exists('woocommerce')) {
    require get_theme_file_path() . '/woocommerce-functions.php';
}

/**
 * Custom template tags for the theme.
 */
require get_stylesheet_directory() . '/inc/template-tags.php';

/**
 * Custom Shortcodes
 */
require get_stylesheet_directory() . '/inc/shortcodes.php';

/**
 * Descript/Dequeue performance enhancements
 */
require get_stylesheet_directory() . '/inc/dequeue-descript.php';


/**
 * Custom compare functions
 */
//  if (class_exists('woocommerce')) {
//      require get_theme_file_path() . '/product_comparsion.php';
// }

//For Upload SVG Images
function add_svg_to_upload_mimes( $upload_mimes ) { 
    $upload_mimes['svg'] = 'image/svg+xml'; 
    $upload_mimes['svgz'] = 'image/svg+xml'; 
    return $upload_mimes; 
} 
add_filter( 'upload_mimes', 'add_svg_to_upload_mimes', 10, 1 ); 
    
// Svg uploads
function cc_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');



//wishlist
add_action('init','vacuum_wishlist_init');
function vacuum_wishlist_init(){
    if (class_exists("Woocommerce")) {
    function vacuum_wishlist_scripts_styles(){
      wp_enqueue_style( 'wishlist-style',get_stylesheet_directory_uri().'/css/custom.css', array(), '1.0.0' );
      wp_enqueue_script( 'wishlist-main', get_stylesheet_directory_uri().'/js/main.js', array('jquery'), '', true);
      wp_enqueue_script( 'com-main', get_stylesheet_directory_uri().'/js/custom.js', array('jquery'), '', true);

      wp_localize_script(
        'wishlist-main',
        'opt',
        array(
          'ajaxUrl'        => admin_url('admin-ajax.php'),
          'ajaxPost'       => admin_url('admin-post.php'),
          'restUrl'        => rest_url('wp/v2/product'),
          'shopName'       => sanitize_title_with_dashes(sanitize_title_with_dashes(get_bloginfo('name'))),
          'inWishlist'     => esc_html__("Already in wishlist","lightspeed"),
          'removeWishlist' => esc_html__("Remove from wishlist","lightspeed"),
          'buttonText'     => esc_html__("Details","lightspeed"),
          'error'          => esc_html__("Something went wrong, could not add to wishlist","text-domain"),
          'noWishlist'     => esc_html__("No wishlist found","lightspeed"),
        )
      );
      wp_enqueue_script('jquery');
      
    }
    add_action( 'wp_enqueue_scripts', 'vacuum_wishlist_scripts_styles' );


    add_action('woocommerce_after_shop_loop_item','wishlist_toggle',15);
    add_action('woocommerce_single_product_summary','wishlist_toggle',30);
    function wishlist_toggle(){
    
      
      global $product;
      //$wishimg = get_bloginfo('stylesheet_directory') . '/assets/images/icon.svg';
      echo '<a href="#" data-product="'.esc_attr($product->get_id()).'" class="rmv-wl">
        <img src="'.get_stylesheet_directory_uri().'/assets/images/delete-white-icon.svg" />
      </a>';
      echo '<div class="product-detail-options"> 
     <a class="wishlist-toggle" data-product="'.esc_attr($product->get_id()).'" href="#" title="'.esc_attr__("Add to wishlist","lightspeed").'">'. '<span class="wishlist-title">'.esc_attr__("Add to wishlist","lightspeed").'</span>'.
      '<img class="heart-icon" src="'.get_stylesheet_directory_uri().'/assets/images/heart-white.svg">'.'<img class="loading-icon" src="'.get_stylesheet_directory_uri().'/assets/images/loading-process.svg">'.'<img class="check-icon" src="'.get_stylesheet_directory_uri().'/assets/images/check.svg">'.
      '</a>';
   //   echo ' <a data-id="'.$product->get_id().'" href="#" class="btn-view view" data-toggle="modal" data-target="#proCamp">Compare Products</button>';
    }?>

<?php
    // Wishlist option in the user profile
    add_action( 'show_user_profile', 'wishlist_user_profile_field' );
    add_action( 'edit_user_profile', 'wishlist_user_profile_field' );
    function wishlist_user_profile_field( $user ) { ?>
      <table class="form-table wishlist-data">
        <tr>
          <th><?php echo esc_attr__("Wishlist","lightspeed"); ?></th>
          <td>
            <input type="text" name="wishlist" id="wishlist" value="<?php echo esc_attr( get_the_author_meta( 'wishlist', $user->ID ) ); ?>" class="regular-text" />
          </td>
        </tr>
      </table>
    <?php }
    
    add_action( 'personal_options_update', 'save_wishlist_user_profile_field' );
    add_action( 'edit_user_profile_update', 'save_wishlist_user_profile_field' );
    function save_wishlist_user_profile_field( $user_id ) {
      if ( !current_user_can( 'edit_user', $user_id ) ) {
        return false;
      }
      update_user_meta( $user_id, 'wishlist', $_POST['wishlist'] );
    }   


    // Get current user data
    function fetch_user_data() {
      if (is_user_logged_in()){
        $current_user = wp_get_current_user();
        $current_user_wishlist = get_user_meta( $current_user->ID, 'wishlist',true);
        echo json_encode(array('user_id' => $current_user->ID,'wishlist' => $current_user_wishlist));
      }
      die();
    }
    add_action( 'wp_ajax_fetch_user_data', 'fetch_user_data' );
    add_action( 'wp_ajax_nopriv_fetch_user_data', 'fetch_user_data' );

    function update_wishlist_ajax(){
      if (isset($_POST["user_id"]) && !empty($_POST["user_id"])) {
        $user_id   = $_POST["user_id"];
        $user_obj = get_user_by('id', $user_id);
        if (!is_wp_error($user_obj) && is_object($user_obj)) {
          update_user_meta( $user_id, 'wishlist', $_POST["wishlist"]);
        }
      }
      die();
    }
    add_action('admin_post_nopriv_user_wishlist_update', 'update_wishlist_ajax');
    add_action('admin_post_user_wishlist_update', 'update_wishlist_ajax');

    
   }
}
add_filter( 'comments_open', '__return_true');

//Add attribues
function nt_product_attributes() {
global $product;
    if ( $product->has_attributes() ) {

        $attributes = array (
        'color'              => $product->get_attribute('pa_color'),
        'size'            => $product->get_attribute('pa_size'),
        );
    return $attributes;
    }
}
// Register Custom Taxonomy
function ess_custom_taxonomy_Item()  {

$labels = array(
    'name'                       => 'Brands',
    'singular_name'              => 'Brand',
    'menu_name'                  => 'Brands',
    'all_items'                  => 'All Brands',
    'parent_item'                => 'Parent Brand',
    'parent_item_colon'          => 'Parent Brand:',
    'new_item_name'              => 'New Brand Name',
    'add_new_item'               => 'Add New Brand',
    'edit_item'                  => 'Edit Brand',
    'update_item'                => 'Update Brand',
    'separate_items_with_commas' => 'Separate Brand with commas',
    'search_items'               => 'Search Brands',
    'add_or_remove_items'        => 'Add or remove Brands',
    'choose_from_most_used'      => 'Choose from the most used Brands',
);
$args = array(
    'labels'                     => $labels,
    'hierarchical'               => true,
    'public'                     => true,
    'show_ui'                    => true,
    'show_admin_column'          => true,
    'show_in_nav_menus'          => true,
    'show_tagcloud'              => true,
);
register_taxonomy( 'item', 'product', $args );

}

add_action( 'init', 'ess_custom_taxonomy_item', 0 );


//is_in_stock
function zpd_variation_is_active( $active, $variation ) {
  if( ! $variation->is_in_stock() ) {
    return false;
  }
  return $active;
}
add_filter( 'woocommerce_variation_is_active', 'zpd_variation_is_active', 10, 2 );




//Attribues
function zpd_wc_get_att_slug_by_title( $attribute_title, $attributes ){
  if ( empty( $attribute_title ) || empty( $attributes )) __return_empty_string();
  $att_slug = '';

  foreach( $attributes as $tax => $tax_obj ){

    if( $tax_obj[ 'name'] === $attribute_title ){
      $att_slug = $tax;
    }
  }

  return $att_slug;
}




//Radio Button
add_action( 'woocommerce_after_single_product', function() {
 
  // Variable Products Only
  global $product;
  if( ! $product || ! $product->is_type( 'variable' ) ) {
    return;
  }
 
  // Inline jQuery
  ?>
  <script>
    jQuery( document ).ready( function( $ ) {
      $( ".variations_form" ).on( "wc_variation_form woocommerce_update_variation_values", function() {
        $( "label.generatedRadios" ).remove();
        $( "table.variations select" ).each( function() {
          var selName = $( this ).attr( "name" );
          $( "select[name=" + selName + "] option" ).each( function() {
            var option = $( this );
            var value = option.attr( "value" );
            if( value == "" ) { return; }
            var label = option.html();
            var select = option.parent();
            var selected = select.val();
            var isSelected = ( selected == value ) ? "checked=\"checked\"" : "";
            var isdisabled = option.prop('disabled') ? "disabled" : "enabled";
            var selectedClass = ( selected == value ) ? " selected" : "";
            var radioHtml = `<input name="${selName}" type="radio" value="${value}" />`;
            var optionHtml = `<label class="generatedRadios${selectedClass} ${isdisabled}">${radioHtml} ${label}</label>`;
            select.parent().append(
              $( optionHtml ).click( function() {
                select.val( value ).trigger( "change" );
              } )
            )
          } ).parent().hide();
        } );
      } );
    } );
  </script>
  <?php
} );


add_action( 'woocommerce_before_add_to_cart_quantity', 'bbloomer_echo_qty_front_add_cart' );
 
function bbloomer_echo_qty_front_add_cart() {
 echo '<div class="qty">Qty: </div>'; 
}



// //add_action( 'woocommerce_after_add_to_cart_form', 'misha_before_add_to_cart_btn' );
// add_action('woocommerce_after_shop_loop_item','misha_before_add_to_cart_btn',15);
add_action('woocommerce_single_product_summary','misha_before_add_to_cart_btn',35);
function misha_before_add_to_cart_btn(){
  global $product;
  echo '<a data-id="'.$product->get_id().'" href="#" class="btn-view view" data-toggle="modal" data-target="#proCamp"><img class="comparison-img" src="'.get_stylesheet_directory_uri().'/assets/images/comparison.svg"><span>Compare Products</span></button>';
 //echo ' <button data-id="'.$product->get_id().'" type="button" class="btn btn-view view" data-toggle="modal" data-target="#proCamp"><span>Compare Products</span></button>';
  // echo $product->get_id();
}


function get_post_content() {
  session_start();
	$post_id = intval($_POST['post_id']);
  $_SESSION['items'.$post_id] = $post_id;
  //print_r($_SESSION);

	$args = array(
		'post_type' => 'product',
	);
   //session_destroy();
	$the_query = new WP_Query( $args );

  foreach($_SESSION as $key=>$value) :  setup_postdata( $the_query );
  //  echo $value;

	if ( $the_query->have_posts() ) :

	 // while ( $the_query->have_posts() ) : $the_query->the_post();
    $_product = wc_get_product( $value );
    echo  $response =	' <div class="col-md-6" id="product'.$value.'">
    <div class="reader-image-wrap">
      <img class="modal-img" src="'.get_the_post_thumbnail_url($value).'" alt="">
    </div>
    <div class="content-wrap">
      <h4 class="modal-title">'.get_the_title($value).'</h4>
      <p class="modalContent">$'.$_product->get_price($value).'</p>
      <button data-id="'.$value.'" type="button" class="btn btn-remove delete_me">Remove</button>
    </div>
</div>';
   
//endwhile;
endif;

endforeach; 
wp_reset_postdata();
die();
//  die($response); ?>
 <?php }
add_action('wp_ajax_nopriv_get_post_content', 'get_post_content');
add_action('wp_ajax_get_post_content', 'get_post_content');



function remove_post_content() {
  session_start();
	$post_id = intval($_POST['post_id']);

  unset($_SESSION['items'.$post_id]);
  // print_r($post_id );
  // print_r($_SESSION);
  // session_destroy();

   $args = array(
     'post_type' => 'product',
   );
    //session_destroy();
   $the_query = new WP_Query( $args );
 
   foreach($_SESSION as $key=>$value) :  setup_postdata( $the_query );
    // echo $value;
 
   if ( $the_query->have_posts() ) :
 
    // while ( $the_query->have_posts() ) : $the_query->the_post();
     $_product = wc_get_product( $value );
     echo  $response =	' <div class="col-md-6" id="product'.$value.'">
         <div class="reader-image-wrap">
           <img class="modal-img" src="'.get_the_post_thumbnail_url($value).'" alt="">
         </div>
         <div class="content-wrap">
           <h4 class="modal-title">'.get_the_title($value).'</h4>
           <p class="modalContent">'.$_product->get_price($value).'</p>
           <button data-id="'.$value.'" type="button" class="btn btn-remove delete_me">Remove</button>
         </div>
   </div>';
    
 //endwhile;
 endif;
 
 endforeach; 
 wp_reset_postdata();
 die();
 //  die($response); ?>
  <?php }
add_action('wp_ajax_nopriv_remove_post_content', 'remove_post_content');
add_action('wp_ajax_remove_post_content', 'remove_post_content');