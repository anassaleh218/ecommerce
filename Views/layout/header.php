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
  <link rel="stylesheet" href="asstes/vendors/fontawesome/css/all.css">
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
        <div class="container" style="min-width: 1220px;">
          <a class="navbar-brand logo_h" href="index.php"><img src="asstes/img/logo.png" alt=""></a>

          <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
            <ul class="nav navbar-nav menu_nav ml-auto mr-auto">
              <li class="nav-item active"><a class="nav-link" href="index.php">Home</a></li>

              <?php if (isset($userRole)) {
                if ($userRole == "admin") { ?>
                  <li class="nav-item"><a class="nav-link" href="admin.php">Admin</a></li>
            </ul>
        <?php }
              } ?>


        <?php if (isset($userRole)) {
          if ($userRole == "seller") { ?>
            <li class="nav-item"><a class="nav-link" href="add-product.php">Add Product</a></li>
            <li class="nav-item"><a class="nav-link" href="manage-products.php">Manage Products</a></li>
            </ul>
        <?php }
        } ?>

        <?php if (isset($userRole)) {
          if ($userRole == "buyer") { ?>
            <li class="nav-item"><a class="nav-link" href="products.php">Shop Category</a></li>

            <li class="nav-item submenu dropdown">
              <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">preferences</a>
              <ul class="dropdown-menu">
                <li class="nav-item"><a class="nav-link" href="fav-products.php">Favourites</a></li>
                <li class="nav-item"><a class="nav-link" href="watchlist.php">Watch List</a></li>
              </ul>
            </li>

            <li class="nav-item"><a class="nav-link" href="my-orders.php">My Orders</a></li>
            </ul>
            <ul class="nav navbar-nav">
              <li class="nav-item"><a href="products.php"><i class="fa-solid fa-magnifying-glass"></i></a></li>
              <li class="nav-item"><a href="cart.php"><i class="fa-solid fa-cart-shopping"></i></a></li>
            </ul>
        <?php }
        } ?>










        <?php if (!isset($userRole)) { ?>
          </ul>
          <ul class="nav navbar-nav menu_nav ml-auto mr-auto">
            <li class="nav-item"><a class="button button-header" href="login.php">Login</a></li>
            <li class="nav-item"><a class="button button-header" href="register.php">Register</a></li>
            <!-- <li class="nav-item"><a class="nav-link" href="tracking-order.php">Tracking</a></li> -->
          </ul>

        <?php } ?>

        <!-- <li class="nav-item"><button><a href="cart.php"><i class="ti-shopping-cart"></i><span class="nav-shop__circle">3</span></a></button> </li> -->
        <?php if (isset($userRole)) { ?>
          </ul>
          <ul class="nav navbar-nav menu_nav ml-auto mr-auto">
            <li class="nav-item mt-2 mr-2"><?php
                                            $buyer = new Authcontroller;
                                            $buyerName = $buyer->getCurrentUser()->fullname;
                                            echo "Hello, " . $buyerName
                                            ?> </li>
            <li class="nav-item"><a class="button button-header" href="index.php?logout">logout</a></li>
          </ul>
        <?php } ?>


          </div>
        </div>
      </nav>
    </div>
  </header>
  <!--================ End Header Menu Area =================-->