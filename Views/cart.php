<?php
require_once '../Controller/Authcontroller.php';
require_once '../Controller/CartController.php';
require_once '../Controller/OrderController.php';

//// check if user is login  /////
$auth = new AuthController;
$cart = new CartController;
$order = new OrderController;




//// remove from cart  /////
if (isset($_GET['id'])) {
    if (!empty($_GET['id'])) {
        $id = $_GET['id'];
        $cart->removeFromCart($id);
        echo "<div class=\"alert alert-success\" role=\"alert\">removed successfully</div>";
    }
}
//////////////////////////

if ($auth->getCurrentUser() != false) {
    $currentUser = $auth->getCurrentUser();
    $cartItems = $cart->getCartItems($currentUser);
} else {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $_SESSION["errMsg"] =  "you must login or regester first";
    header("location: ../views/login.php");
}
///////////////////////////////////

// open cart when press on "procceed checkout"
// create order in the cart page add fill with the items in the cart
// in the checkout page get orderid which is created and getting this order data

if (isset($_GET['add'])) {

    $order= new OrderController;
    
    try {
        $orderId=$order->createOrder($currentUser->id);
        $order->addToOrder($orderId,$cartItems,$currentUser);
        // $_SESSION["orderid"] =$orderId;
        header("Location: checkout.php?orderid=".$orderId);
        // echo $orderId;
        // echo "<div class=\"alert alert-success\" role=\"alert\">order created successfully</div>";
    } catch (Exception $e) {
        echo "<div class=\"alert alert-success\" role=\"alert\">order not created successfully</div>";
        // echo 'Message: ' . $e->getMessage();
    }

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

}


// $orderId=$order->createOrder($currentUser->id);

?>

<?php
require_once 'layout/header.php';
?>


<!-- ================ start banner area ================= -->
<section class="blog-banner-area" id="category">
    <div class="container h-100">
        <div class="blog-banner">
            <div class="text-center">
                <h1>Shopping Cart</h1>
                <nav aria-label="breadcrumb" class="banner-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        
                        <li class="breadcrumb-item active" aria-current="page">Shopping Cart</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- ================ end banner area ================= -->



