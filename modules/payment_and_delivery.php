<section id="payment" class="container-fluid payment-section">
    <div class="container">
        <?php if(get_row_layout() == 'payment_and_delivery'){
        $payment_option  =  get_sub_field('payment_option_title'); 
        $delivery_option  =  get_sub_field('delivery_partner_title'); 
        $shipping_img = get_sub_field('shipping');
        ?>
        <div class="row">
            
                    
                    <div class="col-lg-4 col-md-4  mb-2 mb-md-0">
                        <h3><?php echo $payment_option; ?></h2>
                        <div class="logos-wrapper">
                        <?php // repeater #1
                     if( have_rows('payment_option_details') ): ?>
                        <?php while( have_rows('payment_option_details') ): the_row(); ?>
                        <div class="logos">
                             <?php $logo = get_sub_field( "logo" ); ?>
                        <img src="<?php echo $logo['url'] ?>" alt="<?php echo $logo['alt'] ?>" title="<?php echo $logo['alt'] ?>">
                        </div>
                        <?php endwhile; ?> <?php endif; ?>
                     </div>
                    </div>
                    

                    
         
                    
                    <div class="col-lg-8 col-md-8 ">
                        <h3><?php echo $delivery_option; ?><img src="<?php echo $shipping_img['url'] ?>" alt="<?php echo $shipping_img['alt'] ?>" title="<?php echo $shipping_img['alt'] ?>" >  </h3>
                        <div class="logos-wrapper"> 
                            <?php // repeater #1
                        if( have_rows('delivery_partner_details') ): ?>
                            <?php while( have_rows('delivery_partner_details') ): the_row(); ?>
                            <div class="logos">
                                <?php $logo = get_sub_field( "logo" ); ?>
                                <img src="<?php echo $logo['url'] ?>" alt="<?php echo $logo['alt'] ?>" title="<?php echo $logo['alt'] ?>">
                            </div>
                            <?php endwhile; ?> <?php endif; ?>
                        </div>
                     </div>
                </div>
    
        <?php };?>  
    </div>

</section>