var classes = document.body.classList;
var aa = classes.toString();
var ex = aa.replace(/\D/g, "");

const li = document.getElementsByClassName('cat-item');
for(item of li){
    var list = item.classList.toString().replace(/\D/g, "");
    if(ex==list) {
        item.className += " show-menu";
    }
}

if (jQuery(".product-categories li ul li").hasClass("show-menu")){
    jQuery(".product-categories .current-cat-parent").addClass("show-menu");
}

//console.log(li);
jQuery(function($) {


    $('.page-id-42 .product-wrapper .options-product a').removeClass('ajax_add_to_cart');
    
    // PRODUCT CATEGORIES SIDEBAR JS STARTS
    // $( ".single-brand-content .brand-categories .product-categories > li" ).each(function( index ) {
    //     $(this).addClass('category-'+index);
    // });
    // if($('body').hasClass('term-central-vacuum')) {
    //     $(".brand-categories .product-categories li.category-0").addClass("show-menu");
    // }
    // else if($('body').hasClass('term-residential')) {
    //     $(".brand-categories .product-categories li.category-1").addClass("show-menu");
    // }
    // else if($('body').hasClass('term-commercial')) {
    //     $(".brand-categories .product-categories li.category-2").addClass("show-menu");
    // }
    // else if($('body').hasClass('term-air-quality')) {
    //     $(".brand-categories .product-categories li.category-3").addClass("show-menu");
    // }
    // else if($('body').hasClass('term-cleaning-products')) {
    //     $(".brand-categories .product-categories li.category-4").addClass("show-menu");
    // }
    // else if($('body').hasClass('term-accessories-parts')) {
    //     $(".brand-categories .product-categories li.category-5").addClass("show-menu");
    // }
    // else {
    //     $(".brand-categories .product-categories li").removeClass("show-menu");
    // }
    // PRODUCT CATEGORIES SIDEBAR JS ENDS

    if ($("#deals .product_cat-top-deals")) {
        $("#deals .sale-perc").show();
        $("#deals .onsale").hide();
    }
     if ( $(".top-selling-section .product_cat-residential")) {
        $(".top-selling-section .sale-perc").hide();
         $(".top-selling-section .onsale").show(); 
     }

    // brand-categories filters js starts

    $(".brand-categories .product-categories > li").click(function(){
        $(this).toggleClass("show-menu");
    });

    // brand-categories filters js ends

    /* Mobile nav toggle */
    $('.mobile-nav-toggle').click(function() {
		
		if ($('body').hasClass('nav-open')) {
			$('.mobile-nav-container').animate({right:'-285px'}, 200);
            $('body').animate({right:'0px'}, 200);
		}
		else {
            $('.mobile-nav-container').animate({right:'0px'}, 200);
            $('body').animate({right:'285px'}, 200);
		}
		
		$('body').toggleClass('nav-open');
		
    });
    
    
    $('.mobile-nav-container .close span').click(function() {
        $('.mobile-nav-container').animate({right:'-285px'}, 200);
        $('body').animate({right:'0px'}, 200);
		$('body').removeClass('nav-open');
    });
	
	
	//Easy Expandable Nav with sub-menu support :)
	$('.menu-item-has-children').on('click', function(e) {
		
        e.preventDefault();
		e.stopPropagation();
        
        $(this).toggleClass('open');
        $(this).children('.sub-menu').slideToggle('fast');
       
        
	});
	
	$('.menu-item a').on('click', function(e) {
		e.preventDefault();
		e.stopPropagation();
        
        /* if this is just a # then expand the children */
        if ($(this).attr('href') == "#") {
            $(this).parent().toggleClass('open');
            $(this).next('.sub-menu').slideToggle('fast');
        } else if ($(this).attr('target') == '_blank') { 
            window.open($(this).attr('href'), '', '');
            return false;
        } else {
            window.location.href=$(this).attr('href');		
        }
	});
    
    
    //Lazy-load CSS BG's if they are set
    //Build an array of targets then check with window.scroll below
    var lazybg_targets= {}; 
    $('section').each(function() {
       if ($(this).data('css-bg') != null 
           && $(this).data('css-bg') != undefined
           && $(this).data('css-bg-webp') != null
           && $(this).data('css-bg-webp') != undefined) {

           lazybg_targets[$(this).attr('id')]  =  {
                'bg' : $(this).data('css-bg'),
                'bgwebp' : $(this).data('css-bg-webp'),
                'top' : $(this).offset().top,
                'bottom' : $(this).offset().top + $(this).outerHeight()
           };                   

       }
    });

    //Toggle the top nav sticky class
	$(window).scroll(function() {
		
        checklazyBG();
        
		if (document.scrollingElement.scrollTop > 1) {
			$('#masthead').addClass('sticky');
		}else {
			$('#masthead').removeClass('sticky');
		}
        
	});

	//After a refresh.... the browser may already be scrolled to it's previous position
	if ( document.scrollingElement.scrollTop > 1) {
        
        checklazyBG();
		$('#masthead').addClass('sticky');    
        
    }
    
    
    function checklazyBG() {
        
        
        var bottom_of_screen = $(window).scrollTop() + $(window).innerHeight();
        var top_of_screen = $(window).scrollTop();
        
        $.each(lazybg_targets, function(index, el) {
                        
            //If already loaded, ignore
            if ( $('#'+index).attr('bg-loaded') == "true") {
              return;  
                
            } else if ((bottom_of_screen > el.top) && (top_of_screen < el.bottom)){
                                
                $('#'+index).attr('bg-loaded', 'true');                
                if ($('body').hasClass('webp')) {
                    $('#'+index).css('background-image', 'url('+el.bgwebp+')' );
                } else {
                    $('#'+index).css('background-image', 'url('+el.bg+')' );
                }
                
            }
 
        });
        
    }   
    

    // Mini Cart
    $('.show-cart').click(function() {
        $("body").addClass("mini-cart-on");
        $("#mini-cart-wrapper").show();
    });
    $('.close-minicart').click(function() {
        $("body").removeClass("mini-cart-on");
        $("#mini-cart-wrapper").hide();
    });
    // if ( jQuery("body").hasClass("mini-cart-on") ) {
    //     alert("adsa");

        jQuery("body").on("click",function(){
            if(this.classList[14] == "mini-cart-on")
            {
            console.log("clicked");
            jQuery("body").removeClass("mini-cart-on");
            jQuery("#mini-cart-wrapper").hide(); 
        }
        });
    // }
    
   // mini Cart product title and quantity js
    $('.single-product-container .entry-summary .quantity input').change(function() {
        var title = jQuery('.woocommerce div.product .product_title').html();
        var quantity = jQuery('.single-product-container .entry-summary .quantity input').val();
        jQuery('.mini-cart .cont-shopping-box .message-notice').html(quantity + ' x ' + title );
    });
    
    $('.single_add_to_cart_button').click(function(e) {
        e.preventDefault();

        var product_id = $(this).val();

        if($( this ).closest('form.cart').hasClass('variations_form')) {
            $variation_form = $( this ).closest( '.variations_form' );
            var product_id = $variation_form.find( 'input[name=product_id]' ).val();
            var quantity = $variation_form.find( 'input[name=quantity]' ).val();
            var var_id = $variation_form.find( 'input[name=variation_id]' ).val();
            var data = {
                action: 'add_item_to_minicart',
                product_id: product_id,
                quantity: quantity,
                variation_id: var_id,
            };
        } else {
            $simple_form = $( this ).closest( 'form.cart' );
            var quantity = $simple_form.find( 'input[name=quantity]' ).val();
            console.log("Quantity: ",quantity);
            var data = {
                action: 'add_item_to_minicart',
                product_id: product_id,
                quantity: quantity
            };
        }
        // debugger;
        if(window.location.hostname == 'localhost')
        {
            var loc_path = 'http://localhost/vacspecs';
        }
        else{
            var loc_path =  window.location.protocol + "//" + window.location.host;
        }

         jQuery.post('' + loc_path + '/wp-admin/admin-ajax.php' , data, function(response) {
            $('#mini-cart').html(response);
        }).done(function() {
            var title = jQuery('.woocommerce div.product .product_title').html();
            var quantity = jQuery('.single-product-container .entry-summary .quantity input').val();
            jQuery('.mini-cart .cont-shopping-box .message-notice').html(quantity + ' x ' + title );
            $("body").addClass("mini-cart-on");
            $('#mini-cart-wrapper').show();
            $(".mini-cart-on .mini-cart .cont-shopping-box").show();
            // Update cart quantity
            var currentQuantity = $(".header .navbar .card-options .cart-image .cart-number").html().trim();
            var prevQuantity = $(".single-product-container .entry-summary .quantity input").val();
            var totalCart = parseInt(currentQuantity) + parseInt(prevQuantity);
            $(".header .navbar .card-options .cart-image .cart-number").html(totalCart);
        });
        
        return false;
    });

    
    
});


// Adds a "webp" or "nowebp" class to the body tag which allows you to have specific webp and non-webp CSS backgrounds.
function check_webp_feature(A){var e=new Image;e.onload=function(){e.width>0&&e.height;document.body.className+=" webp"},e.onerror=function(){document.body.className+=" nowebp"},e.src="data:image/webp;base64,"+{lossy:"UklGRiIAAABXRUJQVlA4IBYAAAAwAQCdASoBAAEADsD+JaQAA3AAAAAA",lossless:"UklGRhoAAABXRUJQVlA4TA0AAAAvAAAAEAcQERGIiP4HAA==",alpha:"UklGRkoAAABXRUJQVlA4WAoAAAAQAAAAAAAAAAAAQUxQSAwAAAARBxAR/Q9ERP8DAABWUDggGAAAABQBAJ0BKgEAAQAAAP4AAA3AAP7mtQAAAA==",animation:"UklGRlIAAABXRUJQVlA4WAoAAAASAAAAAAAAAAAAQU5JTQYAAAD/////AABBTk1GJgAAAAAAAAAAAAAAAAAAAGQAAABWUDhMDQAAAC8AAAAQBxAREYiI/gcA"}[A]}check_webp_feature("lossy");


