<?php
/**
 * Template name: Blog
 */

get_header();
woocommerce_breadcrumb(); 
?>

<section class="main-title">
    <div class="container">
        <div class="main-top">
            <h2><?php the_title(); ?></h2>
        </div>
    </div>

</section>
<section id="blogs" class="blog-section">
    <?php
    $args = array('posts_per_page' => -1, 'post_type' => 'post');
    $query = new WP_Query($args);
    if ($query->have_posts()) :
        while ($query->have_posts()) :
                $query->the_post();
    ?>
    <div class="blog-content">
        <div class="container">
            <div class="blog-content-inner">
                <div class="blog-cntnt-img">
                    <img src="<?php the_post_thumbnail_url(); ?>" alt="">
                </div>
                <div class="blog-cntnt-info">
                    <h3><?php the_title(); ?></h3>
                    <p><?php the_excerpt(); ?></p>
                    <a href="<?php the_permalink(); ?>">Read more</a>
                </div>
            </div>
        </div>
    </div>
    <?php endwhile; 
    wp_reset_postdata(); 
            else:  ?>
            <p>
            <?php _e( 'No Posts' ); ?>
            </p>
        <?php endif; ?>
       <?php
        // Previous/next page navigation.
        lightspeed_the_posts_navigation();
     ?>
</section>

<?php
get_footer();