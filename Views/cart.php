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
    // print_r($cartItems);
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
    $order = new OrderController;
    try {
        $orderId = $order->createOrder($currentUser->id);
        $order->addToOrder($orderId, $cartItems, $currentUser);
        header("Location: checkout.php?orderid=" . $orderId);
    } catch (Exception $e) {
        // echo "<div class=\"alert alert-success\" role=\"alert\">order not created successfully</div>";
        echo 'Message: ' . $e->getMessage();
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
                            <th scope="col">Product Image</th>
                            <th scope="col">Name</th>
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
                                    <img src="<?php echo $item["image"] ?>" width="150" alt="">
                                </td>
                                <td>
                                    <p><?php echo $item["name"] ?></p>
                                </td>
                                <td>
                                    <h5>$<?php echo $item["start_price"] ?></h5>
                                </td>
                                <td>
                                    <h5><?php echo $item["quantity"] ?></h5>
                                </td>
                                <td>
                                    <h5>$<?php echo $item["start_price"] * $item["quantity"] ?></h5>
                                </td>
                                <td>
                                    <a class="btn btn-danger" href="cart.php?id=<?php echo $item["id"] ?>">Remove</a>

                                </td>
                            </tr>
                        <?php
                        }
                        ?>

                        <tr class="out_button_area">
                            <td class="d-none-l">

                            </td>
                            <td class="">

                            </td>
                            <td>

                            </td>
                            <td>
                                <div class="checkout_btn_inner d-flex align-items-center">
                                    <a class="gray_btn" href="./products.php">Continue Shopping</a>
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