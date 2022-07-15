<?php
get_header();

/**
 * Template name: Taxonomy-single
 */

woocommerce_breadcrumb(); 
?>

<?php 
$terms = get_the_terms( $post->ID, 'item' ); 
foreach($terms as $term) { 
    //echo $term->name;?>
    <div class="brand-title">
        <div class="container">
            <h2><?php echo $term->name;  ?></h2>
            <div class="bt-img"><img src="<?php echo get_field('brand_image', $term);  ?>"></div>
        </div>
    </div>
<?php 
}
   
?>
<div class="single-brand-content">
<div class="container">
<div class="row">

<div class="col-md-4">
    <div class="brand-categories">
        <?php dynamic_sidebar('sidebar-archive'); ?>
    </div>
</div>
<div class="col-md-8">
    
<div class="brands-results">
    <div class="brands-search">
<?php do_action( 'woocommerce_before_shop_loop' );?>
</div>

<div class="custom-products-design">
<?php $cat_id = get_queried_object_id();
$args = array(
    'post_type'             => 'product',
    'post_status'           => 'publish',
    'ignore_sticky_posts'   => 1,
    'posts_per_page'        => '-1',
    'tax_query'             => array(
        array(
            'taxonomy'      => 'item',
            'field' => 'term_id', //This is optional, as it defaults to 'term_id'
            'terms'         => $cat_id,
            'operator'      => 'IN' // Possible values are 'IN', 'NOT IN', 'AND'.
        )
    )
);

$products = new WP_Query($args);
// The Loop
if ( $products->have_posts() ) {
    echo '<ul class="products">';
    while ( $products->have_posts() ) {
        $products->the_post();
 
        woocommerce_get_template_part( 'content', 'product' );
    }
    echo '</ul>';
} else {
    // no posts found

}

?>


    <?php
/* Restore original Post Data */
wp_reset_postdata();
?>
</div>
</div>
</div>
</div>
</div>
</div>



<?php
get_footer();
?>


