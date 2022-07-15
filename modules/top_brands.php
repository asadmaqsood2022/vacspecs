<section id="brands" class="brands-section ">
    <div class="container">
        <?php if(get_row_layout() == 'top_brands'){
            $top_brand=get_sub_field('top_brand_main_title');
            $brands_link=get_sub_field('all_brands_link');
            ?>
        <div class="brand-top section-top">
            <h2><?php echo $top_brand; ?></h2>
            <a href="<?php echo $brands_link; ?>" class="btn btn-dark">View all brands <i class="icon-chevron-right"></i></a>
        </div>

        <div class="row">
            <?php if( have_rows('top_brand_info') ) :
                    while ( have_rows('top_brand_info') ) : the_row(); ?>
            <div class="col-12 col-md-6 col-lg-3">
                <div class="brand-wrapper">
                    <div class="brand-backImage">
                        <?php $img = get_sub_field("brand_background_image"); ?>
                        <img src="<?php echo $img['url'] ?>" alt="<?php echo $img['alt'] ?>" title="<?php echo $img['alt'] ?>"
                            class="nolazy">
                    </div>  
                    <div class="front-brand-image">      
                        <?php $img2 = get_sub_field("brand_logo"); ?>
                        <img src="<?php echo $img2['url'] ?>" alt="<?php echo $img2['alt'] ?>"
                            title="<?php echo $img2['alt'] ?>" class="nolazy">
                    </div>
                    <div class="brand-info">
                        <div class="brand-link">
                            <a href="<?php the_sub_field('brand_link'); ?>" class="btn btn-light">Shop now <i class="icon-chevron-right"></i></a>
                        </div>
                    </div>
                </div>    
            </div>
            <?php endwhile; endif; ?>
        </div>
    </div>

    <?php };?>
</section>