<!--================Cart Area =================-->
<section class="cart_area">
    <div class="container">
        <div class="cart_inner">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Product</th>
                            <th scope="col">Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total</th>
                            <th scope="col">Remove</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($cartItems as $item) {
                        ?>
                            <tr>
                                <td>
                                    <div class="media">
                                        <div class="d-flex">
                                            <img src=".asstes/img/cart/cart1.png" alt="">
                                        </div>
                                        <div class="media-body">
                                            <p><?php echo $item["name"] ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <h5>$<?php echo $item["start_price"] ?></h5>
                                </td>
                                <td>
                                    <div class="product_count">
                                        <input type="text" name="qty" id="sst" maxlength="12" value="1" title="Quantity:" class="input-text qty">
                                        <!-- <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;" class="increase items-count" type="button"><i class="lnr lnr-chevron-up"></i></button>
                                        <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst ) &amp;&amp; sst > 0 ) result.value--;return false;" class="reduced items-count" type="button"><i class="lnr lnr-chevron-down"></i></button> -->
                                    </div>
                                </td>
                                <td>
                                    <h5>$<?php echo $item["start_price"] * 1 ?></h5>
                                </td>
                                <td>
                                    <a class="btn btn-danger" href="cart.php?id=<?php echo $item["id"] ?>">Remove</a>

                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                        <!-- <tr>
                            <td>
                                <div class="media">
                                    <div class="d-flex">
                                        <img src=".asstes/img/cart/cart2.png" alt="">
                                    </div>
                                    <div class="media-body">
                                        <p>Minimalistic shop for multipurpose use</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <h5>$360.00</h5>
                            </td>
                            <td>
                                <div class="product_count">
                                    <input type="text" name="qty" id="sst" maxlength="12" value="1" title="Quantity:" class="input-text qty">
                                    <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;" class="increase items-count" type="button"><i class="lnr lnr-chevron-up"></i></button>
                                    <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst ) &amp;&amp; sst > 0 ) result.value--;return false;" class="reduced items-count" type="button"><i class="lnr lnr-chevron-down"></i></button>
                                </div>
                            </td>
                            <td>
                                <h5>$720.00</h5>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="media">
                                    <div class="d-flex">
                                        <img src=".asstes/img/cart/cart3.png" alt="">
                                    </div>
                                    <div class="media-body">
                                        <p>Minimalistic shop for multipurpose use</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <h5>$360.00</h5>
                            </td>
                            <td>
                                <div class="product_count">
                                    <input type="text" name="qty" id="sst" maxlength="12" value="1" title="Quantity:" class="input-text qty">
                                    <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;" class="increase items-count" type="button"><i class="lnr lnr-chevron-up"></i></button>
                                    <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst ) &amp;&amp; sst > 0 ) result.value--;return false;" class="reduced items-count" type="button"><i class="lnr lnr-chevron-down"></i></button>
                                </div>
                            </td>
                            <td>
                                <h5>$720.00</h5>
                            </td>
                        </tr> -->
                        <!-- <tr class="bottom_button">
                            <td>
                                <a class="button" href="#">Update Cart</a>
                            </td>
                            <td>

                            </td>
                            <td>

                            </td>
                            <td>
                                <div class="cupon_text d-flex align-items-center">
                                    <input type="text" placeholder="Coupon Code">
                                    <a class="primary-btn" href="#">Apply</a>
                                    <a class="button" href="#">Have a Coupon?</a>
                                </div>
                            </td>
                        </tr>


                        <tr>
                            <td>

                            </td>
                            <td>

                            </td>
                            <td>
                                <h5>Subtotal</h5>
                            </td>
                            <td>
                                <h5>$2160.00</h5>
                            </td>
                        </tr>

                         -->
                        <!-- <tr class="shipping_area">
                            <td class="d-none d-md-block">

                            </td>
                            <td>

                            </td>
                            <td>
                                <h5>Shipping</h5>
                            </td>
                            <td>
                                <div class="shipping_box">
                                    <ul class="list">
                                        <li><a href="#">Flat Rate: $5.00</a></li>
                                        <li><a href="#">Free Shipping</a></li>
                                        <li><a href="#">Flat Rate: $10.00</a></li>
                                        <li class="active"><a href="#">Local Delivery: $2.00</a></li>
                                    </ul>
                                    <h6>Calculate Shipping <i class="fa fa-caret-down" aria-hidden="true"></i></h6>
                                    <select class="shipping_select">
                                        <option value="1">Bangladesh</option>
                                        <option value="2">India</option>
                                        <option value="4">Pakistan</option>
                                    </select>
                                    <select class="shipping_select">
                                        <option value="1">Select a State</option>
                                        <option value="2">Select a State</option>
                                        <option value="4">Select a State</option>
                                    </select>
                                    <input type="text" placeholder="Postcode/Zipcode">
                                    <a class="gray_btn" href="#">Update Details</a>
                                </div>
                            </td>
                        </tr> -->
                        <tr class="out_button_area">
                            <td class="d-none-l">

                            </td>
                            <td class="">

                            </td>
                            <td>

                            </td>
                            <td>
                                <div class="checkout_btn_inner d-flex align-items-center">
                                    <a class="gray_btn" href="index.php">Continue Shopping</a>
                                    <!-- <a class="primary-btn ml-2" href="./checkout.php?orderid=<?php //echo $orderId;?>&add">Proceed to checkout</a> -->
                                    <a class="primary-btn ml-2" href="cart.php?add">Proceed to checkout</a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<!--================End Cart Area =================-->

<!--================ End =================-->
<?php
require_once 'layout/footer.php';
?>