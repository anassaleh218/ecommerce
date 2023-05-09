<?php
require_once '../Controller/ProductController.php';
require_once '../Controller/CartController.php';
require_once '../Controller/Authcontroller.php';
require_once '../Controller/OrderController.php';


if (session_status() === PHP_SESSION_NONE) {
  session_start();
}



//// check if user is login ////
$auth = new AuthController;
if ($auth->getCurrentUser() != false) {
  $userId=$auth->getCurrentUser()->id;
  $order=new OrderController;
  $bills=$order->getAllBills($userId);
} else {
  if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }
  $_SESSION["errMsg"] =  "you must login or regester first";
  header("location: ../Views/login.php");
}
////////////////////////////////

///////////////
// if (isset($_GET['orderid'])) {
//   if (!empty($_GET['orderid'])) {
//     $orderId = $_GET['orderid'];
//     $order=new OrderController;
//     $orderItems=$order->getOrderItems($orderId);
//     $orderSubtotal=$order->getOrderProductsSubtotal($orderId)[0]['subtotal'];
//     $bill=$order->getBill($orderId)[0];
//   }else{
//     header("location: ../Views/cart.php");
//   }
// }else{
//   header("location: ../Views/cart.php");
// }




///////////////
?>


<?php
require_once 'layout/header.php';
?>


<!-- ================ start banner area ================= -->
<section class="blog-banner-area" id="category">
  <div class="container h-100">
    <div class="blog-banner">
      <div class="text-center">
        <h1>My Orders</h1>
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
    <!-- <p class="text-center billing-alert">Thank you. Your order has been received.</p> -->
    <div class="row mb-5">
      <?php 
      foreach ($bills as $bill){
      ?>
      <div class="col-md-6 col-xl-4 mb-4 mb-xl-0 ">
        <div class="confirmation-card p-3 mb-3">
          <h3 class="billing-title">
          <a href="confirmation.php?orderid=<?php echo $bill["order_id"]; ?>" class="stretched-link">
            Order Info
            </a>
          </h3>
          <table class="order-rable">

            <tr>
              <td>Order number</td>
              <td>: <?php echo $bill["order_id"];?></td>
            </tr>
            <tr>
              <td>Date</td>
              <td>: <?php echo $bill["date"] ;?></td>
            </tr>
            <tr>
              <td>Order Status</td>
              <td>: <?php echo $bill["status"]?></td>
            </tr>

          </table>
        </div>
      </div>
      <?php }?>

      <!-- <div class="col-md-6 col-xl-4 mb-4 mb-xl-0">
        <div class="confirmation-card p-3">
          <h3 class="billing-title">Billing Address</h3>
          <table class="order-rable">
          <tr>
              <td>Flat No</td>
              <td>: <?php echo $bill["flatNo"] ;?></td>
            </tr>
            <tr>
              <td>Building No</td>
              <td>: <?php echo $bill["buildingNo"] ;?></td>
            </tr>
            <tr>
              <td>Street</td>
              <td>: <?php echo $bill["street"] ;?></td>
            </tr>
            <tr>
              <td>City</td>
              <td>: <?php echo $bill["city"] ;?></td>
            </tr>
            <tr>
              <td>Country</td>
              <td>: <?php echo $bill["country"] ;?></td>
            </tr>
          </table>
        </div>
      </div> -->

      <!-- <div class="col-md-6 col-xl-4 mb-4 mb-xl-0">
        <div class="confirmation-card p-2 mb-2">
          <h3 class="billing-title">Payment Details</h3>
          <table class="order-rable">
          <tr>
              <td>Credit Card Type</td>
              <td>: <?php echo $bill["credit_card_type"] ;?></td>
            </tr>
            <tr>
              <td>Credit Card Holder Name</td>
              <td>: <?php echo $bill["credit_card_holdername"] ;?></td>
            </tr>
          </table>
        </div>
        <div class="confirmation-card p-2">
          <h3 class="billing-title">Contact Details</h3>
          <table class="order-rable">
          <tr>
              <td>Phone Number</td>
              <td>: <?php echo $bill["phone"];?></td>
            </tr>
            <tr>
              <td>Email</td>
              <td>: <?php echo $bill["email"];?></td>
            </tr>
          </table>
        </div>
      </div> -->
    </div>
    <!-- <div class="order_details_table">
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
                <h4>$ <?php echo $orderSubtotal+50 ?></h4>
              </td>
            </tr>
          </tbody>
        </table>
      </div> 
    </div>-->
  </div>
</section>
<!--================End Order Details Area =================-->

<!--================ End =================-->
<?php
require_once 'layout/footer.php';
?>