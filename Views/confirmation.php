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

    $order=new OrderController;
    $orderItems=$order->getOrderItems($orderId);
    $orderSubtotal=$order->getOrderProductsSubtotal($orderId)[0]['subtotal'];
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
        <h1>Order Confirmation</h1>
        <nav aria-label="breadcrumb" class="banner-breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Shop Category</li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
</section>
<!-- ================ end banner area ================= -->

<!--================Order Details Area =================-->
<section class="order_details section-margin--small">
  <div class="container">
    <p class="text-center billing-alert">Thank you. Your order has been received.</p>
    <div class="row mb-5">
      <div class="col-md-6 col-xl-4 mb-4 mb-xl-0">
        <div class="confirmation-card">
          <h3 class="billing-title">Order Info</h3>
          <table class="order-rable">
            <tr>
              <td>Order number</td>
              <td>: <?php echo $orderId?></td>
            </tr>
            <tr>
              <td>Date</td>
              <td>: Oct 03, 2017</td>
            </tr>
            <tr>
              <td>Total</td>
              <td>: $<?php echo $orderSubtotal?></td>
            </tr>
            <tr>
              <td>Payment method</td>
              <td>: Check payments</td>
            </tr>
          </table>
        </div>
      </div>
      <div class="col-md-6 col-xl-4 mb-4 mb-xl-0">
        <div class="confirmation-card">
          <h3 class="billing-title">Billing Address</h3>
          <table class="order-rable">
            <tr>
              <td>Street</td>
              <td>: 56/8 panthapath</td>
            </tr>
            <tr>
              <td>City</td>
              <td>: Dhaka</td>
            </tr>
            <tr>
              <td>Country</td>
              <td>: Bangladesh</td>
            </tr>
            <tr>
              <td>Postcode</td>
              <td>: 1205</td>
            </tr>
          </table>
        </div>
      </div>
     
    </div>
    <div class="order_details_table">
      <h2>Order Details</h2>
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">Product</th>
              <th scope="col">Quantity</th>
              <th scope="col">Total</th>
            </tr>
          </thead>
          <tbody>
          <?php
                foreach($orderItems as $item){
                ?>
            <tr>
              <td>
                <p><?php echo $item['name'] ?></p>
              </td>
              <td>
                <h5>x <?php echo $item['quantity'] ?></h5>
              </td>
              <td>
                <p>$ <?php echo $item['total_price'] ?></p>
              </td>
            </tr>
<?php }?>
            <tr>
              <td>
                <h4>Subtotal</h4>
              </td>
              <td>
                <h5></h5>
              </td>
              <td>
                <p>$ <?php echo $orderSubtotal ?></p>
              </td>
            </tr>
            <tr>
              <td>
                <h4>Shipping</h4>
              </td>
              <td>
                <h5></h5>
              </td>
              <td>
                <p>Flat rate: $50.00</p>
              </td>
            </tr>
            <tr>
              <td>
                <h4>Total</h4>
              </td>
              <td>
                <h5></h5>
              </td>
              <td>
                <h4>$2210.00</h4>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
<!--================End Order Details Area =================-->

<!--================ End =================-->
<?php
require_once 'layout/footer.php';
?>