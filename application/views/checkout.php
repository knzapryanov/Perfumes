<!-- checkout -->

<div class="content">

    <div class="cart-items" style="background:yello;">

        <div class="container">

            <h2>My Shopping Bag (3)</h2>



            <script>

                $(document).ready(function(c) {

                    $('.close1').on('click', function(c){

                        $('.cart-header').fadeOut('slow', function(c){

                            $('.cart-header').remove();

                        });

                    });

                });

            </script>





            <form method="POST" action="confirm_order.php">

                <div class="cart-header">

                    <div class="close1"> </div>

                    <div class="cart-sec simpleCart_shelfItem">

                        <div class="cart-item cyc">

                            <img src="images/c1.jpg" class="img-responsive" alt="">

                        </div>

                        <div class="cart-item-info">

                            <h3><a href="#">Bulgari Omnia Woman</a><!-- span>Pickup time:</span --></h3>



                            <div class="delivery delivery_details" style="background:yello;">

                                <div>

                                    <span>Quantity :</span> <input type="number" class="" min="1" value="1" />

                                    <div class="clearfix"></div>

                                </div>

                                <div>

                                    <span>ML :</span>

                                    <select name="perfum_available_ml">

                                        <option value="30">30 ml</option>

                                        <option value="50" selected>50 ml</option>

                                        <option value="100">100 ml</option>

                                    </select>

                                    <div class="clearfix"></div>

                                </div>

                                <div>

                                    <span>Single Price :</span> <span>€50.00</span>

                                    <div class="clearfix"></div>

                                </div>

                                <div class="clearfix"></div>

                            </div>

                        </div>

                        <div class="clearfix"></div>

                    </div>

                </div><!-- END cart-header -->



                <script>

                    $(document).ready(function(c) {

                        $('.close2').on('click', function(c){

                            $('.cart-header2').fadeOut('slow', function(c){

                                $('.cart-header2').remove();

                            });

                        });

                    });

                </script>



                <div class="cart-header2">

                    <div class="close2"> </div>

                    <div class="cart-sec simpleCart_shelfItem">

                        <div class="cart-item cyc">

                            <img src="images/c1.jpg" class="img-responsive" alt="">

                        </div>

                        <div class="cart-item-info">

                            <h3><a href="#">Bulgari Omnia Woman</a><!-- span>Pickup time:</span --></h3>



                            <div class="delivery delivery_details" style="background:yello;">

                                <div>

                                    <span>Quantity :</span> <input type="number" class="" min="1" value="1" />

                                    <div class="clearfix"></div>

                                </div>

                                <div>

                                    <span>ML :</span>

                                    <select name="perfum_available_ml">

                                        <option value="30">30 ml</option>

                                        <option value="50" selected>50 ml</option>

                                        <option value="100">100 ml</option>

                                    </select>

                                    <div class="clearfix"></div>

                                </div>

                                <div>

                                    <span>Single Price :</span> <span>€50.00</span>

                                    <div class="clearfix"></div>

                                </div>

                                <div class="clearfix"></div>

                            </div>

                        </div>

                        <div class="clearfix"></div>

                    </div>

                </div>



                <script>

                    $(document).ready(function(c) {

                        $('.close3').on('click', function(c){

                            $('.cart-header3').fadeOut('slow', function(c){

                                $('.cart-header3').remove();

                            });

                        });

                    });

                </script>



                <div class="cart-header3">

                    <div class="close3"> </div>

                    <div class="cart-sec simpleCart_shelfItem">

                        <div class="cart-item cyc">

                            <img src="images/c1.jpg" class="img-responsive" alt="">

                        </div>

                        <div class="cart-item-info">

                            <h3><a href="#">Bulgari Omnia Woman</a><!-- span>Pickup time:</span --></h3>



                            <div class="delivery delivery_details" style="background:yello;">

                                <div>

                                    <span>Quantity :</span> <input type="number" class="" min="1" value="1" />

                                    <div class="clearfix"></div>

                                </div>

                                <div>

                                    <span>ML :</span>

                                    <select name="perfum_available_ml">

                                        <option value="30">30 ml</option>

                                        <option value="50" selected>50 ml</option>

                                        <option value="100">100 ml</option>

                                    </select>

                                    <div class="clearfix"></div>

                                </div>

                                <div>

                                    <span>Single Price :</span> <span>€50.00</span>

                                    <div class="clearfix"></div>

                                </div>

                                <div class="clearfix"></div>

                            </div>

                        </div>

                        <div class="clearfix"></div>

                    </div>



                    <div class="confitm_order">

                        <div>Products Price: €220</div>

                        <div>Delivery: €10</div>

                        <div>Total: €230</div><BR/>

                        <input type="button" value="CONTINUE SHOPPING" /><BR/><BR/><BR/>

                        <input type="submit" value="CONFIRM ORDER" />

                        <div class="clearfix"></div>

                    </div>



                </div>

            </form>



        </div>

    </div>

</div>
