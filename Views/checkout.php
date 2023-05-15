<?php
require_once '../Controller/ProductController.php';
require_once '../Controller/CartController.php';
require_once '../Controller/Authcontroller.php';
require_once '../Controller/OrderController.php';
require_once '../Models/billing.php';

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
$errMsg = "";
//// check if user is login ////////////
$auth = new AuthController;
if ($auth->getCurrentUser() != false) {
} else {
  if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }
  $_SESSION["errMsg"] =  "you must login or regester first";
  header("location: ../Views/login.php");
}
/////////////////////////////////////////

/////////////
if (isset($_GET['orderid'])) {
  if (!empty($_GET['orderid'])) {
    $orderId = $_GET['orderid'];
    $order = new OrderController;
    $orderItems = $order->getOrderItems($orderId);
    $orderSubtotal = $order->getOrderProductsSubtotal($orderId)[0]['subtotal'];
  } else {
    header("location: ../Views/cart.php");
  }
} else {
  header("location: ../Views/cart.php");
}
/////////////
$buyer = new Authcontroller;
$buyerId = $buyer->getCurrentUser()->id;
$billing = new Billing;

if (isset($_POST['flat']) && isset($_POST['building']) &&isset($_POST['street']) && isset($_POST['city']) && isset($_POST['country']) && isset($_POST['phone']) && isset($_POST['email']) && isset($_POST['ccName']) && isset($_POST['ccType']) && isset($_POST['ccNum']) && isset($_POST['expMonth']) && isset($_POST['expYear']) && isset($_POST['cvv'])) {
  if (!empty($_POST['flat']) && !empty($_POST['building']) && !empty($_POST['street']) && !empty($_POST['city']) && !empty($_POST['country']) && !empty($_POST['phone']) && !empty($_POST['email']) && !empty($_POST['ccName']) && !empty($_POST['ccType']) && !empty($_POST['ccNum']) && !empty($_POST['expMonth']) && !empty($_POST['expYear']) && !empty($_POST['cvv'])) {

    $billing->adding($_POST['flat'], $_POST['building'],$_POST['street'], $_POST['city'], $_POST['country'], $_POST['phone'], $_POST['email'], $_POST['ccName'], $_POST['ccType'], $_POST['ccNum'], $_POST['expMonth'], $_POST['expYear'], $_POST['cvv'], $orderId, $buyerId);

    if ($order->addBilling($billing)) {
         header("location: ../Views/confirmation.php?orderid=".$orderId."");
    } else {
      $errMsg = $_SESSION["errMsg"] =  "error in adding bill";
    }
  } else {
    $errMsg = $_SESSION["errMsg"];
  }
} else {
  // $errMsg = "Please fill all fields";
}

?>



<?php
require_once 'layout/header.php';
?>


<!-- ================ start banner area ================= -->
<section class="blog-banner-area" id="category">
  <div class="container h-100">
    <div class="blog-banner">
      <div class="text-center">
        <?php
        if ($errMsg != "") {
        ?>
          <div class="alert alert-danger" role="alert"><?php echo $errMsg ?></div>
        <?php
        }

        ?>
        <h1>Product Checkout</h1>
        <nav aria-label="breadcrumb" class="banner-breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Checkout</li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
</section>
<!-- ================ end banner area ================= -->


<!--================Checkout Area =================-->
<section class="checkout_area section-margin--small">
  <div class="container">
    <div class="billing_details">
      <div class="row">
        <div class="col-lg-8">
          <h3>Billing Details</h3>
          <form class="row contact_form" action="checkout.php?orderid=<?php echo $orderId; ?>" method="post">

            <div class="col-md-2 form-group p_star">
              <label class="form-label">Flat No.</label>
              <input type="number" class="form-control" name="flat" required>
            </div>
            <div class="col-md-2 form-group p_star">
              <label class="form-label">Building No.</label>
              <input type="number" class="form-control" name="building" required>
            </div>
            <div class="col-md-8 form-group p_star">
              <label class="form-label">Street</label>
              <input type="text" class="form-control" name="street" required>
            </div>
            <div class="col-md-6 form-group p_star">
              <label class="form-label">City</label>
              <input type="text" class="form-control" name="city" required>
            </div>
            <div class="col-md-6 form-group p_star">
              <label class="form-label">Country</label>
              <input type="text" class="form-control" name="country" required>
            </div>
            <!--  -->
            <div class="col-md-6 form-group p_star">
              <label class="form-label">Phone number.</label>
              <input type="text" class="form-control" name="phone" required>
            </div>
            <div class="col-md-6 form-group p_star">
              <label class="form-label">Email Address</label>
              <input type="text" class="form-control" name="email" required>
            </div>

            <div class="col-md-12 form-group p_star">
              <label class="form-label">Credit Card Holder Name</label>
              <input type="text" class="form-control" name="ccName" required>
            </div>

            <div class="col-md-4 form-group p_star">
              <label class="form-label">Payment Method</label>
              <select class="country_select" name="ccType">
                <option value="Visa"><i class="fa-brands fa-cc-visa"></i>VISA</option>
                <option value="MasterCard">Master Card</option>
                <option value="Meeza">Meeza - Only In Egypt</option>
              </select>
            </div>
            <div class="col-md-8 form-group p_star">
              <label class="form-label">
                <i class="ti-credit-card"></i> Credit Card Number</label>
              <input type="text" class="form-control" name="ccNum" required>
            </div>
            <!--  -->
            <div class="col-md-6 form-group p_star">
              <label class="form-label d-block">Exp. Date</label>
              <input type="number" maxlength="2" class="form-control col-md-4 d-inline " name="expMonth" required>
              <h3 class="d-inline">/</h3>
              <input type="number" maxlength="2" class="form-control col-md-4 d-inline" name="expYear" required>
            </div>
            <div class="col-md-4 form-group p_star">
              <label class="form-label">CVV</label>
              <input type="number" maxlength="3" class="form-control" name="cvv" required>
            </div>
            <div class="text-center">
              <button type="submit" class="button">send</button>
            </div>
          </form>
        </div>
        <div class="col-lg-4">
          <div class="order_box">
            <h2>Your Order</h2>
            <ul class="list">
              <li><a href="#">
                  <h4>Product <span>Total</span></h4>
                </a></li>
              <?php
              foreach ($orderItems as $item) {
              ?>
                <li><a><?php echo $item['name'] ?><span class="middle">x <?php echo $item['quantity'] ?></span> <span class="last">$ <?php echo $item['total_price'] ?></span></a></li>
              <?php } ?>
            </ul>
            <ul class="list list_2">
              <li><a href="#">Subtotal <span>$ <?php echo $orderSubtotal ?></span></a></li>
              <li><a href="#">Shipping <span>Flat rate: $50.00</span></a></li>
              <li><a href="#">Total <span>$ <?php echo $orderSubtotal+50 ?></span></a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!--================End Checkout Area =================-->



<!--================ End =================-->
<?php
require_once 'layout/footer.php';
?>