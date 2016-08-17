$(document).ready(function() {
   // set Active Class
   $('.topnav li a').each(function() {
       var targetClass = document.URL.indexOf($(this).attr('class'));
       
        console.info(targetClass);
       if(targetClass  > -1) {
          $('.' + $(this).attr('class')).addClass('activeClass');
       }
   });
   
   
   var pageProducts = 1;
   
   $('body').on('click', '.showSingle', function() {
        var productName = $.urlParam('product_name'); 
        var pathToController  = typeof adminPath === 'undefined' ? publicPath : adminPath;
        
      $('body').prepend('<div id="loader"></div>');  
      
      $.ajax({
         url: pathToController + "/loadProducts",
         type: 'POST',
         data: {
           product_name: productName,
           page: pageProducts
         },
         success: function(response) {
                var data = JSON.parse(response);

                for(var i in data.products) {
                    var li = '<li>'
                                +'<a href="javascript:void(0)" class="brandId" attr-id="'+ data.products[i].id +'">X</a>'
                                +'<label>'+ data.products[i].product_name +'</label>'
                                +'<a href="' + pathToController +'/editProduct/' + data.products[i].id + '" class="editProduct" attr-id="'+ data.products[i].id +'">edit</a>'
                            +'</li>';

                    $('#productPageOl').append(li);
                }
                
            pageProducts++;
            
            $('#loader').remove();
            
            if(data.nextPage === 0) {
                $('.showSingle').remove();
            }
        }
       });
        
        
    });
   
   
   
   // Create Product
   $('body').on('click', '#createProduct', function() {
       var productName = $('#product_name').val();
       var isSale = 0;
       var description = $('textarea#description').val();
       var productBrandId = $('#brand_id').val();
       var productCatId = $('#cat_id').val();
       var isUpdate = $('#updateMethod').length > 0 ? 1 : 0;
       var method = 'createProduct';
       var productId = [];
       
       if(isUpdate === 1) {
           method = 'updateProduct';
           productId = $('#updateMethod').val();
       }
       
       if(!checkEmptyVal()) {
         alert('Some of the required fields is empty!');  
         return false;
       }

       if(isProductOnSale()) {

           if(!isSalePriceFilled()) {
               alert('Please fill sale price!');
               return false;
           }

           isSale = 1;
       }

       if($('.holderPrices').length === 0 ) {
           alert('Please add atleast one ML for the product!');
           return false;
       } 
       
       var mlArray = getAllMl();
       var images = getImages();     
       
       var addToNewest = $('#addToNewest').is(':checked') === true ? 1 : 0; 

       showWaitMessage('Product is being uploaded...');
       $.ajax({
          url: adminPath+"/" + method,
          type: 'POST',
          data: {
             product_name: productName,
             is_sale: isSale,
             brand_id: productBrandId,
             cat_id: productCatId,
             mlArray: mlArray,
             images: images,
             addToNewest: addToNewest,
             product_id: productId,
             description: description
          },
          success: function(response) {
              if(response !== false) {
                  
                  var jsonData = JSON.parse(response);
                  
                  $('#counterNew').text(jsonData.data.length);
                  
                  
                  if(productId.length > 0) {
                      $('ol li').remove();
                  }
                  else {
                      clearForm();
                  }
                  
                  for(var i in jsonData.data) {
                      var li = '<li>'
                               +'<input type="checkbox" checked="checked" value="'+ jsonData.data[i].id +'">'
                               +'<label>'+ jsonData.data[i].product_name +'</label>'
                            +'</li>';
                      $('ol').append(li);
                  }
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
    
    function checkEmptyVal() {
         if($('#product_name').val() === '' || $('.price').val() === '' || $('.contImage').length === 0) {
             return false;
         }
         
         
         return true;
    }
    
    function isProductOnSale() {

        for(var i = 0; i < $('.holderPrices').length; i++ ) {
            var holder = $('.holderPrices').eq(i);

            if(holder.find('.is_sale').prop('checked') === true) {
                return true;
            }
        }

        return false;
    }
    
    function isSalePriceFilled() {

        for(var i = 0; i < $('.holderPrices').length; i++ ) {
            var holder = $('.holderPrices').eq(i);

            if(holder.find('.sale_price').val() != '') {
                return true;
            }
        }

        return false;
    }
    
    function getAllMl() {
        var mlArrayHolder = [];
        
        for(var i = 0; i < $('.holderPrices').length; i++ ) {
           var currentArray = [];
           var holder = $('.holderPrices').eq(i);
           
           var mlVal =  holder.find('.editMl').val();
           var priceVal =  holder.find('.price').val();
           
           if(holder.find('.is_sale').prop('checked') === true) {
            var salePrice =  holder.find('.sale_price').val();
            var offPercentage =  holder.find('.off_percentage').val();
           }
           
           else {
               salePrice = '';
               offPercentage = '';
           }
           
           var quantity = 10; // this is hardcoded!
           
           
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

                 }
            });
         }
    }
    
    function clearForm() {
        $('input, textarea').not('input[type=submit]').val('');
        $('input#addToNewest').attr('checked', false);
        $('.contImage, .holderPrices, ol li').remove();
        $('#brand_id option:first, #cat_id option:first').prop('selected', true);
    }
    
    // Create and Update Product function END
    
    
    
    // ADD BRAND 
    
    $('#formBrand').on('submit', function () {
        var nameBrand = $('#brand_name').val();
        if(nameBrand === '') {
            return false;
        }

        $.ajax({
         url: adminPath+"/createBrand",
         type: 'POST',
         data: {
           brand_name: nameBrand
         },
         success: function(response) {
              
            if(!response) {
                alert('create FAIL!');
            }
            else {
                var data = JSON.parse(response);
                var li = '<li>'
                            +'<a href="javascript:void(0)" class="brandId" attr-id="'+ data.brand_id +'">X</a>'
                            +'<label>'+ nameBrand +'</label>'
                        +'</li>';
                                            
                $('#brandPageOl').prepend(li);
            }
         }
       });
    });
   
});