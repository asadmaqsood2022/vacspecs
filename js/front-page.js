
jQuery(document).ready(function() {
   jQuery('.owl-carousel').owlCarousel({
   loop: false,
   margin: 10,
   // autoplay:true,
   // autoplayTimeout:5000,
   responsiveClass: true,
   responsive: {
     0: {
       items: 1,
       nav: false
     },
     768: {
       items: 1,
       nav: true
     }
   }
 })
})
