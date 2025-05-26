<?php
if (!isset($_SESSION['user_id'])) {
    header("Location: login");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TESTAMENT</title>
    <link rel="icon" href="/public/assets/images/Testament_Logo.png" sizes="any">
<!--    <link rel="stylesheet" href="assets/css/homePages.css">-->
    <link rel="stylesheet" href="assets/css/footer.css">
    <link rel="stylesheet" href="assets/css/checkout.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0">
    <script type="text/javascript" src="/assets/js/homepage.js" defer></script>
    <script type="text/javascript" src="/assets/js/sidebar.js" defer></script>
    <script type="text/javascript" src="/assets/js/dashboardProducts.js" defer></script>
    <script type="text/javascript" src="/assets/js/checkoutDisplay.js" defer></script>
    <script type="text/javascript" src="/assets/js/order.js" defer></script>
</head>
<body>



<main>
    <div>
        <h1>
            <a href="/cart" style="text-decoration: none; color: inherit;">←</a>
            Checkout
        </h1>
    </div>
    <div class="checkout-container">
        <!--Order Review-->
        <div class="top-left">
            <div class="order-review-header">
                <h1 class="order-review-header"><i class="fas fa-shopping-cart"></i> ORDER REVIEW (0 ITEM)</h1>
            </div>

            <!-- This container is emptied and filled by JS -->
            <div class="order-review-container">
                <!-- Placeholder -->

            </div>

            <div class="delivery-options" id="deliveryOptions">
                <h2>Select delivery</h2>
                <div class="delivery-option selected">
                    <input type="radio" name="delivery" id="jt-express" value="jt-express" checked>
                    <label for="jt-express">
                        <img src="assets/images/jnt.png" alt="J&T Express" class="delivery-logo">

                        <span class="delivery-name">J&T Express</span>
                        <span class="delivery-time">(3-5 business days)</span>
                    </label>
                </div>
            </div>


        </div>

        <!--Delivery Address -->
        <div class="top-right">
            <h1><i class="fas fa-truck"></i> DELIVERY ADDRESS</h1>
            <div style="color: var(--light-text); font-size: 13px; margin-bottom: 15px;">All fields required</div>


            <div style="display: flex; gap: 10px;">
                <div class="form-group" style="flex: 1;">
                    <label for="firstname" class="required">First name</label>
                    <input type="text" name="firstname" id="firstname">
                </div>
                <div class="form-group" style="flex: 1;">
                    <label for="lastname" class="required">Last name</label>
                    <input type="text" name="lastname" id="lastname">
                </div>
            </div>

            <div class="form-group">
                <label for="phone" class="required">Phone</label>
                <input type="tel" id="phone">
            </div>

            <div class="form-group">
                <label for="address" class="required">Delivery address</label>
                <input type="text" id="address" placeholder="Region, Province, City, Barangay">
            </div>

            <div class="form-group">
                <input type="text" id="building" placeholder="Building, Street Name,House No,">
            </div>


            <div style="display: flex; gap: 10px;">
                <div class="form-group" style="flex: 1;">
                    <label for="zip" class="required">ZIP Code</label>
                    <input type="text" id="zip">
                </div>
            </div>
        </div>

        <!--Payment Method -->
        <div class="bottom-left">
            <h1><i class="far fa-credit-card"></i> PAYMENT METHOD</h1>
            <div class="payment-options" id="paymentOptions">
                <div class="payment-option">
                    <i class="fas fa-truck"></i> Cash on delivery
                </div>
                <div class="payment-option">
                    <i class="fab fa-paypal"></i> PayPal
                </div>
            </div>
            <input type="hidden" name="payment_method" id="payment_method" value="">
        </div>

        <!--Order Summary -->
        <div class="bottom-right">
            <div class="order-summary">
                <h2 style="margin-top: 0;">ORDER SUMMARY</h2>
                <div class="summary-item">
                    <span>1 x Phone Case - 3 Card</span>
                    <span>$29.99</span>
                </div>
                <div class="summary-item">
                    <span>Subtotal</span>
                    <span>$29.99</span>
                </div>
                <div class="summary-item">
                    <span>Shipping</span>
                    <span class="free">₱69.00</span>
                </div>


                <div class="summary-total">
                    <span>ORDER TOTAL</span>
                    <span>$32.09</span>
                </div>

            </div>
        </div>

        <button class="complete-order" id="placeOrderBtn">
            <i class="fas fa-lock"></i> PLACE ORDER
        </button>

        <div class="note">
            On signing up or placing an order, you're agreeing to our <a href="">Terms of Service and Privacy Policy.</a>
            Your payment information will be processed securely.
        </div>
    </div>

</main>

<footer>
    <?php include __DIR__ . '/../layouts/footer.php'; ?>
    <div id="toast" class="toast"></div>
</footer>
</body>
</html>