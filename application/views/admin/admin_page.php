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

                                            <input type="text" name="product_name" id="product_name" autocomplete="off">

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

                                            <span>Price<label>*</label></span>

                                            <input type="text" name="price" id="price" autocomplete="off">

                                    </div>

                                    <div>

                                            <span>Quantity<label>*</label></span>

                                            <input type="text" name="quantity" id="quantity" autocomplete="off">

                                    </div>

                                    <div>

                                       <span>Rate<label>*</label></span>

                                       <input type="text" name="rate" id="rate" autocomplete="off">

                                    </div>

                                    <div>

                                       <span>Milliliters<label>*</label></span>

                                       <input type="text" name="ml" id="ml" autocomplete="off">

                                    </div>

                                    <div>

                                        <input type="hidden" name="is_sale" value="0" />
                                        <input type="checkbox" name="is_sale" id="is_sale" value="1">Product on sale.<br>

                                        <div id="sale_price_div">
                                            <span>Sale price<label>*</label></span>
                                            <input type="text" name="sale_price" id="sale_price" autocomplete="off">
                                        </div>

                                    </div>

                                    <div>

                                       <input type="hidden" name="is_off" value="0" />
                                       <input type="checkbox" name="is_off" id="is_off" value="1">Product with off price.<br>

                                       <div id="off_price_div">
                                           <span>Off price<label>*</label></span>
                                           <input type="text" name="off_price" id="off_price" autocomplete="off">
                                       </div>

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