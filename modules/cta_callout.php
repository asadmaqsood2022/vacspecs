<section id="cta-callout" class="container-fluid pt-2 pb-4 pb-sm-2 <?php the_sub_field('wrapper_class');?>">
        
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-8 d-flex flex-column justify-content-center">
                    <p class="text-center text-md-left"><?php the_sub_field('cta_callout_text'); ?></p>
                </div>
                
                <div class="col-12 col-md-6 col-lg-4 d-flex flex-column justify-content-center">
                    <?php $btn = get_sub_field('cta_callout_button'); ?>
                    <a class="btn btn-white btn-round" href="<?php _e($btn['url']); ?>"><?php _e($btn['title']); ?></a>
                </div>
            </div>
        </div>
        
</section>
