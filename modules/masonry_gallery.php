
<section id="masonry-gallery" class="container py-2">
<?php if(get_row_layout() == 'masonry_gallery'){
            $payment_option=get_sub_field('payment_option_title');
            $delivery_partner=get_sub_field('delivery_partner_title');
             $shipping_img = get_sub_field('shipping');
            ?>
    <div class="card-columns">
        <h2><?php echo $payment_option; ?></h2>
        <h2><?php echo $delivery_partner; ?></h2>
        <img src="<?php echo $shipping_img['url'] ?>" alt="<?php echo $shipping_img['alt'] ?>" title="<?php echo $shipping_img['alt'] ?>" >
    <?php
    if (get_sub_field('gallery_images') != '') {

           $images = get_sub_field('gallery_images');

           foreach($images as $image => $image_id) {
               
               $large = wp_get_attachment_image_src($image_id, 'large');
               $src = $large[0];
               
               $thumb = wp_get_attachment_image_src($image_id, 'gallery_third');
               $thumb_src = $thumb[0];
               
               echo "<div class='card'>";
               echo '<a data-fancybox="gallery" href="'.$src.'"><img src="'.$thumb_src.'" class="nolazy"></a>';
               echo "</div>"; 
           }

    }
    ?>
    </div>
    <?php };?>
</section>