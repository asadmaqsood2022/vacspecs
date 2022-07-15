<?php
/**
 * The template for displaying the footer
 */
?>
<section id="payment" class="container-fluid payment-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4  mb-2 mb-md-0">
                <h3><?php the_field('payment_option_main_title','option') ?></h2>
                <div class="logos-wrapper">
                <?php // repeater #1
             if( have_rows('payment_option_detail', 'options') ): ?>
                <?php while( have_rows('payment_option_detail' ,'options') ): the_row(); ?>
                <div class="logos">
                     <?php $logo = get_sub_field( "logo" ); ?>
                <img src="<?php echo $logo['url'] ?>" alt="<?php echo $logo['alt'] ?>" title="<?php echo $logo['alt'] ?>">
                </div>
                <?php endwhile; ?> <?php endif; ?>
             </div>
            </div>
          
            <div class="col-lg-8 col-md-8 ">
                <h3><?php the_field('delivery_partner_title','option') ?>
                <?php $img = get_field( "free_shipping", "option" ); ?>
          <img src="<?php echo $img['url'] ?>" alt="<?php echo $img['alt'] ?>" title="<?php echo $img['alt'] ?>">
         </h3>
                <div class="logos-wrapper"> 
                    <?php // repeater #1
                if( have_rows('delivery_partner_detail','option') ): ?>
                    <?php while( have_rows('delivery_partner_detail','option') ): the_row(); ?>
                    <div class="logos">
                        <?php $logo = get_sub_field( "logo" ); ?>
                        <img src="<?php echo $logo['url'] ?>" alt="<?php echo $logo['alt'] ?>" title="<?php echo $logo['alt'] ?>">
                    </div>
                    <?php endwhile; ?> <?php endif; ?>
                </div>
             </div>
        </div>
    </div>

</section>
<footer id="site-footer" class="site-footer fullwidth">
<div class ="container">
	<div class="row">
		
		<div class="footer-top">
			<div class="footer-logo">
				<?php $logo = get_field( "footer_logo", "option" ); ?>
				<a href="<?php echo site_url(); ?>"><img src="<?php echo $logo['url'] ?>" alt="<?php echo $logo['alt'] ?>" title="<?php echo $logo['alt'] ?>"></a>
			</div>
			<div class="contact-info">
				<?php $img1 = get_field("footer_phone_icon", "option"); ?>
        <img src="<?php echo $img1['url'] ?>" alt="<?php echo $img1['alt'] ?>" title="<?php echo $img1['alt'] ?>">
					<div class="local-phone phone">Local:  <h3><a href="tel:4032275511">403-227-5511</a></h3></div>
					<div class="toll-free phone" >Toll-Free:  <h3><a href="tel:18882275511">1-888-227-5511</a></h3></div>
			</div>
		</div>
    <?php
    //Build your footer divs here


    ?>
    <?php get_template_part( 'template-parts/footer/footer', 'widgets' ); ?>
	</div>
</div>
</footer>

<div id="colophon" class="site-credits">
    <?php 
        if (is_front_page()) $byline = "<a href='https://inet-media.ca/' target='_blank' rel='nofollow'>Web design</a> by iNet Media Ltd. Digital marketing experts."; 
        else $byline = "Web design by iNet Media Ltd. Digital marketing experts."; 
    ?>
    <div class="copyright">&copy; <?php echo date('Y');?> <?php echo get_bloginfo('name'); ?></div>
    <div class='byline'><?php echo $byline; ?></div>
</div>

<div id="mini-cart-wrapper" class="mini-cart">
	<span class="close-minicart">
		<i class="fa fa-close" aria-hidden="true"></i>
	</span>
	<div class="cont-shopping-box">
		<div class="message-notice"></div>
		<!-- <a class="button wc-backward" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>"> <?php _e( 'Continue Shopping', 'woocommerce' ) ?> </a> -->
	</div>
	<div id="mini-cart">
		<?php woocommerce_mini_cart(); ?>
	</div>
</div>



<div id="readersModal">
	<div class="popup_header">
      <h3> Product Comparison </h3>
	  <span class="popupclose">&times;</span>
   </div>
<div class="row" id="post_detail">

</div>
</div>




<?php 
//outputs jQuery.js, and other enqueued scripts
wp_footer();  
wp_reset_postdata(); //just incase a bad loop didn't clean up after itself :)

?>
<script type='text/javascript' src='<?php echo get_stylesheet_directory_uri(). "/js/global.js";?>'></script>

