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
    // print_r($order->addBilling($billing)); 
    // echo $orderId;
    $billing->adding($_POST['flat'], $_POST['building'],$_POST['street'], $_POST['city'], $_POST['country'], $_POST['phone'], $_POST['email'], $_POST['ccName'], $_POST['ccType'], $_POST['ccNum'], $_POST['expMonth'], $_POST['expYear'], $_POST['cvv'], $orderId, $buyerId);
    // $billing->set_flatNo($_POST['flat']);
    // $billing->set_buildingNo($_POST['building']);
    // $billing->set_city($_POST['city']);
    // $billing->set_country($_POST['country']);
    // $billing->set_phone($_POST['phone']);
    // $billing->set_email($_POST['email']);
    // $billing->set_creditCardHolderName($_POST['ccName']);
    // $billing->set_creditCardType($_POST['ccType']);
    // $billing->set_creditCardNum($_POST['ccNum']);
    // $billing->set_expMonth($_POST['expMonth']);
    // $billing->set_expYear($_POST['expYear']);
    // $billing->set_cvv($_POST['cvv']);
    // $billing->set_orderId($orderId);
    // $billing->set_buyerId($buyerId);
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
    <!-- <div class="returning_customer">
      <div class="check_title">
        <h2>Returning Customer? <a href="#">Click here to login</a></h2>
      </div>
      <p>If you have shopped with us before, please enter your details in the boxes below. If you are a new
        customer, please proceed to the Billing & Shipping section.</p>
      <form class="row contact_form" action="#" method="post" novalidate="novalidate">
        <div class="col-md-6 form-group p_star">
          <input type="text" class="form-control" placeholder="Username or Email*" onfocus="this.placeholder=''" onblur="this.placeholder = 'Username or Email*'" id="name" name="name">
          
        </div>
        <div class="col-md-6 form-group p_star">
          <input type="password" class="form-control" placeholder="Password*" onfocus="this.placeholder=''" onblur="this.placeholder = 'Password*'" id="password" name="password">
           
        </div>
        <div class="col-md-12 form-group">
          <button type="submit" value="submit" class="button button-login">login</button>
          <div class="creat_account">
            <input type="checkbox" id="f-option" name="selector">
            <label for="f-option">Remember me</label>
          </div>
          <a class="lost_pass" href="#">Lost your password?</a>
        </div>
      </form>
    </div> -->
    <!-- <div class="cupon_area">
      <div class="check_title">
        <h2>Have a coupon? <a href="#">Click here to enter your code</a></h2>
      </div>
      <input type="text" placeholder="Enter coupon code">
      <a class="button button-coupon" href="#">Apply Coupon</a>
    </div> -->
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
            <!--             
            <div class="col-md-12 form-group p_star">
              <input type="text" class="form-control" id="add1" name="add1">
              <span class="placeholder" data-placeholder="Address line 01"></span>
            </div>
            <div class="col-md-12 form-group p_star">
              <input type="text" class="form-control" id="add2" name="add2">
              <span class="placeholder" data-placeholder="Address line 02"></span>
            </div>
            <div class="col-md-12 form-group p_star">
              <input type="text" class="form-control" id="city" name="city">
              <span class="placeholder" data-placeholder="Town/City"></span>
            </div>
            <div class="col-md-12 form-group p_star">
              <select class="country_select">
                <option value="1">District</option>
                <option value="2">District</option>
                <option value="4">District</option>
              </select>
            </div>
            <div class="col-md-12 form-group">
              <input type="text" class="form-control" id="zip" name="zip" placeholder="Postcode/ZIP">
            </div>
            <div class="col-md-12 form-group">
              <div class="creat_account">
                <input type="checkbox" id="f-option2" name="selector">
                <label for="f-option2">Create an account?</label>
              </div>
            </div>
            <div class="col-md-12 form-group mb-0">
              <div class="creat_account">
                <h3>Shipping Details</h3>
                <input type="checkbox" id="f-option3" name="selector">
                <label for="f-option3">Ship to a different address?</label>
              </div>
              <textarea class="form-control" name="message" id="message" rows="1" placeholder="Order Notes"></textarea>
            </div> -->
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
            <!-- <div class="payment_item">
              <div class="radion_btn">
                <input type="radio" id="f-option5" name="selector">
                <label for="f-option5">Check payments</label>
                <div class="check"></div>
              </div>
              <p>Please send a check to Store Name, Store Street, Store Town, Store State / County,
                Store Postcode.</p>
            </div>
            <div class="payment_item active">
              <div class="radion_btn">
                <input type="radio" id="f-option6" name="selector">
                <label for="f-option6">Paypal </label>
                <img src=".asstes/img/product/card.jpg" alt="">
                <div class="check"></div>
              </div>
              <p>Pay via PayPal; you can pay with your credit card if you don’t have a PayPal
                account.</p>
            </div>
            <div class="creat_account">
              <input type="checkbox" id="f-option4" name="selector">
              <label for="f-option4">I’ve read and accept the </label>
              <a href="#">terms & conditions*</a>
            </div> -->
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