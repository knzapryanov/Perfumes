<!-- checkout -->

<div class="content">

    <div class="cart-items" style="background:yello;">

        <div class="container">

            <h2>My Shopping Bag (<span id="checkoutCarQty"></span>)</h2>
            
            <form method="POST" action="confirm_order.php" id="checkoutForm">

                <div class="confitm_order">

                    <div>Products Price: <span id="checkoutProductsPrice"></span></div>

                    <div>Delivery: <span id="checkoutDeliveryPrice"></span></div>

                    <div>Total: <span id="checkoutTotalPrice"></span></div><BR/>

                    <input type="button" value="CONTINUE SHOPPING" id="continueShoppingBtn" /><BR/><BR/><BR/>

                    <input type="submit" value="CONFIRM ORDER" />

                    <div class="clearfix"></div>

		</div>
                
            </form>

        </div>

    </div>

</div>
