$(document).ready(function() {
   if($('#successRegister').length > 0) {
       setTimeout(function() {
           $('#successRegister').slideUp();
       }, 5000);
   } 

   $('.add-to-cart').on('click',function(){

        //Scroll to top if cart icon is hidden on top

        $('html, body').animate({

                'scrollTop' : $(".cart_anchor").position().top

        });

        //Select item image and pass to the function

        var itemImg = $(this).parent().find('img').eq(0);

        flyToElement($(itemImg), $('.cart_anchor'));

    });
// cart animation

});   