<script>
jQuery(function($) {
	
	<?php
		
		/*
		* 
		* Deferred CSS, add more paths to the deferred array below if needed!
		*
		*/
		$deferred_styles = array();
    
        #Google Fonts go here to help with LCP!
		#$deferred_styles[] = "https://fonts.googleapis.com/css2?family=Roboto&display=swap";
        
        
        #Main Deferred Global
		$deferred_styles[] = get_stylesheet_directory_uri()."/css/deferred-global.css";
		//$deferred_styles[] = "https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;700&family=Oswald:wght@400;700&display=swap";
        

        #Deferred front-page.css 
		if (is_front_page() && file_exists(get_stylesheet_directory()."/css/front-page.css")) {
			
			if (!empty(file_get_contents(get_stylesheet_directory()."/css/front-page.css")))
			$deferred_styles[] = get_stylesheet_directory_uri()."/css/front-page.css";
				
		}



		# Deferred Page Template CSS 
		# Takes the template's filename eg: page-contact.php, and enqueues /css/page-contact.css if it exists
		if (get_page_template_slug()) {

			$template_css_file = str_replace('.php','.css', basename(get_page_template_slug()));
			if (file_exists(get_stylesheet_directory()."/css/".$template_css_file)) {
				$deferred_styles[] = get_stylesheet_directory_uri()."/css/".$template_css_file;
			}

		}
	
        
        # Deferred Module styles 
        # if they exist on the page & the file exists too
        if( have_rows('content_modules') ) {
            
            $module_css = array();
            
            while ( have_rows('content_modules') ) : the_row();
                if (file_exists(get_stylesheet_directory() . '/css/'. get_row_layout() . ".css"))
                    $module_css[] = get_stylesheet_directory_uri() . '/css/'. get_row_layout() . ".css";
            endwhile;
            $module_css = array_unique($module_css);
            $deferred_styles = array_merge($deferred_styles, $module_css);
        }
                            
		# Finally... 
		# Deferred Library Styles (owl, fancybox, etc...)
		$deferred_styles = array_merge($GLOBALS['INET_DEFER_STYLES'],$deferred_styles);
	
	?>

	deferred = <?php echo json_encode($deferred_styles);?>;
	
	$(deferred).each(function(index, element) {
		var doc = document.createElement('link');
		doc.rel = 'stylesheet';
		doc.href = element;
		doc.type = 'text/css';
		var godefer = document.getElementsByTagName('link')[0];
		godefer.parentNode.insertBefore(doc, godefer);	
	});

});
</script>



<script type="text/javascript">

const printButton = document.getElementById('print-button');

if(printButton){
  printButton.addEventListener('click', event => {
	// build the new HTML page
	const content = document.getElementById('print-product').innerHTML;
	const printHtml = `<html>
	<head>
	<meta charset="utf-8">
	<title>Vacuum Specialists</title>
	</head>
	<body>${content}</body>
	</html>`;
	// get the iframe
	let iFrame = document.getElementById('print-iframe');
	// set the iFrame contents and print
	iFrame.contentDocument.body.innerHTML = printHtml;
	iFrame.focus();
	iFrame.contentWindow.print();
	}, false);
}


jQuery( document ).ready(function($) {
    function fetch_post_data(post_id) {
        var ajaxurl = "<?php echo admin_url( 'admin-ajax.php' ); ?>";
            $.ajax({
                type: "POST",
                dataType: "html",
                url: ajaxurl,
                data: {
                    action: 'get_post_content',
                    post_id: post_id,
                },
                success: function(data){
		
                // console.log(data);
                $('#readersModal').modal('show');
                    //$('#post_detail').html('');
                
				    // localStorage.setItem("compareProducts", JSON.stringify(data));
					// console.log(JSON.parse(localStorage.getItem("compareProducts")));
					$('#post_detail').html(data);
                    
            },
                   error : function(jqXHR, textStatus, errorThrown) {
                console.log('error');
            }
            });
            }


			function remove_post_data(post_id) {
			 
				var ajaxurl = "<?php echo admin_url( 'admin-ajax.php' ); ?>";
            $.ajax({
                type: "POST",
                dataType: "html",
                url: ajaxurl,
                data: {
                    action: 'remove_post_content',
                    post_id: post_id,
                },
                success: function(data){
                 console.log(data);
			
                 $('#readersModal').modal('show');
                   
				//     // localStorage.setItem("compareProducts", JSON.stringify(data));
				// 	// console.log(JSON.parse(localStorage.getItem("compareProducts")));
					$('#post_detail').html(data);
                    
            },
                   error : function(jqXHR, textStatus, errorThrown) {
                console.log('error');
            }
            });
			}

            jQuery(document).on('click', '.view', function(){
                var post_id = $(this).data("id");
				jQuery("body").css("overflow", "hidden");
                fetch_post_data(post_id);
               });

			   jQuery(document).on('click', '.delete_me', function(){
				var post_id = $(this).data("id");
                remove_post_data(post_id);
            });

			jQuery(document).on('click', '.popupclose', function(){
				jQuery('#readersModal').modal('hide');
				jQuery("body").css("overflow", "auto");
            });

			// jQuery(document).on('click', 'body', function(){
			// 	if(jQuery("#readersModal").hasClass("show")){
			// 		jQuery('#readersModal').modal('hide');
			// 		jQuery("body").css("overflow", "auto");
			// 	}
			// });

		


            });

		
		
	
</script>


</body>
</html>