<!--contact-->

<div class="content">
    <div class="main-1">
        <div class="container">
            <div class="account_grid">
                <div class="col-md-6 login-right">

                        <h3>Create New Brand</h3>
                               <form action="javasctipt:void(0)" method="POST"  id="formBrand">
                                    <div>

                                            <span>Brand Name<label>*</label></span>

                                            <input type="text" name="brand_name" required id="brand_name" autocomplete="off">

                                    </div>

                                    <div>

                                           <span>Brand<label></label></span>
                                              <ol id="brandPageOl">
                                                  
                                            
                                            <?php if(!empty($allBrandsResult)) : ?>
                                                  
                                                 <?php    foreach($allBrandsResult as $brandObj) {
                                                        ?>
                                                  
                                                    <li>
                                                        <a href="javascript:void(0)" class="brandId" attr-id="<?= $brandObj->id ?>">X</a>
                                                        <label><?= ucfirst($brandObj->brand_name); ?></label>
                                                    </li>
                                                     
                                                        <?php
                                                    }  
                                                 ?>  
                                                    
                                           <?php else : ?>
                                                <li>No added Brands!</li>
                                           <?php endif; ?>   
                                               
                                           
                                        </ol>

                                    </div>

                                    <div>

                                       
                                    
                                   


                               </div>
                      <input type="submit" id="createBrand" value="Create" class="acount-btn">

                </form>	
            <div class="clearfix"> </div>
            </div>
        </div>
    </div>

</div>

<!-- login -->