
(function(jQuery){
    "use strict";
    Array.prototype.unique = function() {
        return this.filter(function (value, index, self) {
          return self.indexOf(value) === index;
        });
      }
       
      function isInArray(value, array) {return array.indexOf(value) > -1;}
       
      function onWishlistComplete(target, title){
          setTimeout(function(){
              target
              .removeClass('loading')
              .addClass('active')
              .attr('title',title);
          },800);
      }
       
      function highlightWishlist(wishlist,title){
          jQuery('.wishlist-toggle').each(function(){
              var jQuerythis = jQuery(this);
              var currentProduct = jQuerythis.data('product');
              currentProduct = currentProduct.toString();
              if (isInArray(currentProduct,wishlist)) {
                  jQuerythis.addClass('active').attr('title',title);
              }
          });
      }


    var shopName   = opt.shopName+'-wishlist',
    inWishlist = opt.inWishlist,
    restUrl    = opt.restUrl,
    wishlist   = new Array,
    ls         = sessionStorage.getItem(shopName),
    loggedIn   = (jQuery('body').hasClass('logged-in')) ? true : false,
    userData   = '';


    if(loggedIn) {
        // Fetch current user data
        jQuery.ajax({
            type: 'POST',
            url: opt.ajaxUrl,
            data: {
                'action' : 'fetch_user_data',
                'dataType': 'json'
            },
            success:function(data) {
                userData = JSON.parse(data);
                if (typeof(userData['wishlist']) != 'undefined' && userData['wishlist'] != null && userData['wishlist'] != "") {
     
                    var userWishlist = userData['wishlist'];
                    userWishlist = userWishlist.split(',');
     
                    if (wishlist.length) {
                        wishlist =  wishlist.concat(userWishlist);
     
                        jQuery.ajax({
                            type: 'POST',
                            url:opt.ajaxPost,
                            data:{
                                action:'user_wishlist_update',
                                user_id :userData['user_id'],
                                wishlist :wishlist.join(','),
                            }
                        });
     
                    } else {
                        wishlist =  userWishlist;
                    }
     
                    wishlist = wishlist.unique();
     
                    highlightWishlist(wishlist,inWishlist);
                    sessionStorage.removeItem(shopName);
     
                } else {
                    if (typeof(ls) != 'undefined' && ls != null) {
                        ls = ls.split(',');
                        ls = ls.unique();
                        wishlist = ls;
                    }
     
                    jQuery.ajax({
                        type: 'POST',
                        url:opt.ajaxPost,
                        data:{
                            action:'user_wishlist_update',
                            user_id :userData['user_id'],
                            wishlist :wishlist.join(','),
                        }
                    })
                    .done(function(response) {
                        highlightWishlist(wishlist,inWishlist);
                        sessionStorage.removeItem(shopName);
                    });
                }
            },
            error: function(){
                console.log('No user data returned');
            }
        });
    }
    else {
        if (typeof(ls) != 'undefined' && ls != null) {
            ls = ls.split(',');
            ls = ls.unique();
            wishlist = ls;
        }
    }


    jQuery('.wishlist-toggle').each(function(){
 
        var jQuerythis = jQuery(this);
        var currentProduct = jQuerythis.data('product');
        currentProduct = currentProduct.toString();

        if (!loggedIn) {
            jQuerythis.removeClass('active');
        }
     
        jQuery(this).on('click',function(e){
            e.preventDefault();
            if (loggedIn) {
                if (!jQuerythis.hasClass('active') && !jQuerythis.hasClass('loading')) {
                    jQuerythis.addClass('loading');
                    wishlist.push(currentProduct);
                    wishlist = wishlist.unique();
                    // get user ID
                    if (userData['user_id']) {
                        jQuery.ajax({
                            type: 'POST',
                            url:opt.ajaxPost,
                            data:{
                                action:'user_wishlist_update',
                                user_id :userData['user_id'],
                                wishlist :wishlist.join(','),
                            }
                        })
                        .done(function(response) {
                            onWishlistComplete(jQuerythis, inWishlist);
                        })
                        .fail(function(data) {
                            alert(opt.error);
                        });
                    }
                }
            }
             else {
                alert("Please login to save items to your wishlist!");  
            }
        });
    });


    jQuery(document).on('click', '.rmv-wl', function(e){
        var dprod = jQuery(this).data('product');
        let dp_ind = wishlist.indexOf(dprod.toString());
        var awl = wishlist;
        awl.splice(dp_ind ,1);
        if (loggedIn) {
            // get user ID
            if (userData['user_id']) {
                jQuery.ajax({
                    type: 'POST',
                    url:opt.ajaxPost,
                    data:{
                        action:'user_wishlist_update',
                        user_id :userData['user_id'],
                        wishlist :awl.join(','),
                    }
                })
                .done(function(response) {
                    jQuery(".post-"+dprod).hide();
                })
                .fail(function(data) {
                    alert(opt.error);
                });
            }
        } else {
            console.log('else');
            sessionStorage.setItem(shopName, wishlist.toString());
            setTimeout(function(){
                jQuerythis.closest('table').removeClass('loading');
                jQuerythis.closest('tr').remove();
            },500);
        }
        return false;     
    });
})(jQuery);

