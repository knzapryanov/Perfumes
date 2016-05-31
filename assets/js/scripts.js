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

    $('body').on('change','.upload_files', function(){
    var input_val = $(this).val();
    if(input_val !== ''){
        $(this).parent().find('.under').removeClass('errorField');
    }

    var splited = input_val.split('\\');
    var file = splited[splited.length - 1]; // get only file!
    var fileExtens = file.split(".").pop(); // GET jpg,jpeg,gif,png
    var fileNoExt = file.split(".")[0].substring(0,14);
    
    if(file.length > 18){
      $(this).parent().find('.under').html(fileNoExt + '...' + fileExtens);   
      $(this).parent().find('.origFile').val(file);
    }
    else if(input_val === ''){
      $(this).parent().find('.under').html('No file chosen');     
    }
    else{
      $(this).parent().find('.under').html(file);    
      $(this).parent().find('.origFile').val(file);
    }  
    
  });


    $('#uploadImageForm').on('submit', function() {
        console.info($('.imageInput').val());
        if($('.imageInput').val() === '') {
            return false;
        }
        
        $.ajax({
            url: adminPath+"/doUpload", // Url to which the request is send
            type: "POST",             // Type of request to be send, called as method
            data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
            contentType: false,       // The content type used when sending data to the server.
            cache: false,             // To unable request pages to be cached
            processData:false,        // To send DOMDocument or non processed data file it is set to false
            success: function(image)   // A function to be called if request succeeds
            { 
                if(!image) {
                    return false;
                }
                
                $('.imageInput').val('');    
                $('.under').text('No file chosen');
                
                var childImage = '<div class="contImage" image-src="'+ image +'">'+
                                 +'<img src="'+ uploadsPath + '/' + image +'" />';
                                 +'<a class="removeImage">X</a>';
                                 +'</div>';
                // append image
                $('#startPoint').append(childImage);
                
            }
        });
    });
    
    $('body').on('click', '#createProduct', function() {
       var productName = $('#product_name').val();
       var productBrandId = $('#brand_id').val();
       var productCatId = $('#cat_id').val();
       var productPrice = $('#price').val();
       var productQuantity = $('#quantity').val();
       var productRate = $('#rate').val();
       var productMl = $('#ml').val();
       var productIsSale;
       var productSalePrice;
       if ($('#is_sale').is(":checked")) {
           productIsSale = 1;
           productSalePrice = $('#sale_price').val();
       }
       else {
           productIsSale = 0;
           productSalePrice = 0;
       }
       var productIsOff;
       var productOffPrice;
       if($('#is_off').is(":checked")){
           productIsOff = 1;
           productOffPrice = $('#off_price').val();
       }
       else{
           productIsOff = 0;
           productOffPrice = 0;
       }
/*       var images = [];
       
       for(var i = 0; i < $('.contImage').length; i++) {
          var src = $('.contImage').eq(i).attr('image-src');
          
          images.push(src);
       }*/
       
       showWaitMessage('Product is being uploaded...');
       $.ajax({
          url: adminPath+"/createProduct",
          type: 'POST',
          data: {
             product_name: productName,
             brand_id: productBrandId,
             cat_id: productCatId,
             price: productPrice,
             quantity: productQuantity,
             rate: productRate,
             ml: productMl,
             is_sale: productIsSale,
             sale_price: productSalePrice,
             is_off: productIsOff,
             off_price: productOffPrice
             //images: images
          },
          success: function(response) {
              if(response) {
                  clearForm();
                  $.event.trigger({
                      type: 'hideMessage',
                      bool: true
                  });
              }
              else {
                  $.event.trigger({
                      type: 'hideMessage',
                      bool: false
                  });
              }
          }
       });
    });
    
    $('body').on('click', '.removeImage', function() {
       $(this).parent().remove(); 
    });
    
    
    function clearForm() {
        
    }
    
     $(document).on('hideMessage', function(e) {
         var element =  $('.waitMessage');

        if(!e.bool) {
             element
                     .html('Database ERROR!')
                     .addClass('errorEvent');
                   
        }
        
        element.animate({
                        opacity: 0,
                        top: '-37px'
                     }, function() {
                           $(this).remove();
                           $(this).removeClass('errorEvent');
                     });
     });
    
    function showWaitMessage(message) {
     if($('.waitMessage').length === 0) {
        $('body').prepend('<div class="waitMessage">'+ message +'</div>');
               $('.waitMessage').animate({
                  opacity: 1,
                  top: '-1px'
               },
               {
                 duration:500,
                 complete: function(){
//                    var that = $(this);
//                    $(document).on('hideMessage', function() {
//                        console.info('hide');
//                        setTimeout(function(){
//                         $(that).animate({
//                         opacity: 0,
//                         top: '-37px'
//                        },function(){
//                            $(this).remove();
//                        });
//                       }, 400);
//                       
//                    });
                 }
       });
    }
}

    $('#sale_price_div').hide();
    $('#is_sale').click(function() {
        $('#sale_price_div')[this.checked ? "show" : "hide"]();
    });

    $('#off_price_div').hide();
    $('#is_off').click(function() {
        $('#off_price_div')[this.checked ? "show" : "hide"]();
    });

});   