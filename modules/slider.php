<section id="slider" class= "">
    <div class="container">
    <div class="owl-carousel owl-theme banner-slider">
    <?php if( have_rows('slider_info') ) :
            while ( have_rows('slider_info') ) : the_row(); ?> 
    <div class="item"><?php $img = get_sub_field("slide"); ?>
                  <img src="<?php echo $img['url'] ?>" alt="<?php echo $img['alt'] ?>" title="<?php echo $img['alt'] ?>" class="nolazy"> 
                  <div class="slider-info">
                    <div class="slider-inner-content">
                        <h3><?php the_sub_field('main_title'); ?></h3>
                        <h1><?php the_sub_field('sub_title'); ?></h1>
                        <p><?php the_sub_field('slider_content'); ?></p>
                        <a href="<?php the_sub_field('slider_link'); ?>" class="btn btn-dark">Shop now <i class="icon-chevron-right"></i></a>
                         
                    </div>
                  </div>
                
                </div>
    <?php
            endwhile;
          endif;
                ?>
</div>
  </div>
</section>

