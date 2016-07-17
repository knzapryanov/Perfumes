<!-- checkout -->

<div class="content">

    <div class="cart-items">

        <div class="container">

            <h2>My Shopping Bag (<span id="checkoutCarQty"></span>)</h2>
            
            <form method="POST" action="<?= base_url('confirmAddress') ?>" id="checkoutForm">

                <div class="confitm_order">

                    <div>Products Price: <span id="checkoutProductsPrice"></span></div>

                    <div>Delivery: <span id="checkoutDeliveryPrice"></span></div>

                    <div>Total: <span id="checkoutTotalPrice"></span></div><BR/>

                    <input type="button" value="CONTINUE SHOPPING" id="continueShoppingBtn" /><BR/><BR/><BR/>

                    <input type="submit" value="Confirm Address" />

                    <div class="clearfix"></div>

		</div>
                
            </form>

        </div>

    </div>

</div>
