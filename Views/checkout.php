<?php
require_once '../Controller/ProductController.php';
require_once '../Controller/CartController.php';
require_once '../Controller/Authcontroller.php';
require_once '../Controller/OrderController.php';


if (session_status() === PHP_SESSION_NONE) {
  session_start();
}


if (isset($_GET['orderid'])) {
  if (!empty($_GET['orderid'])) {


    $orderId = $_GET['orderid'];

    $order = new OrderController;
    $orderItems = $order->getOrderItems($orderId);
    $orderSubtotal = $order->getOrderProductsSubtotal($orderId)[0]['subtotal'];
  }
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
          <form class="row contact_form" action="#" method="post" novalidate="novalidate">
            <div class="col-md-6 form-group p_star">
              <label class="form-label">Flat No.</label>
              <input type="text" class="form-control" name="flat">
            </div>
            <div class="col-md-6 form-group p_star">
              <label class="form-label">Building No.</label>
              <input type="text" class="form-control" name="building">
            </div>
            <div class="col-md-6 form-group p_star">
              <label class="form-label">City</label>
              <input type="text" class="form-control" name="city">
            </div>
            <div class="col-md-6 form-group p_star">
              <label class="form-label">Country</label>
              <input type="text" class="form-control" name="country">
            </div>
            <!--  -->
            <div class="col-md-6 form-group p_star">
              <label class="form-label">Phone number.</label>
              <input type="text" class="form-control" name="phoneNumber">
            </div>
            <div class="col-md-6 form-group p_star">
              <label class="form-label">Email Address</label>
              <input type="text" class="form-control" name="email">
            </div>

            <div class="col-md-12 form-group p_star">
              <label class="form-label">Credit Card Holder Name</label>
              <input type="text" class="form-control" name="ccName">
            </div>

            <div class="col-md-4 form-group p_star">
              <label class="form-label">Payment Method</label>
              <select class="country_select">
                <option value="Visa">VISA</option>
                <option value="MasterCard">Master Card</option>
              </select>
            </div>
            <div class="col-md-8 form-group p_star">
              <label class="form-label">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-credit-card" viewBox="0 0 16 16">
                  <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v1h14V4a1 1 0 0 0-1-1H2zm13 4H1v5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V7z" />
                  <path d="M2 10a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-1z" />
                </svg> Credit Card Number</label>
              <input type="text" class="form-control" name="ccNum">
            </div>
            <!--  -->
            <div class="col-md-6 form-group p_star">
              <label class="form-label d-block">Exp. Date</label>
              <input type="number" maxlength="2" class="form-control col-md-4 d-inline " name="expMonth">
              <h3 class="d-inline">/</h3>
              <input type="number" maxlength="2" class="form-control col-md-4 d-inline" name="expYear">
            </div>
            <div class="col-md-4 form-group p_star">
              <label class="form-label">CVV</label>
              <input type="number" maxlength="3" class="form-control" name="ccv">
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
              <li><a href="#">Total <span>$2210.00</span></a></li>
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
            <div class="text-center">
              <a class="button button-paypal" href="./confirmation.php?orderid=<?php echo $orderId; ?>">Proceed to Paypal</a>
            </div>
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