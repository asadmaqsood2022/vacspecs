<?php
/**
 * Template name: wishlist
 */

get_header();
error_reporting(0);
?>

<?php

// echo eval($variable);

$ses = $_COOKIE['list'];
$var1= explode( ',', $ses ); 


?>
<div class="whistlist-products">
<div class="container">
<div class="custom-products-design">
<section class="main-title">
    <div class="container">
                <div class="main-top">
            <h2>Wishlist</h2>
        </div>
    </div>

    </section>
<ul class="products">

<?php
if (is_user_logged_in()) {
$id = get_current_user_id();

$memebers = get_user_meta($id,'wishlist',true);
$str_arr = explode (",", $memebers);  
   
        $args = array(
            'post_type' => 'product',
            'post__in' => $str_arr,
            
            'posts_per_page' => -1
            );
        $loop = new WP_Query( $args );
        if ( $loop->have_posts() ) {
            while ( $loop->have_posts() ) : $loop->the_post(); global $product;
           
            woocommerce_get_template_part( 'content', 'product' );
            
?>
<?php
            endwhile;
        } else {
            echo __( 'No products found' );
        }
        wp_reset_postdata();

    }
 else {
    ?>
    <h3>Please login to save items to your wishlist</h3>           
    <?php
        wp_reset_postdata();
    }
?>
</ul>
</div>
</div>
</div>
<?php
get_footer();?>
