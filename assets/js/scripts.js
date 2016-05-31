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
                
                var childImage = '<div class="contImage" image-src="'+ image +'">'
                                     +'<img src="'+ uploadsPath + '/thumbs/' + image +'" />'
                                     +'<a href="javascript:void(0)" class="removeImage"></a>'
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
       
//       var productPrice = $('#price').val();
//       var productQuantity = $('#quantity').val();
       if($('.holderPrices').length === 0 ) {
           alert('Please add atleast one ML for the product!');
           return false;
       } 
       
       var mlArray = getAllMl();
       var images = getImages();     
       
       var addToNewest = $('#addToNewest').is(':checked');
       var manualNewest = getManualProducts();
       
//        console.info(productName, productBrandId, productCatId);
//        console.info(mlArray, images, addToNewest, manualNewest);
//       return false;
       showWaitMessage('Product is being uploaded...');
       $.ajax({
          url: adminPath+"/createProduct",
          type: 'POST',
          data: {
             product_name: productName,
             brand_id: productBrandId,
             cat_id: productCatId,
             mlArray: mlArray,
             images: images,
             addToNewest: addToNewest,
             manualNewest: manualNewest
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
    
    function getManualProducts() {
        var manualProducts = [];
        
        for(var i = 0; i < $('#overLayerManual ol li').length; i++) {
            var currentInput = $('#overLayerManual ol li').eq(i).find('input');
            
            if(currentInput.is(':checked')) {
                manualProducts.push(currentInput.val());
            }
        }
        
        return manualProducts;
    }
    
    function getAllMl() {
        var mlArrayHolder = [];
        
        for(var i = 0; i < $('.holderPrices').length; i++ ) {
           var currentArray = [];
           var holder = $('.holderPrices').eq(i);
           
           var mlVal =  holder.find('.editMl').val();
           var priceVal =  holder.find('.price').val();
           var salePrice =  holder.find('.sale_price').val();
           var offPercentage =  holder.find('.off_percentage').val();
           var quantity = holder.find('.quantity').val();
           
           currentArray.push(mlVal, priceVal, salePrice, offPercentage, quantity);
           
           mlArrayHolder.push(currentArray);
        }
        
        return mlArrayHolder;
    }
    
    function getImages() {
       var images = [];
       
       for(var i = 0; i < $('.contImage').length; i++) {
          var src = $('.contImage').eq(i).attr('image-src');
          images.push(src);
       }
       
       return images;
    }
    
    
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

    $('.sale_price_div').hide();
    
    $('body').on('click', '.is_sale', function() {
        $(this).parent().find('.sale_price_div')[this.checked ? "show" : "hide"]();
    });

    $('body').on('click', '.calculateButton', function() {
       var holder = $(this).parents('.holderPrices');
       
       var priceVal = holder.find('.price').val();
       var salePriceVal = holder.find('.sale_price').val();
       var offPercentageVal = holder.find('.off_percentage').val();
       var salePrice = holder.find('.sale_price');
       var offPercentage = holder.find('.off_percentage');
       
       if(priceVal !== '') {
            if(salePriceVal !== '') {
             calculatePrecentage(salePriceVal, priceVal, offPercentage);
            }
            else if (offPercentageVal !== '') {
              calculateSalePrice(offPercentageVal, priceVal, salePrice);  
            }
       }
       else {
           alert('Please fill regular PRICE first!');
       }
    });

    function calculatePrecentage(salePrice, priceVal, offPercentage) {
        var result = 100 - (salePrice/priceVal * 100);

        offPercentage.val(Math.ceil(result));
    }
    
    function calculateSalePrice(offPercentage, priceVal, salePrice) {
       var result = priceVal - (priceVal * (offPercentage/100));
               

        salePrice.val(Math.floor(result));  
    }
    
    $('body').on('click', '#addMl', function() {
        if($('#ml').val() === '') {
            return false;
        }
        
        createHolderPrices($('#ml').val());
    });
    
    $('body').on('click', '.removeOption', function() {
        $(this).parents('.holderPrices').remove();
    });
    
    

    function createHolderPrices(ml) {
        var child = '<div class="holderPrices">'
                     +'<div class="headerMl">'
                         +'<span>ML&nbsp</span><input type="text" value="'+ ml +'" name="price" class="editMl" autocomplete="off">'
                         +'<a class="removeOption" href="javascript:void(0)">X</a>'
                     +'</div>'
                     +'<div>'
                             +'<span>Price<label>*</label></span>'
                             +'<input type="text" name="price" class="price" autocomplete="off">'
                     +'</div>'
                     +'<div>'
                         +'<input type="hidden" name="is_sale" value="0">'
                         +'<input type="checkbox" name="is_sale" class="is_sale" id="" value="1"><label class="fixLabel" for="">Product on sale</label><br>'
                         +'<div class="sale_price_div" style="display: none;">'
                             +'<span>Sale price<label>*</label></span>'
                             +'<input type="text" name="sale_price" class="sale_price" autocomplete="off">'
                              +'<a class="calculateButton" href="javascript:void(0)">calculate</a>'
                             +'<span>OFF Percentage<label>*</label></span>'
                             +'<input type="text" name="off_percentage" class="off_percentage" autocomplete="off">'                                                          
                         +'</div>'
                         +'<span class="qnty">Quantity<label>*</label></span>'
                         +'<input type="text" name="quantity" class="quantity" autocomplete="off">'
                     +'</div>'
                +'</div>';
        
        
        $('#containerHolderPrices').append(child);
        $('#ml').val('');
    
    }
}); 
// ready end