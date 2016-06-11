<!--contact-->

<div class="content">
    <div class="main-1">
        <div class="container">
            <div class="account_grid">
                <div class="col-md-6 login-right">
                         <form action="<?= base_url('admin/searchProducts') ?>" method="GET"  id="formSearch">
                                    <div>

                                            <span>Search Product<label>*</label></span>

                                            <input type="text" name="product_name" value="<?= isset($get) ? $get : '' ?>"  id="product_name" autocomplete="off">

                                    </div>
                                        <input type="submit" name="search" id="createBrand" value="Search" class="acount-btn">

                              </form>	

                                    <div id="form">
                                         <ol id="productPageOl">
                                            <?php if(!empty($products)) : ?>
                                                  
                                                 <?php    foreach($products as $product) {
                                                        ?>
                                                  
                                                    <li>
                                                        <a href="javascript:void(0)" class="deleteProduct" attr-id="<?= $product->id ?>">X</a>
                                                        <label><?= $product->product_name; ?></label>
                                                        <a href="<?= base_url('admin/editProduct').'/'.$product->id ?>" class="editProduct">edit</a> 
                                                           
                                                    </li>
                                                     
                                                        <?php
                                                    }  
                                                 ?>  
                                                    
                                           <?php else : ?>
                                                <li>No added Product!</li>
                                           <?php endif; ?>   
                                               
                                           
                                        </ol>

                                    </div>
                    
                                    <?php
                                    if(((int)$nextPage !== 0)) : ?>
                                        <div id="contMore">
                                           <div style="text-align:center;"><a href="javascript:void(0)" class="showSingle button" >Load more products</a></div>    
                                       </div>
                                   <?php endif;?>
                 
            <div class="clearfix"> </div>
            </div>
        </div>
    </div>

</div>

<!-- login -->
