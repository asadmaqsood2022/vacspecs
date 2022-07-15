<section class="info-cards container mt-2">
    <div class="row align-items-stretch">
        
    <?php if (get_sub_field('card_lead') != ''): ?>
    <div class="col-12">
        <?php _e(the_sub_field('card_lead')); ?>
    </div>
    <?php endif;
        
 
    if( have_rows('cards') ) {
        while ( have_rows('cards') ) : the_row();
    ?>  
        <div class='col-sm-12 col-md-6 col-lg-4 d-flex align-items-stretch'>
        <div class="card mt-1">

            <?php
            if (get_sub_field('image') != ''): $image = get_sub_field('image'); ?>
                <div class='img-wrap'>
                    <?
                    echo wp_get_attachment_image($image,'featured_sqaure');
                    ?>
                </div>
            <?php endif; ?>

            <div class="card-body">
               <h4><strong><?php the_sub_field('title'); ?></strong></h4>
               <?php the_sub_field('description'); ?>
            </div>

        </div>
        </div>
    <?php
        endwhile;
    }
    ?>
</section>