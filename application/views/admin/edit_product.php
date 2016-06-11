<!--contact-->

<div class="content">
    <div class="main-1">
        <div class="container">
            <div class="account_grid">
                <div class="col-md-6 login-right">
                        <h3>Create New Product</h3>
                               <div id="form">
                                    <div>

                                            <span>Name<label>*</label></span>
                                         
                                            <input type="text" name="product_name" value="<?= $product->product_name ?>" required id="product_name" autocomplete="off">

                                    </div>

                                   <div>
                                        <span>Description<label></label></span>
                                        <textarea id="description" value=""><?= $product->description ?></textarea>
                                   </div>
                                   
                                    <div>

                                           <span>Brand<label>*</label></span>

                                            <select id="brand_id">
                                                <?php
                                                    foreach($allBrandsResult as $brandObj){
                                                        ?>
                                                        <option <?= $brandObj->id === $product->brand_id ? 'selected' : '' ?> value="<?php echo $brandObj->id; ?>">
                                                             <?php echo ucfirst($brandObj->brand_name); ?>
                                                        </option>
                                                        <?php
                                                    }
                                                ?>
                                            </select>

                                    </div>

                                    <div>

                                       <span>Category<label>*</label></span>

                                       <select id="cat_id">
                                           <?php
                                           foreach($allCategoriesResult as $categoryObj){
                                               ?> 
                                               <option <?= $categoryObj->id === $product->cat_id ? 'selected' : '' ?> value="<?php echo $categoryObj->id; ?>">  
                                                 <?php  echo ucfirst($categoryObj->category_name); ?>
                                               </option>
                                               
                                               <?php
                                           }
                                           ?>
                                       </select>

                                    </div>
                                    <div>
                                                
                                       <span>ML<label>*</label></span>
                                       <div id="holdMl"> 
                                           
                                        <input type="text" name="ml" id="ml" autocomplete="off">
                                        <a href="javascript:void(0)" id="addMl">Add</a>
                                       </div> 
                                    </div>
                                   
                                   
                                    <?php foreach ($product->options as $option) : ?>
                                    <div id="containerHolderPrices">
                                      <div class="holderPrices">
                                          <div class="headerMl">
                                              <span>ML&nbsp;</span>
                                              <input type="text" value="<?= $option->ml ?>" name="ml" class="editMl" autocomplete="off">
                                              <a class="removeOption" href="javascript:void(0)">X</a>
                                          </div>
                                          
                                          <div>
                                              <span>Price<label>*</label></span>
                                              <input type="text" name="price" value="<?= $option->price ?>" class="price" autocomplete="off">
                                          </div>
                                          
                                          <div>
                                              <input type="hidden" name="is_sale" value="<?= $product->id ?>">
                                              <input type="checkbox" name="is_sale" class="is_sale" id="" value="1">
                                              <label class="fixLabel" for="">Product on sale</label><br>
                                              <div class="sale_price_div" style="<?= (int)$option->sale_price !== 0 ? 'display: block;' : 'display: none;' ?>">
                                                  <span>Sale price<label>*</label></span>
                                                  <input type="text" name="sale_price" value="<?= $option->sale_price ?>" class="sale_price" autocomplete="off">
                                                  <a class="calculateButton" href="javascript:void(0)">calculate</a>
                                                  <span>OFF Percentage<label>*</label></span>
                                                  <input type="text" name="off_percentage" value="<?= $option->off_percentage ?>" class="off_percentage" autocomplete="off">
                                              </div>
                                              
                                              <span class="qnty">Quantity<label>*</label></span>
                                              <input type="text" name="quantity" value="<?= $option->quantity ?>" class="quantity" autocomplete="off">
                                          </div>
                                      </div>
                                    </div>
                                    <!-- PRICEHOLDER END -->     
                                    <?php endforeach;?>
                                    </div>
                                    
                                    <div>
                                        <input type="checkbox" id="addToNewest" <?= $product->is_newest ? 'checked' : '' ?> />
                                        <label>Add to Newest Products</label>
                                    </div>
                                    
                                    <div id="overLayerManual">
                                        
                                        
                                        <span id="newLeft">NEWEST PRODUCTS</span><span id="newRight"><b id="counterNew"><?= count($manualProducts) ?></b> from 48</span>
                                        <ol>
                                            <?php if(!empty($manualProducts)) : ?>
                                                <?php foreach($manualProducts as $manual) :  ?>
                                                <li>
                                                    <input type="checkbox" checked="checked" value="<?= $manual['id'] ?>" />
                                                    <label><?= $manual['product_name']; ?></label>
                                                </li>
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                <li>No added products!</li>
                                            <?php endif; ?>
                                        </ol>
                                    </div>
                                    <div id="startPoint">
                                            <span>Upload Images<label></label></span>
                                            <form action="javascript:void(0)"  method="POST" enctype="multipart/form-data" id="uploadImageForm">
                                                <input type="hidden" value="<?= $product->id ?>" id="updateMethod" />           
                                             <div class="wrap_upload" id="fixOverLay">
                                               <input name="file"  id="" class="imageInput upload_files" type="file"  />
                                               <a hre="javascript:void(0)" class="most_a">choose file</a>
                                               <span class="under">No file chosen</span>
                                               <input type="hidden" value="" class="origFile" />
                                             </div>

                                             <input type="submit" id="uploadImage" value="Upload" class="acount-btn">
                                             </form>
                                        
                                            <?php foreach ($product->pictures as $picture) : ?>
                                         
                                                <div class="contImage" image-src="<?= $picture->source ?>">
                                                    <input type="hidden" class="pictureId" value="<?= $picture->id ?>" />
                                                    <img src="<?= base_url('assets/uploads/thumbs').'/'.$picture->source ?>">
                                                    <a href="javascript:void(0)" class="removeImage"></a>
                                                </div>
                                            <?php endforeach; ?>
                                    </div>
                                    
                                   

                                    <input type="submit" id="createProduct" value="Update" class="acount-btn">

                               </div>
                </div>	
            <div class="clearfix"> </div>
            </div>
        </div>
    </div>

</div>

<!-- login -->