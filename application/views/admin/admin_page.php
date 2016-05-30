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

                                        <span>Price<label>*</label></span>

                                        <input type="text" name="price" id="price" autocomplete="off"> 

                                </div>

                                <div>

                                        <span>Quantity<label>*</label></span>

                                        <input type="text" name="quntity" id="quntity" autocomplete="off"> 

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