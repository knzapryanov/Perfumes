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

                                            <input type="text" name="product_name" required id="product_name" autocomplete="off">

                                    </div>

                                   <div>
                                        <span>Description<label></label></span>
                                       <textarea id="description" value=""></textarea>
                                   </div>
                                   
                                    <div>

                                           <span>Brand<label>*</label></span>

                                            <select id="brand_id">
                                                <?php
                                                    foreach($allBrandsResult as $brandObj){
                                                        ?>
                                                        <option value="<?php echo $brandObj->id; ?>">
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
                                               <option value="<?php echo $categoryObj->id; ?>">
                                                   <?php echo ucfirst($categoryObj->category_name); ?>
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
                                   
                                    <div id="containerHolderPrices"></div>
                                  
                                    <div>

                                    </div>
                                    
                                    <div>
                                        <input type="checkbox" id="addToNewest" />
                                        <label>Add to Newest Products</label>
                                    </div>
                                    
                                    <div id="overLayerManual">
                                        
                                        
                                        
                                        <span id="newLeft">NEWEST PRODUCTS</span><span id="newRight"><b id="counterNew"><?= count($manualProducts) ?></b> from 48</span>
                                        <ol>
                                            <?php if(!empty($manualProducts)) : ?>
                                                <?php foreach($manualProducts as $product) :  ?>
                                                <li>
                                                    <input type="checkbox" checked="checked" value="<?= $product['id'] ?>" />
                                                    <label><?= $product['product_name']; ?></label>
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

                                             <div class="wrap_upload" id="fixOverLay">
                                               <input name="file"  id="" class="imageInput upload_files" type="file"  />
                                               <a hre="javascript:void(0)" class="most_a">choose file</a>
                                               <span class="under">No file chosen</span>
                                               <input type="hidden" value="" class="origFile" />
                                             </div>

                                             <input type="submit" id="uploadImage" value="Upload" class="acount-btn">
                                             </form>
                                    </div>
                                    
                                   

                                    <input type="submit" id="createProduct" value="Create" class="acount-btn">

                               </div>
                </div>	
            <div class="clearfix"> </div>
            </div>
        </div>
    </div>

</div>

<!-- login -->