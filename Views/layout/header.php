<?php
require_once '../Controller/Authcontroller.php';

//// check if user is login and admin /////
$auth = new AuthController;

if (isset($_GET['logout'])) {
  session_destroy();
}


if ($auth->getCurrentUser() != false) {
  $currentUser = $auth->getCurrentUser();
  $userRole = $auth->getUserRole($currentUser);
  // if($auth->getUserRole($currentUser) != "admin"){
  //   if (session_status() === PHP_SESSION_NONE) {
  //     session_start();
  //   }
  //   $_SESSION["errMsg"] =  "you must be Admin";
  //   header("location: ../Views/login.php");
  // }
} else {
  if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }
  // $_SESSION["errMsg"] =  "you must login or regester first";
  // header("location: ../Views/login.php");
}
/////////////////////////////////////////
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Aroma Shop - Home</title>
  <link rel="icon" href="asstes/img/Fevicon.png" type="image/png">
  <link rel="stylesheet" href="asstes/vendors/bootstrap/bootstrap.min.css">
  <link rel="stylesheet" href="asstes/vendors/fontawesome/css/all.min.css">
  <link rel="stylesheet" href="asstes/vendors/themify-icons/themify-icons.css">
  <link rel="stylesheet" href="asstes/vendors/nice-select/nice-select.css">
  <link rel="stylesheet" href="asstes/vendors/owl-carousel/owl.theme.default.min.css">
  <link rel="stylesheet" href="asstes/vendors/owl-carousel/owl.carousel.min.css">

  <link rel="stylesheet" href="asstes/css/style.css">
</head>

<body>
  <!--================ Start Header Menu Area =================-->
  <header class="header_area">
    <div class="main_menu">
      <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
          <a class="navbar-brand logo_h" href="index.php"><img src="asstes/img/logo.png" alt=""></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
            <ul class="nav navbar-nav menu_nav ml-auto mr-auto">
              <li class="nav-item active"><a class="nav-link" href="index.php">Home</a></li>
              <li class="nav-item submenu dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Shop</a>
                <ul class="dropdown-menu">
                  <li class="nav-item"><a class="nav-link" href="fav-products.php">Fav</a></li>
                  <li class="nav-item"><a class="nav-link" href="products.php">Shop Category</a></li>
                  <li class="nav-item"><a class="nav-link" href="cart.php">Shopping Cart</a></li>
                  <!-- <li class="nav-item"><a class="nav-link" href="single-product.php">Product Details</a></li> -->
                  <li class="nav-item"><a class="nav-link" href="checkout.php">Product Checkout</a></li>
                  <li class="nav-item"><a class="nav-link" href="confirmation.php">Confirmation</a></li>

                </ul>
              </li>
              <!-- <li class="nav-item submenu dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Blog</a>
                <ul class="dropdown-menu">
                  <li class="nav-item"><a class="nav-link" href="blog.php">Blog</a></li>
                  <li class="nav-item"><a class="nav-link" href="single-blog.php">Blog Details</a></li>
                </ul>
              </li> -->

              <?php if (!isset($userRole)) { ?>
                <li class="nav-item submenu dropdown">
                  <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Pages</a>
                  <ul class="dropdown-menu">
                    <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>
                    <!-- <li class="nav-item"><a class="nav-link" href="tracking-order.php">Tracking</a></li> -->
                  </ul>
                </li>
              <?php } ?>


              <?php if (isset($userRole)) {
                if ($userRole == "admin") { ?>
                  <li class="nav-item"><a class="nav-link" href="admin.php">Admin</a></li>
              <?php }
              } ?>


              <?php if (isset($userRole)) {
                if ($userRole == "seller") { ?>
                  <li class="nav-item submenu dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Seller</a>
                    <ul class="dropdown-menu">
                      <li class="nav-item"><a class="nav-link" href="add-product.php">Add Product</a></li>
                      <li class="nav-item"><a class="nav-link" href="manage-products.php">Manage Products</a></li>
                    </ul>
                  </li>
              <?php }
              } ?>


            </ul>

            <ul class="nav-shop">
              <li class="nav-item"><button><a href="products.php"><i class="ti-search"></i></a></button></li>
              <li class="nav-item"><button><a href="cart.php"><i class="ti-shopping-cart"></i></a></button> </li>
              <!-- <li class="nav-item"><button><a href="cart.php"><i class="ti-shopping-cart"></i><span class="nav-shop__circle">3</span></a></button> </li> -->
              <?php if (isset($userRole)) { ?>
                <li class="nav-item"><a class="button button-header" href="index.php?logout">logout</a></li>
              <?php } ?>

            </ul>

            <span> <?php
                    // $buyer = new Authcontroller;
                    // $buyerName = $buyer->getCurrentUser()->fullname;
                    // echo "Hello, " . $buyerName
                    ?> </span>
          </div>
        </div>
      </nav>
    </div>
  </header>
  <!--================ End Header Menu Area =================-->