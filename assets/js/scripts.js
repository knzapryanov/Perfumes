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
    

    
     $('body').on('click', '#overLayerManual ol li input', function() {
        var value = $(this).val(); 
        var isChecked = $(this).is(':checked') === true ? 1 : 0; 
        
        
        $.ajax({
            url: adminPath + '/updateNewest',
            type: 'POST',
            data: {
                id: value,
                is_newest: isChecked 
            },
            success: function(response) {
                console.info(response);
            }
        });
        
     }); 

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
        $('input, textarea').not('input[type=submit]').val('');
        $('input#addToNewest').attr('checked', false);
        $('.contImage, .holderPrices, ol li').remove();
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

    $('body').on('click', '.is_sale', function() {
        $(this).parent().find('.sale_price_div')[this.checked ? "show" : "hide"]();
    });

    $('.is_sale').each(function() {
       if($(this).parent().find('.sale_price_div').is(':visible')) {
           $(this).attr('checked', true);
       } 
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
    
    
    $('body').on('click', '.brandId', function () {
        var id = $(this).attr('attr-id'); 

        $.ajax({
         url: adminPath+"/deleteBrand",
         type: 'POST',
         data: {
           id: id
         },
         success: function(response) {
                console.info(response, JSON.parse(response));
            if(!response) {
                alert('Delete FAIL!');
            }
            else {
                $('#brandPageOl li').find('a[attr-id="'+ id +'"]').parent().remove();
                    console.info('success');
            }
         }
       });
    });
    
    $('body').on('click', '.deleteProduct', function () {
        var id = $(this).attr('attr-id'); 

        $.ajax({
         url: adminPath+"/deleteProduct",
         type: 'POST',
         data: {
           id: id
         },
         success: function(response) {
            console.info(response, JSON.parse(response));
            if(!response) {
                alert('Delete FAIL!');
            }
            else {
                $('#productPageOl li').find('a[attr-id="'+ id +'"]').parent().remove();
                    console.info('success');
            }
         }
       });
    });
    
    
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
    
    
    var pageManuals = 1;
    var pagePromo = 1;
    var pageProducts = 1;
    
    $('body').on('click', '.loadProducts', function() {
        var element = $(this).parents('.container');
        var pathToController  = typeof adminPath === 'undefined' ? publicPath : adminPath;
        var method = $(this).attr('attr-method');
        var page = pageManuals;
        // default page counter for index page newest products
        
        if(method === 'loadPromotions') {
          page = pagePromo;
          // assign new page iterator
        }
        
      $('body').prepend('<div id="loader"></div>');  
      
      $.ajax({
         url: pathToController + "/" + method,
         type: 'POST',
         data: {
           page: page
         },
         success: function(response) {
                var data = JSON.parse(response);
                 
                for(var i in data.products) {
                    var offPercentageArr = [];
                    var regularPriceArr = [];
                    var salePriceArr = [];
                    var cashedSale = [];
                    
                    var salePrice = '';
                    var regularPrice = '';
                    var offPercentage = '';    
                    var isSale = '';
                    
                    for(var j = 0; j < data.products[i].options.length; j++ ) {
                        var option = data.products[i].options[j];
                        
                        if(option.sale_price !== '0') {
                            salePriceArr.push(option.sale_price);
                            cashedSale.push(option.sale_price);

                            offPercentageArr.push(option.off_percentage);
                        }
                        else {
                            salePriceArr.push(0);
                            offPercentageArr.push(0);
                        }
                        
                        regularPriceArr.push(option.price);
                    }
                    
//                    console.info(regularPriceArr, salePriceArr, offPercentageArr);
                 
                    if(salePriceArr.indexOf(0) === -1) {
                        var salePriceArrSort = salePriceArr.sort(function(a, b){return a - b;});
                        var minSalePrice = salePriceArrSort[0];
                        var index = $.inArray( minSalePrice, cashedSale );
                       
                        offPercentage = offPercentageArr[index];
                        salePrice = '\u20AC ' + minSalePrice + '.00';
                        regularPrice = regularPriceArr[index];
                        regularPrice = '<del>\u20AC ' + regularPrice + '.00</del>';
                        
                        
                        
                        if(offPercentage < 30) {
                            isSale = 1;
                        }
                        else {
                             isSale = 0;
                        }
                        
                    }
                    else {
                        var regularPriceArrSort = regularPriceArr.sort(function(a, b){return b - a;});
                        var minRegularPrice = regularPriceArrSort[0];
                        
                        regularPrice = '\u20AC ' + minRegularPrice + '.00';
                    }

                    var createDiv = $('<div class="col-md-3 gallery-grid "></div>');
                    
                    var divContents = '<a href="'+ baseUrlJS +'product/' + data.products[i].slug + '">'
                                    +'<img src="'+ uploadsPath +'/thumbs/' + data.products[i].pictures[0].source + '" class="img-responsive" alt="' + data.products[i].product_name + '">'
                                    +'<div class="gallery-info">'
                                        +'<div class="quick">'
                                            +'<p><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> view</p>'
                                        +'</div>'
                                    +'</div>'
				+'</a>'
				+'<div class="galy-info">'
                                    +'<p>' + data.products[i].product_name + '</p>'
                                    +'<div class="galry">'
                                         +'<div class="home_item_price">' + regularPrice + '</div>'
                                         +'<div class="home_new_price">' + salePrice + '</div>'
                                            +'<div class="clearfix"></div>'
                                    +'</div>'
                               +'</div>';
                            
                   createDiv.append(divContents);         
                            
                    
                    var child = '';
                    
                    if(isSale === 1) {
                        child = '<div class="b-wrapper_sale">'
                                       +'<div>SALE</div>'
                                    +'</div>';
                        
                    }   
                    else if (isSale === 0) {
                        child = '<div class="b-wrapper_percent_off">'
                                  +'<div>' + offPercentage + ' %<br>OFF</div>'
                                 +'</div>';
                    }
                    
                    createDiv.find('a').prepend(child);
                    
                    element.find('.gallery-grids').append(createDiv);
                }
                
           if(method === 'loadPromotions') {
                pagePromo++;
                // assign new page iterator
            } 
           else {
                 pageManuals++;
           }
            
            $('#loader').remove();
            
                console.info(data);
            
            if(data.nextPage === 0) {
                element.find('.loadProducts').remove();
            }
        }
       });
        
        
    });
    
    
    
    $.urlParam = function(name){
            var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
            if (results === null){
               return null;
            }
            else{
               return results[1] || '';
            }
   };
    
    
}); 
// ready end