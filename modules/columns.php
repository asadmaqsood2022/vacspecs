<?php
/* Outputs columns with the classes provided, EZ! */

$section_options = get_sub_field('section_options');

if ($section_options == "contained") {
    $section_container_class = "container";
}

if ($section_options == "fluid-contained") {
    $section_container_class = "container-fluid";
    $content_container_class = "container";
}

if ($section_options == "fullwidth") {
    $section_container_class = "container-fluid";
}

?>

<section id="<?php the_sub_field('section_id'); ?>" class="<?php _e($section_container_class . " " . get_sub_field('section_class')); ?>">
    <?php if ($content_container_class != '') _e("<div class='".$content_container_class."'>"); ?>
	<div class="row">
        
            
         
        <?php
        //Columns repeater
        if( have_rows('column_repeater') ) {
            while ( have_rows('column_repeater') ) : the_row();
                ?>    
                <div class="<?php the_sub_field('column_class'); ?>">
                    
                    <?php 
                    $content_class = get_sub_field('column_content_class');

                
                   
                   
            
                    if ($content_class != '') : 
                        ?>
                        <div class="<?php _e($content_class);?>">
                       
                            <?php the_sub_field('column_content'); ?>
                        </div>
                        <?php
                    else :
            
                        if (get_sub_field('content_type') == "image" && get_sub_field('image') != '' && get_sub_field('image_height') != '') :
                            
                            $image_height = get_sub_field('image_height');
                            $bannertitle= get_sub_field('banner_title');
                             $contentlink= get_sub_field('content_link');
            
                            echo '<div class="image-container" style="height:'.$image_height.'px !important;">';
                            echo wp_get_attachment_image(get_sub_field('image'), 'featured_half');
                            if($bannertitle){
                                echo '<div class="banner-title"><h1>' .$bannertitle. '</h1> </div>'; 
                             }
                             ?>
                             <a href="<?php the_sub_field('content_link'); ?>" class="btn btn-light"> view all <i class="icon-chevron-right"></i></a>
                             <?php
                            echo " </div>";
                           
                        else :
                            the_sub_field('column_content');
                            
                        endif;
                            
                    endif;
                    ?>
                    
                </div>
                <?php
            endwhile;
        }
        ?>
        
    </div>
    <?php if ($content_container_class != '') _e("</div>"); ?>
</section>