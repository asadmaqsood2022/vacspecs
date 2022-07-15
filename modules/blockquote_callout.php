<section id="blockquote-callout" class="container <?php the_sub_field('container_class'); ?>">
        
        <div class="row">
            <?php
            if (get_sub_field('blockquote_image') != '') :
            ?>
            
                <div class="col-12 col-md-3 pt-1 d-flex flex-column justify-content-center align-items-center">
                    <?php
                    echo wp_get_attachment_image(get_sub_field('blockquote_image'), 'full'); 
                    ?>
                </div>

                <div class="col-12 col-md-9 d-flex flex-column justify-content-center">
                    <h2><?php the_sub_field('blockquote_callout_title'); ?></h2> 
                    <blockquote><?php the_sub_field('blockquote_callout_content'); ?></blockquote>
                </div>

            <?php else : ?>
                <div class="col-12">
                    <h2><?php the_sub_field('blockquote_callout_title'); ?></h2> 
                    <blockquote><?php the_sub_field('blockquote_callout_content'); ?></blockquote>
                </div>
            <?php endif; ?>
        </div>
        
</section>