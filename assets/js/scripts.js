$(document).ready(function() {
    
    $('.shipping_information_table').on('click', 'input[type="button"]', function() {
        var elementClass = $(this).attr('class');
        
        if($(this).hasClass('activeTab')) {
            return false;
            // fuck you!
        }
        
        $('input[type="button"]').removeClass('activeTab');
        $('.effect_container, .save_profile_info').fadeOut();
        $('').fadeOut();
        
        $('#' + elementClass).show(500);
        if(elementClass === 'address_container') {
            $('.save_profile_info').show(500);
        }
        $(this).addClass('activeTab');

    });
    // profile animation tabs
    
    if($('#flashDataMessage').length > 0) {
        $('#flashDataMessage').delay(5000).fadeOut(500);
    }
    
    
    
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

        //flyToElement($(itemImg), $('.cart_anchor'));

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
            }
        });
        
     }); 
    
    $('body').on('click', '.removeImage', function() {
       $(this).parent().remove(); 
    });
    
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
//                         +'<span class="qnty">Quantity<label>*</label></span>'
//                         +'<input type="text" name="quantity" class="quantity" autocomplete="off">'
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
    
   function appendMessage(that, element , message) {
       var selector = '#' + element;
       
       if($(selector).length === 0) {
         that.append('<div id="' + element + '">' + message + '</div>');
         setTimeout(function() {
                  $(selector).fadeOut('', function(){
                      $(this).remove();
                  });
         }, 4000);
       }
   }
   
   $('#emailSubscription').on('submit', function () {
        var val = $("#subscriptionInput").val();
        var patern =  /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        var that = $(this);
        
        if(!patern.test(val)) {
          appendMessage(that, 'errorMessage', 'Please enter valid email address!'); 
          
          return false;
        }
        
        $('#submitEmail').attr('disabled', 'disabled');
        
        $.ajax({
            url: publicPath+"/signEmail",
            type: 'POST',
            data: {
                sign_email: val
            },
            success: function(response) {
                $('#submitEmail').removeAttr('disabled');
                if(!response) {
                    
                   appendMessage(that, 'errorMessage', 'Please enter valid email address!'); 
                   
                   return false;   
                }
                
                appendMessage(that, 'successMessage', 'Thanks for the subscription!');
                $('#subscriptionInput').val('');
            }
        });
    });
    
    var pageManuals = 1;
    var pagePromo = 1;
    
    
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

                 var regularPriceArr = [];
                 var salePriceArr = [];
                 var percentageArr = [];

                 var regularPriceToView = '';
                 var salePriceToView = '';
                 var percentageToView = '';
                 var isSale = '';

                 for(var j = 0; j < data.products[i].options.length; j++ ) {

                     var option = data.products[i].options[j];
                     salePriceArr.push(option.sale_price);
                     percentageArr.push(option.off_percentage);
                     regularPriceArr.push(option.price);
                 }

                 //console.info(regularPriceArr, salePriceArr, percentageArr);

                 var regularPriceMin = Math.min.apply(Math, regularPriceArr);
                 var salePriceMin = 9999;
                 for(var j = 0; j < salePriceArr.length; j++) {

                     if(salePriceArr[j] > 0 && parseInt(salePriceArr[j]) < salePriceMin) {

                         //console.info('enter if', salePriceMin, salePriceArr[j]);
                         salePriceMin = salePriceArr[j];
                     }
                 }

                 if(regularPriceMin < salePriceMin) {
                     regularPriceToView = '\u20AC ' + regularPriceMin;
                 }
                 else {
                     var index = $.inArray( salePriceMin, salePriceArr );
                     salePriceToView = '\u20AC ' + salePriceMin;
                     regularPriceToView = '<del>\u20AC ' + regularPriceArr[index] + '</del>';
                     percentageToView = percentageArr[index];

                     if(percentageToView < 30) {
                         isSale = 1;
                     }
                     else {
                         isSale = 0;
                     }
                 }

                 console.info(data.products[i].product_name, regularPriceToView, salePriceToView, percentageToView);

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
                     +'<div class="home_item_price">' + regularPriceToView + '</div>'
                     +'<div class="home_new_price">' + salePriceToView + '</div>'
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
                         +'<div>' + percentageToView + ' %<br>OFF</div>'
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
               return false;
            }
            else{
               return results[1] || '';
            }
    };


    $('input[name="perfume_ml"]').on('change', function(){

        $('#quantity')
                .attr('max', $(this).attr('quantity'))
                .val(1);
        
        $('h5.item_price').html('Price: €<span id="finalPrice">' + $(this).val() + '</span>');
    });


    $(function() {

        var $radios = $('input:radio[name=perfume_ml]');
        $radios.eq(0).prop('checked', true);
        $("h5.item_price").html('Price: €<span id="finalPrice">' + $radios.eq(0).val() + '</span>');
    });


    $('#quantity').on('change', function(){

        var quantityVal = $(this).val();
        
        var currentSelectedPrice = $('input[name="perfume_ml"]:checked').val();
        $("h5.item_price").html('Price: €<span id="finalPrice">' + (quantityVal * currentSelectedPrice) + '</span>');
    });


    $('.qty_add_to_cart').on('focus', '#quantity', function() {
        $(this).on('keyup', function() {
            
            if(!isInt($(this).val())) {
                $(this).val(1);
                alert('This is not allowed number!');
                
                return false;
            }
            
        });
    });

    function isInt(value) {
      return !isNaN(value) && (function(x) { return (x | 0) === x; })(parseFloat(value))
    }

    //$('select[name="perfum_available_ml"]').on('change',function(){
    $('.col-md-9, .product-model-sec').on('change', 'select[name="perfum_available_ml"]', function(){
        
        // change max by options index selected
        var index = $(this).find('option:selected').index();
        var target = $(this).parents('.ofr').next('.item_quantity');

        var splitedAttr = target.attr('options-quantity').split(',');
        target.attr('max', splitedAttr[index]);
        
        
        
        
        $(this).parents('.product-info-cust, .prt_name').find('.item_quantity').val(1);
        var optionPrice = $(this).val();

        if(optionPrice.indexOf('-') > -1) {

            optionPrice = optionPrice.split('-');
            $(this).parents('.product-info-cust, .prt_name').find('.item_price').html('\<del\>€ ' + optionPrice[0] + '\</del\>');
            $(this).parents('.ofr').find('.new_price > p').text('€ ' + optionPrice[1]);

            if(optionPrice[2] > 30){

                var newPercentOffDiv = '<div class="b-wrapper_percent_off">' +
                    '<div>' + optionPrice[2] + ' %<BR/>OFF</div>' +
                    '</div>';

                $(this).parents('.product-grid').find('.b-wrapper_percent_off').remove();
                $(this).parents('.product-grid').find('.b-wrapper_sale').remove();

                $(this).parents('.product-grid').find('.img-responsive').after(newPercentOffDiv);
            }
            else {

                var newSaleDiv = '<div class="b-wrapper_sale">' +
                                    '<div>SALE</div>' +
                                 '</div>';

                $(this).parents('.product-grid').find('.b-wrapper_percent_off').remove();
                $(this).parents('.product-grid').find('.b-wrapper_sale').remove();

                $(this).parents('.product-grid').find('.img-responsive').after(newSaleDiv);
            }
        }
        else {

            $(this).parents('.product-info-cust, .prt_name').find('.item_price').html('€ ' + optionPrice);
            $(this).parents('.ofr').find('.new_price > p').text('');
            $(this).parents('.product-grid').find('.b-wrapper_percent_off').remove();
            $(this).parents('.product-grid').find('.b-wrapper_sale').remove();
        }
    });
    
    var currentUrl = document.URL;
    var counterPage = 0;
    
    if(currentUrl.indexOf('products') > - 1) {
        var min = 0;
        var minOld = min;
        var max = 500;
        var brands = '';
        var cat = !$.urlParam('cat') ? 'man' : $.urlParam('cat') ;


        // check price

        if(currentUrl.indexOf('min') > - 1) {
           min = $.urlParam('min');
           max = $.urlParam('max'); 

           minOld = min < 0 || min > 500 || min > max ? 0 : min;

           max = max < 0 || max > 500 || min > max ? 500 : max;
       }

       brands = getUrlBrands(brands, currentUrl); 
       
       // onload page set brands and min max fitler price
       setRangeFilterValOnInit(minOld, max);
       counterPage = 1;
       
       loadFilteredProducts(cat, brands,  min, max, true);
    }
    
    function setRangeFilterVal(min, max) {
        var rangeSlider = $("#range").data("ionRangeSlider");

        rangeSlider.update({
            from: min,
            to  : max
        });
    }
    
    function getUrlBrands(brands, url) {
        $('#brandsSlider label input, .all_brands_column label input').attr('checked', false);
        // clean before add
        
        if(url.indexOf('brand') > - 1) {
            brands = $.urlParam('brand');
            var brandsArr = [brands];
                    
            if(brands.indexOf(';') > -1 ) {
              brandsArr = brands.split(';');   
            }
            
               var length = brands.length;
               
               for(var i = 0; i < length; i++) {
                   // on load page check and click for header brands search and left filter 
                   $('#brandsSlider label input').each(function() {
                       if($(this).val() == brandsArr[i]) {
                           $(this).prop('checked', true);
                           
                           $('.all_brands_column label input[value="' + $(this).val() + '"]')
                             .prop('checked', true);
                       }
                   });
               }
        
        }
        
        return brands;
        
    }
    
    
    $('body').on('focus', '.prt_name', function() {
        var itemQuantity = $(this).find('.item_quantity');
        
        itemQuantity.on('keyup', function() {
           if(!isInt($(this).val())) {
                $(this).val(1);
                alert('This is not allowed number!');
                
                return false;
            }
        });
    });
     
    $('.left_side_categories').on('click', 'a', function() {
         
         if(document.URL.indexOf('products') > - 1) {
            var cat = $(this).find('div').attr('cat');
            
            counterPage = 0;
            loadFilteredProducts(cat, '',  0, 500, '');
            setActiveClass();

            return false;
         }
         // check page for optimize ajax request than php 
     });

    function setDisabledFilter() {
         $('.product_right .sky-form:first').prepend('<div id="disabledFilter"><div/>');
     }

    $('body').on('click', '.menu_see_all_brands', function() {
        var thisCatAttr = $(this).attr('attr-cat');
        
        $('.searchOverlyBrands').attr('attr-cat', thisCatAttr);
        
        getUrlBrands('', document.URL);
        
        setDisabledFilter();
       
    });
    
    // detect on load if page is top filtred
    function checkPageForTop() {
        var selector = $('#disabledFilter');
        var isExist = selector.length === 0;
        if(document.URL.indexOf('cat=top') > -1) {
             if(isExist) {
                 setDisabledFilter();
             }
        }
        else {
            selector.remove();
        }
    }
    
    checkPageForTop();
    
    

    // reset filter options to default!
    $('body').on('click', '#cleanFilter', function() {
       var currentCat = $.urlParam('cat');

       counterPage = 0;
       loadFilteredProducts(currentCat, '',  0, 500, '');
    });
  
    $('body').on('click', '.searchOverlyBrands', function() {
        var brands = '';
        $('.all_brands_column label input').each(function() {
            if($(this).is(':checked')) {
                if(brands === '') {
                     brands = $(this).val();
                }
                else {
                   brands += ';' + $(this).val();
                }
            }
         });

        counterPage = 0;
        
        var cashBaseUrl = baseUrlJS;
        var url = document.URL.split('?')[0] + '?';
        
        if(document.URL.indexOf('/products') === -1) {
            url = cashBaseUrl += 'products?';
        }
        
        var cat = 'cat=' + $(this).attr('attr-cat');
        var brand= '&brand=' + brands;
        var price = '&min=' + 0 + '&max=' + 500;
        var buildUrl = url + cat + brand + price;
        
        window.location.href = buildUrl;
    });
    
   $(document).on('draging:finish', function() {

    var fromToValuesArr = $('#range').val().split(';');
    // fromToValuesArr is string array if needed parse to int
    var min = fromToValuesArr[0];
    var max = fromToValuesArr[1];
    var brands = '';

    brands = getUrlBrands(brands, document.URL);

    counterPage = 0;

    loadFilteredProducts($.urlParam('cat'), brands,  min, max, '');
    });
    
   
    $('.sky-form').on('click', '#brandsSlider label input', function(){ 
        var brandId = $(this).val();
        var currentBrand = $.urlParam('brand');
        var currentCat = $.urlParam('cat');
        var min = $.urlParam('min');
        var max = $.urlParam('max');
        
        if(!$(this).is(':checked')) {
            // remove
            var splitArr = currentBrand.split(';');

            if(splitArr.length > 1) {
                var index = $.inArray(brandId, splitArr);
                    splitArr.splice(index, 1); // return deleted item!!!!
                
                currentBrand = splitArr.join(';');
                 
               // we have more than one brand in url
            }
            else {
               currentBrand = ''; 
               // we have 1 and just clean
            }
        }
        
        else {
            // add
            if(currentBrand === '') {
                currentBrand = brandId;
            }
            else {
                currentBrand += ';' + brandId;
            }
        }

       counterPage = 0;
       loadFilteredProducts(currentCat, currentBrand,  min, max, '');
    });
    
    
    $('.dropdown').on('click', '.list1', function() {
        
        if(document.URL.indexOf('products') > -1) {
            var closeElement = $(this).parents('.dropdown');
            
            counterPage = 0;
            loadFilteredProducts(
                    closeElement.attr('attr-cat'),
                    $(this).attr('brandId'),  
                    0, 
                    500,
                    ''
            );
            
            closeElement.removeClass('open');
            
            return false;
            
            // ignore php and let ajax do the work
        }
        
        
    });
    
    
    // set active class in products and product page
    function setActiveClass() {
        $('.left_side_categories a div').removeClass('selected_category');
        $('.left_side_categories a div[cat="'+ $.urlParam('cat') +'"]').addClass('selected_category');
        
        $('#headerFilter').text(ucfirst($.urlParam('cat')) + ' ' + 'Perfumes');
    }
    
    function ucfirst(str) {
     var firstLetter = str.substr(0, 1);
    return firstLetter.toUpperCase() + str.substr(1);
    }
    
    if(document.URL.indexOf('/products') > -1) {   
        // on laod
        setActiveClass();
   }

    
    $('body').on('click', '.loadFilteredProducts', function() {
        loadFilteredProducts(
            $.urlParam('cat'), 
            $.urlParam('brand'),  
            $.urlParam('min'), 
            $.urlParam('max'),
            ''
        );

        $.event.trigger({
                      type: 'counterPage',
                      bool: true
                  });

    });
    
    function setRangeFilterValOnInit(min, max) {
        $('#range')
                .attr('data-from', min)
                .attr('data-to', max);
        
    }
    
    function setUrlAddressBar(catParam, brands,  min, max) {
        var url = document.URL.split('?')[0] + '?';
        var cat = 'cat=' + catParam;
        var brand= '&brand=' + brands;
        var price = '&min=' + min + '&max=' + max;
        
        var buildUrl = url + cat + brand + price;
        
        window.history.pushState('', '', buildUrl);
    }
    
    function loadFilteredProducts(catParam, brands,  min, max, ajaxStop) {
        setUrlAddressBar(catParam, brands,  min, max);
        
        if(ajaxStop == true) {
            return false;
        }
        
        $('body').prepend('<div id="loader"></div>');
        
        $.ajax({
            url: publicPath + "/filteredProducts",
            type: 'POST',
            data: {
                min: isNaN(min) ? 0 : min,
                max: isNaN(max) ? 500 : max,
                cat: catParam,
                brand: brands,
                page: counterPage
            },
            success: function(response) {
                checkPageForTop();
                
                if(response != false) {
                    setRangeFilterVal(min, max);
                    // set globaly min and max value on range filter

                    //console.log(response);
                    var jsonData = JSON.parse(response);
                    
                    //console.log(jsonData);


                    if(counterPage == 0) {
                       $('.col-md-9, .product-model-sec').html('');
                    }
                    counterPage++;

                    
                    for(var i in jsonData.sorted) {

                        var productDiv = $('<div class="product-grid" attr-id="' + jsonData.sorted[i].id + '"></div>');
                        var productDivContents =
                            '<a href="' + baseUrlJS + 'product/' + jsonData.sorted[i].slug + '">' +
                                '<div class="more-product"><span> </span></div>' +
                                '<div class="product-img b-link-stripe b-animate-go  thickbox">' +
                                '<img src="'+ uploadsPath +'/thumbs/' + jsonData.sorted[i].pictures[0].source + '" class="img-responsive" alt="' + jsonData.sorted[i].product_name + '">' +
                                '<div class="b-wrapper">' +
                                '<h4 class="b-animate b-from-left  b-delay03">' +
                                '<button><span class="glyphicon glyphicon-info-sign"></span></button>' +
                                '</h4>' +
                                '</div>' +
                                '</div>' +
                            '</a>' +
                            '<div class="product-info simpleCart_shelfItem">' +
                                '<div class="product-info-cust prt_name">' +
                                '<h4>' + jsonData.sorted[i].product_name + '</h4>' +
                                '<span class="item_price">' + jsonData.sorted[i].price + '</span>' +
                                '<div class="ofr">' +
                                '<div class="new_price">' +
                                '<p class="pric1">' + jsonData.sorted[i].salePrice + '</p>' +
                                '</div>' +
                                '<div class="perfum_available_ml">' +
                                    /*'<select name="perfum_available_ml">' +
                                        '<option value="100,20,80">' +
                                        '220 ml' +
                                        '</option>' +
                                        '<option value="1000,499,51">' +
                                        '2200 ml' +
                                        '</option>' +
                                    '</select>' +*/
                                '</div>' +
                                '<div class="clearfix"> </div>' +
                                '</div>' +
                                '<input type="number" class="item_quantity" min="1" max="' + jsonData.sorted[i].quantity + '" options-quantity="" value="1">' +
                                '<button href="javascript:void(0);" class="item_add add-to-cart products-page-add">' +
                                '<span class="glyphicon glyphicon-shopping-cart"></span>' +
                                '<div style="display:none;">' +
                                '<!--<img src="images/m1.jpg" class="img-responsive" alt="">-->' +
                                '</div>' +
                                '</button>' +
                                '<div class="clearfix"> </div>' +
                                '</div>' +
                            '</div>';

                        var quantityArr = [];
                        var isSaleOptionAvailable = false;
                        var select = $("<select name=\"perfum_available_ml\" />");
                        for(var j in jsonData.sorted[i].options) {
                            quantityArr.push(jsonData.sorted[i].options[j].quantity);
                            $("<option />", {value: 
                                                jsonData.sorted[i].options[j].sale_price != 0 
                                                     ? jsonData.sorted[i].options[j].price + '-' +
                                                             jsonData.sorted[i].options[j].sale_price + 
                                                             '-' + jsonData.sorted[i].options[j].off_percentage 
                                                     
                                                     : jsonData.sorted[i].options[j].price, 
                                                     
                                            text: jsonData.sorted[i].options[j].ml + ' ml'})
                                                .appendTo(select);

                            if(jsonData.sorted[i].options[j].sale_price != 0) {
                                isSaleOptionAvailable = true;
                            }
                        }
                        
                        
                       
                        var child = '';

                        // additional check for is sale option remaining after filter some of the options
                        // because the global jsonData.sorted[i].is_sale may not be valid after the filtering

                        if(jsonData.sorted[i].is_sale == 1 && isSaleOptionAvailable == true) {
                            
                           if(jsonData.sorted[i].percentage < 30) {
                                child = '<div class="b-wrapper_sale">'
                                    +'<div>SALE</div>'
                                    +'</div>';
                            }
                            else {
                                child = '<div class="b-wrapper_percent_off">'
                                    +'<div>' + jsonData.sorted[i].percentage + ' %<br>OFF</div>'
                                    +'</div>';
                            }

                            // to represent select value correctly remove everything except numbers,dot,comma and -
                            var valueToShowOnLoad = (jsonData.sorted[i].price + '-' + jsonData.sorted[i].salePrice + '-' + jsonData.sorted[i].percentage).replace(/[^0-9.,-]/g, "");
                            //console.log(valueToShowOnLoad);
                            select.val(valueToShowOnLoad);
                        }
                        else {
                         
                            // to represent select value correctly remove everything except numbers,dot,comma and -
                            var valueToShowOnLoad = (jsonData.sorted[i].price).replace(/[^0-9.,-]/g, "");
                            //console.log(valueToShowOnLoad);
                            select.val(valueToShowOnLoad);
                        }
                        
                        productDiv.append(productDivContents);
                        
                        var optionsQuantity = quantityArr.join(',');
                        productDiv.find('.item_quantity').attr('options-quantity', optionsQuantity); 

 
                        productDiv.find('.product-img.b-link-stripe.b-animate-go.thickbox').prepend(child);
                        productDiv.find('.perfum_available_ml').prepend(select);
                        $('.col-md-9, .product-model-sec').append(productDiv);
                    }
                    
                    if(jsonData.nextPageProductsCount > 0) {
                        $('.loadFilteredProducts').show();
                    }
                    else {
                        $('.loadFilteredProducts').hide();
                    }
                }
                else {
                    //console.log('ajax fail');
                    var h4 = '<h4 class="noFilterProducts">There are no products matching your filter settings!</h4>';
                    $('.col-md-9, .product-model-sec').html(h4);
                    
                    $('.loadFilteredProducts').hide();
                }
                
                $('#notFoundProducts').remove();
                
                getUrlBrands('', document.URL);
                // select filter brands after header brads search!
                
                $('#loader').remove();
            }
        });
    }


    // ------------------ CART ---------------------

    if(localStorage.getItem("currentCart") == null) {
        
        var cartItems = [];
    }
    else {
        var cartItems = JSON.parse(localStorage.getItem("currentCart"));
    }
    
    if(localStorage.getItem("itemQuantity") == null) {
        
        var itemCountity = 0;
    }
    else {
        var itemCountity = parseInt(localStorage.getItem("itemQuantity"));
    }

    var cartTotal = localStorage.getItem("currentShoppingCarTotal");
    
    if(cartTotal != null && cartTotal != 0 ) {
        $('.simpleCart_total').text(' €' + cartTotal + '.00 ');
    }
    
    if(localStorage.getItem("itemQuantity") != null) {

        $('#simpleCart_quantity').text(' ' + localStorage.getItem("itemQuantity") + ' ');
    }

    $('body').on('click', '.single-page-add', function() {
        var selectedOptionPrice = $('input[name=perfume_ml]:checked').val();
        selectedOptionPrice = parseFloat(selectedOptionPrice);
        
        var productId =  $('#productAttrId').attr('attr-id');
        var productName =  $('.simpleCart_shelfItem h3:first').text();
        var orderml =  $('.available_options input:checked').next().text();
        var label =  $('.available_options input:checked').parent();
        var optionPrice = '';
        
        if(label.find('.salePrice').length > 0) {
            optionPrice = label.find('.salePrice').text();
        }
        else {
            optionPrice = label.find('.originalPrice').text();
        }
        
        var totalPriceMl = $('#finalPrice').text();
        var qty = $('.qty_add_to_cart #quantity').val();
        var imageSrc = $('.flexslider ol').find('li img').attr('src').split('/').pop();
        var productLink = document.URL;
        
        var selectedProductObj = {
            user_id: 0,
            product_id: productId,
            product_name: productName,
            order_ml: orderml,
            option_price: optionPrice,
            order_date: 0,
            total_price_ml: totalPriceMl,
            qty: qty,
            image_src: imageSrc,
            product_link: productLink
        };
        
         addToCart(selectedProductObj, qty, selectedOptionPrice);

    });    
    
    $('body').on('click', '.products-page-add', function() {
        var selectedOptionPrice = $(this).parent().find('select[name=perfum_available_ml] option:selected').val();
        
        var selectedOptionPriceSplited = selectedOptionPrice.split('-')[1];
        
        if(typeof selectedOptionPriceSplited !== 'undefined') {
            selectedOptionPrice = selectedOptionPriceSplited;
        }       
      
        selectedOptionPrice = parseFloat(selectedOptionPrice);
        
        var productGrid =  $(this).parents('.product-grid');
        
        var productId =  productGrid.attr('attr-id');
        var productName =  productGrid.find('.prt_name h4:first').text();
        var orderml = productGrid.find('select[name=perfum_available_ml] option:selected').text();
            orderml = orderml.replace(/[^0-9\.]+/g, '');
        var optionPrice = selectedOptionPrice;
        var qty = productGrid.find('.item_quantity').val();
        var totalPriceMl = optionPrice * parseInt(qty);
        
        var imageSrc = productGrid.find('.img-responsive').attr('src').split('/').pop();
        var productLink = productGrid.find('a').attr('href');
        
        var selectedProductObj = {
            user_id: 0,
            product_id: productId,
            product_name: productName,
            order_ml: orderml,
            option_price: optionPrice,
            order_date: 0,
            total_price_ml: totalPriceMl,
            qty: qty,
            image_src: imageSrc,
            product_link: productLink
        };
        
        console.log(selectedProductObj);
        addToCart(selectedProductObj, qty, selectedOptionPrice);
    });    
    
    function addToCart(productObj, productQty, selectedOptionPrice) {
        var intQty = parseInt(productQty);

        itemCountity += intQty;
        
        
        // check if exist product with same ml just ++ qty and calc price
        updateExistIsSameProduct(productObj);
        
       
        var currentShoppingCarTotal = $('.simpleCart_total').text();
        currentShoppingCarTotal = parseFloat(currentShoppingCarTotal.replace(/[^0-9\.]+/g,""));

        // variables are stored as strings in localStorage no matter what data type they are before that
        // remember to parse them after localStorage.getItem if needed
        localStorage.setItem( "currentShoppingCarTotal", currentShoppingCarTotal + (selectedOptionPrice * intQty) );
        
        $('.simpleCart_total').text(' €' + (currentShoppingCarTotal + (selectedOptionPrice * intQty)) + ' ');
        
        localStorage.setItem( "itemQuantity", itemCountity );
        
        $('#simpleCart_quantity').text(' ' + itemCountity + ' ');
        
        var cartItemsString = JSON.stringify( cartItems );

        console.info(cartItems);
        localStorage.setItem( "currentCart", cartItemsString );
    }
    
    function updateExistIsSameProduct(productObj) {
        var storage = JSON.parse(localStorage.getItem('currentCart'));
        var isExisting = false; 
        
        for(var i in storage) {
            if(productObj.order_ml === storage[i].order_ml &&
               productObj.product_id === storage[i].product_id ) {
                  isExisting = true;
                  
                  storage[i].total_price_ml = 
                          parseFloat(storage[i].total_price_ml) + ( parseFloat(productObj.option_price ) * parseInt(productObj.qty ));
                 storage[i].qty = parseInt(storage[i].qty) + parseInt(productObj.qty);
                // we have match
               }
        }
        
       
        
        if(!isExisting) {
            cartItems.push(productObj);
        }
        else {
            cartItems = storage;
        }
    }
    
    $('body').on('click', '.simpleCart_empty', function() {
        itemCountity = 0;
        localStorage.clear();
        cartItems = [];
        
        $('.cart-header').fadeOut('slow', function(){
            $('.cart-header').remove();
        });
        
        updateChekoutInfo(0, 0, 'No delivery cost!');
        
    });
    
    $('.container').on('click', '.removeCartProduct', function(){
        var position = $(this).attr('cart-position');
        var localStorageCart= JSON.parse(localStorage.getItem('currentCart'));
        
        var deletedObject = localStorageCart.splice(position, 1);
        
        
        $(this).parent().fadeOut('slow', function(){
            $(this).remove();
            
            
            var cartItemQty = parseInt(localStorage.getItem('itemQuantity')) - parseInt(deletedObject[0].qty);
            var currentShoppingCarTotal = parseFloat(localStorage.getItem('currentShoppingCarTotal')) - parseFloat(deletedObject[0].total_price_ml);
                    
                    
            console.info(cartItemQty, currentShoppingCarTotal);
            var delivery = '';
            if(currentShoppingCarTotal > 30) {

              delivery = 'No delivery cost!';
            }
            else
            {
              delivery = '€10';
            }
            updateChekoutInfo(cartItemQty, currentShoppingCarTotal, delivery);

            localStorage.setItem('currentCart', JSON.stringify( localStorageCart ));
            localStorage.setItem('itemQuantity', cartItemQty);
            localStorage.setItem('currentShoppingCarTotal', currentShoppingCarTotal);
            
            console.info('localStorage', localStorageCart);

        });
    });
    
    
    if(document.URL.indexOf('checkout') > - 1) {
        
        var carItemQty = parseInt(localStorage.getItem("itemQuantity"));
        var currentShoppingCarTotal = parseFloat(localStorage.getItem("currentShoppingCarTotal"));
        var currentCarArr = JSON.parse(localStorage.getItem("currentCart"));
        
        for(var i in currentCarArr) {
            console.info(i);
            var productDiv =                
                    '<div class="cart-header">' +
                    '<div class="removeCartProduct" cart-position="' + i + '"> </div>' +
                    '<div class="cart-sec simpleCart_shelfItem">' +
                        '<div class="cart-item cyc">' +
                            '<img src="'+ thumbsPath + '/' +  currentCarArr[i].image_src +'" class="img-responsive" alt="">' +
                        '</div>' +
                        '<div class="cart-item-info">' +
                            '<h3><a target="_blank" href="' + currentCarArr[i].product_link + '"><span class="selectedProductName">' + currentCarArr[i].product_name + '</span></a><!-- span>Pickup time:</span --></h3>' +
                            '<div class="delivery delivery_details" style="background:yello;">' +
                                '<div>' +
                                    '<span>Quantity :</span> <span class="selectedQtyOption">' + currentCarArr[i].qty + '</span>' +
                                    '<div class="clearfix"></div>' +
                                '</div>' +
                                '<div>' +
                                    '<span>ML :</span>' +
                                    '<span class="selectedMlOption">' + currentCarArr[i].order_ml + '</span>' +
                                    '<div class="clearfix"></div>' +
                                '</div>' +
                                '<div>' +
                                    '<span>Single Price :</span> <span class="selectedProductPrice">' + currentCarArr[i].option_price + '</span>' +
                                    '<div class="clearfix"></div>' +
                                '</div>' +
                                '<div class="clearfix"></div>' +
                                '<div>' +
                                    '<span>Total product price :</span> <span class="selectedProductTotal">' + currentCarArr[i].total_price_ml + '</span>' +
                                    '<div class="clearfix"></div>' +
                                '</div>' +
                                '<div class="clearfix"></div>' +
                            '</div>' +
                        '</div>' +
                        '<div class="clearfix"></div>' +
                    '</div>' +
                '</div>';
        
            $('#checkoutForm').prepend(productDiv);
        }
        
        carItemQty = isNaN(carItemQty) ? 0 : carItemQty;
        currentShoppingCarTotal = isNaN(currentShoppingCarTotal) ? 0 : currentShoppingCarTotal;
        
console.log(currentShoppingCarTotal > 30);
        var delivery = '';
        if(currentShoppingCarTotal > 30) {

          delivery = 'No delivery cost!';
        }
        else
        {
          delivery = '€10';
        }
console.log(delivery);
        updateChekoutInfo(carItemQty, currentShoppingCarTotal, delivery);

        if(currentShoppingCarTotal > 0 == false) {

            $('#confirmOrderSubmit').prop({
                disabled: true
            });
        }
    }
    
    function updateChekoutInfo(carItemQty, currentShoppingCarTotal, delivery) {
        currentShoppingCarTotal = currentShoppingCarTotal === 0 ? currentShoppingCarTotal + '.00' : currentShoppingCarTotal;
        $('.simpleCart_total').text('€' + currentShoppingCarTotal);
        currentShoppingCarTotal = parseFloat(currentShoppingCarTotal);
        
        //console.info(currentShoppingCarTotal);
        // update header cart info
        
        $('#simpleCart_quantity').text(' ' + carItemQty + ' ');
        
        
        $('#checkoutCarQty').text(carItemQty);
        $('#checkoutProductsPrice').text('€' + currentShoppingCarTotal);
        $('#checkoutDeliveryPrice').text(delivery);
        if(delivery == '€10'){
            $('#checkoutTotalPrice').text('€' + (currentShoppingCarTotal + 10));
        }
        else {
            $('#checkoutTotalPrice').text('€' + currentShoppingCarTotal);
        }
        // update info order
    }
    
    
    $('#continueShoppingBtn').on('click', function(){
        
        window.location = baseUrlJS + '/products';
    });

    // ---------------- CART END -------------------

    if(document.URL.indexOf('confirmAddress') > - 1) {

        var carItemQty = parseInt(localStorage.getItem("itemQuantity"));
        var currentShoppingCarTotal = parseFloat(localStorage.getItem("currentShoppingCarTotal"));
        var currentCarArr = JSON.parse(localStorage.getItem("currentCart"));

        for(var i in currentCarArr) {
            var productNum = parseInt(i) + 1;
            var productOrderDiv = createProductContainer(currentCarArr, productNum);
            var hiddenProduct = crateHiddenProduct(currentCarArr, productNum);
                
            $('.confirm_products').append(productOrderDiv);
            $('#formPaypal').append(hiddenProduct);
        }

        carItemQty = isNaN(carItemQty) ? 0 : carItemQty;
        currentShoppingCarTotal = isNaN(currentShoppingCarTotal) ? 0 : currentShoppingCarTotal;

        var delivery = '';
        if(currentShoppingCarTotal > 30) {

          delivery = 'No delivery cost!';
          $('input[name="deliveryHiddenInput"]').val(0);
        }
        else
        {
          delivery = '€10';
          $('input[name="deliveryHiddenInput"]').val(10);
        }
        updateChekoutInfo(carItemQty , currentShoppingCarTotal, delivery);        

        $('.registerBtn').on('click', function(){

            window.location = baseUrlJS + '/login';
        });

        $('#payAsGuestTab').addClass('activeTab');
    }
    
    function crateHiddenProduct(currentCarArr, productNum) {
        var child = 
        '<input type="hidden" name="item_number_' + productNum + '" value="' + currentCarArr[i].product_id + '">' +
        '<input type="hidden" name="item_name_' + productNum + '" value="' + currentCarArr[i].product_name + '">' +
        '<input type="hidden" name="amount_' + productNum + '" value="' + currentCarArr[i].option_price + '">' +
        '<input type="hidden" name="quantity_' + productNum + '" value="' + currentCarArr[i].qty + '">' +
        '<input type="hidden" name="on0_' + productNum + '" value="Ml">' +
        '<input type="hidden" name="os0_' + productNum + '" value="' + currentCarArr[i].order_ml + '">' +
        '<input type="hidden" name="on1_' + productNum + '" value="Image">' +
        '<input type="hidden" name="os1_' + productNum + '" value="' + currentCarArr[i].image_src + '">';

        return child;
    }
    
    
    function createProductContainer(currentCarArr, productNum) {
       var product =  '<div class="confirm_products_single">' +

                '<div class="confirm_order_single_pr_number float_left">#: <b>' + productNum + '</b><span class="devider_vertical_line">|</span></div>' +

                '<div class="confirm_order_single_pr_image float_left"><img src="'+ thumbsPath + '/' +  currentCarArr[i].image_src +'"><span class="devider_vertical_line">|</span></div>' +

                '<div class="confirm_order_single_pr_name float_left">PRODDUCT: <b><span>' + currentCarArr[i].product_name + '</span></b><span class="devider_vertical_line">|</span></div>' +

                '<div class="confirm_order_single_pr_ml float_left">ML: <b>' + currentCarArr[i].order_ml + '</b><span class="devider_vertical_line">|</span></div>' +

                '<div class="confirm_order_single_pr_quantity float_left">QUANTITY: <b>' + currentCarArr[i].qty + '</b><span class="devider_vertical_line">|</span></div>' +

                '<div class="confirm_order_single_pr_singlr_price float_left">SINGLE PRICE: <b>€' + currentCarArr[i].option_price + '</b></div>' +

                '<div class="clearfix"></div>' +
                
            '</div>';
    
    return product;
    }
    
    function letsCheckAddress() {
        if($('#payAsGuestTab').length > 0) {
            return loopCheck('.show_shipping_info input');
          
            // not logged check
        }
        
        var errors = [];
        
        $('.tableInformation').each(function() {
            if($.trim($(this).text()) === '') {
                errors.push(1);
            }
        });
        
        if(errors.length > 0) {
                if($('.overMessage').length === 0) {
                    checkIsCorrect('.shipping_information_table table');
                }
                
               return false;

            }
            
         return true;
        
        
        // logged check
        
    }
    
    function checkIsCorrect(selector) {
        $(selector).addClass('inputError');
                    $('body').prepend('<div class="overMessage">Please fill all address data!</div>');
                    setTimeout(function() {
                       $('.overMessage').remove(); 
                    }, 4000);
    }
    
    function loopCheck(selector) {
        var errors = [];
        
        $(selector).each(function() {
                errors = deepCheck(errors, $(this));
                // check curent error field
        });
            
        if(errors.length > 0) {
            $('input').removeClass('inputError');
            checkIsCorrect('input[name="' + errors[0] + '"]'); // send 
            
            return false;
        }

        return true;
    }
    
    function deepCheck(errors, that) {
         var patern =  /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // email patern
         var statment = true;
         
         if(that.attr('type') === 'email') {
            statment = patern.test(that.val());
            // check if valid email
         }
        
         if(that.val() === '' || !statment) {
              errors.push(that.attr('name'));
         }
         
         
         return errors;
    }
    
    function localStorageCheck() {
       var isAllow =  localStorage.getItem("currentCart") &&
                      localStorage.getItem("itemQuantity") && 
                      localStorage.getItem("currentShoppingCarTotal");
              
      return isAllow;
    }
    
    function isAllowedPayment() {
        var isAllow = localStorageCheck();

        if(isAllow != null && letsCheckAddress()) {

            $('input').removeClass('inputError');
            
            return true;
        }

        return false;
        
    }
    
    $('.container').on('submit', '#goToPaymentsForm', function(e){
        if(!isAllowedPayment()) {
            e.preventDefault();
        }

    });

    if(document.URL.indexOf('payment') > - 1) {
        
        if(localStorageCheck() == null) {
            window.open(baseUrlJS, '_self');
            
            // fuck you dude, I ain't your mama :D
            return false;
        }

        var currentShoppingCarTotal = parseFloat(localStorage.getItem("currentShoppingCarTotal"));
        currentShoppingCarTotal = isNaN(currentShoppingCarTotal) ? 0 : currentShoppingCarTotal;

        if(currentShoppingCarTotal > 30) {

          $('#paymentTotal').text(currentShoppingCarTotal);
        }
        else
        {
          var totalPayment = currentShoppingCarTotal + 10;
          $('#paymentTotal').text(totalPayment);
        }
        

        var currentCarArr = JSON.parse(localStorage.getItem("currentCart"));

        for(var i in currentCarArr) {
            var productNum = parseInt(i) + 1;
            var hiddenProduct = crateHiddenProduct(currentCarArr, productNum);

            $('#formPaypal').append(hiddenProduct);
            $('#formPaypalCard').append(hiddenProduct);
        }
    }
    
    if(document.URL.indexOf('successPayment') > - 1) {

        localStorage.removeItem("currentCart");
        localStorage.removeItem("currentShoppingCarTotal");
        localStorage.removeItem("itemQuantity");

        updateChekoutInfo(0, 0, 'No delivery cost!');        
    }    
    
    // subscription email
}); 
// ready end