<?php
require_once '../Models/product.php';
require_once '../Controller/Authcontroller.php';
require_once '../Controller/ProductController.php';


$auth = new AuthController;
$productController = new ProductController;
$categories = $productController->getCategories();
$products = $productController->getAllProducts();


if (!isset($_SESSION["errMsg"])) {
  if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }
  if (isset($_SESSION["errMsg"])) {
    echo "<div class=\"alert alert-danger\" role=\"alert\">" . $_SESSION["errMsg"] . "</div>";
    unset($_SESSION['errMsg']);
  }
}


/////////// addtofav or  addtowatchlist ///////////
if (isset($_GET['pfid']) || isset($_GET['pwid'])) {
  if (!empty($_GET['pfid']) || !empty($_GET['pwid'])) {
    //////// if user login /////////
    if ($auth->getCurrentUser() != false) {
      $currentUser = $auth->getCurrentUser();
    } else {
      if (session_status() === PHP_SESSION_NONE) {
        session_start();
      }
      $_SESSION["errMsg"] =  "you must login or regester first";
      header("location: ../Views/login.php");
    }
    ///////////////////////////////
    /////// add to fav if addtofav is set ///////
    if (isset($_GET['addtofav'])) {
      try {
        $productController->addToFav($currentUser, $_GET['pfid']);
        echo "<div class=\"alert alert-success\" role=\"alert\">added successfully</div>";
      } catch (Exception $e) {
        echo "<div class=\"alert alert-success\" role=\"alert\">already exists in the <a href=\"fav-products.php\">Favourites Page</a></div>";
      }
    }

    /////// add to watch list if addtowatchlist is set ///////
    if (isset($_GET['addtowatchlist'])) {
      try {
        $productController->addToWatchlist($currentUser, $_GET['pwid']);
        echo "<div class=\"alert alert-success\" role=\"alert\">added successfully</div>";
      } catch (Exception $e) {
        echo "<div class=\"alert alert-success\" role=\"alert\">already exists in the <a href=\"watchlist.php\">Watch List Page</a> </div>";
      }
    }
  }
}
/////////// ////////////////////////// ///////////
?>



<?php
require_once 'layout/header.php';
?>

<!--================ Start =================-->

<main class="site-main">

  <!--================ Hero banner start =================-->
  <section class="hero-banner">
    <div class="container">
      <div class="row no-gutters align-items-center pt-60px">
        <div class="col-5 d-none d-sm-block">
          <div class="hero-banner__img">
            <img class="img-fluid" src="asstes/img/home/hero-banner.png" alt="">
          </div>
        </div>
        <div class="col-sm-7 col-lg-6 offset-lg-1 pl-4 pl-md-5 pl-lg-0">
          <div class="hero-banner__content">
            <h4>Shop is fun</h4>
            <h1>Browse Our Premium Product</h1>
            <p>Us which over of signs divide dominion deep fill bring they're meat beho upon own earth without morning over third. Their male dry. They are great appear whose land fly grass.</p>
            <a class="button button-hero" href="./products.php">Browse Now</a>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--================ Hero Carousel start =================-->
  <section class="section-margin mt-0">
    <div class="container">
      <div class="section-intro mt-4 pb-60px">
        <p>Find Popular Categories</p>
        <h2>All <span class="section-intro__style">Categories</span></h2>
      </div>
      <div class="owl-carousel owl-theme hero-carousel">
        <?php foreach ($categories as $category) {  ?>
          <div class="card text-center">
            <div class="card-footer bg-transparent border-primary">
              <a href="./category-products.php?id=<?php echo $category['id'] ?>" class="btn btn-primary w-100 p-3">Show All <b><?php echo $category['name'] ?></b></a>
            </div>
          </div>
        <?php } ?>


      </div>

    </div>

  </section>
  <!--================ Hero Carousel end =================-->



  <!-- ================ trending product section start ================= -->
  <section class="section-margin calc-60px">
    <div class="container">
      <div class="section-intro pb-60px">
        <p>Popular Item in the market</p>
        <h2>Trending <span class="section-intro__style">Product</span></h2>
      </div>
      <div class="row">
        <?php
        foreach ($products as $product) {
          // card-img
        ?>
          <div class="col-md-6 col-lg-4">
            <div class="card text-center card-product">
              <div class="card-product__img">
                <img class="" src="<?php echo $product['image'] ?>" style="width: 300px;height: 300px;object-fit: cover;" alt="<?php echo $product['name'] ?>">
                <ul class="card-product__imgOverlay">
                  <li>
                    <form action="single-product.php">
                      <input type="hidden" name="quantity" value="1">
                      <input type="hidden" name="id" value="<?php echo $product["id"]; ?>">
                      <input type="hidden" name="add" value="">
                      <button><i class="ti-shopping-cart"></i></button>
                    </form>
                  </li>
                  <li><a href="index.php?pwid=<?php echo $product["id"]; ?>&addtowatchlist"><button><i class="fa-regular fa-bookmark"></i></button></a></li>
                  <li><button><a href="index.php?pfid=<?php echo $product["id"]; ?>&addtofav"><i class="ti-heart"></i></a></button></li>
                </ul>
              </div>
              <div class="card-body">
                <p><?php echo $product['category'] ?></p>
                <h4 class="card-product__title"><a href="single-product.php?id=<?php echo $product['id'] ?>"><?php echo $product['name'] ?></a></h4>
                <p class="card-product__price">$<?php echo $product['price'] ?></p>
              </div>
            </div>
          </div>
        <?php } ?>

      </div>
    </div>
  </section>
  <!-- ================ trending product section end ================= -->


  <!-- ================ offer section start ================= -->
  <section class="offer" id="parallax-1" data-anchor-target="#parallax-1" data-300-top="background-position: 20px 30px" data-top-bottom="background-position: 0 20px">
    <div class="container">
      <div class="row">
        <div class="col-xl-5">
          <div class="offer__content text-center">
            <h3>Up To 50% Off</h3>
            <h4>Winter Sale</h4>
            <p>Him she'd let them sixth saw light</p>
            <a class="button button--active mt-3 mt-xl-4" href="./products.php">Shop Now</a>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- ================ offer section end ================= -->

  <!-- ================ Best Selling item  carousel ================= -->
  <section class="section-margin calc-60px">
    <div class="container">
      <div class="section-intro pb-60px">
        <p>Popular Item in the market</p>
        <h2>Best <span class="section-intro__style">Sellers</span></h2>
      </div>
      <div class="owl-carousel owl-theme" id="bestSellerCarousel">
        <?php
        foreach ($products as $product) {
          // card-img
        ?>

          <div class="card text-center card-product">
            <div class="card-product__img">
              <img class="img-fluid" src="<?php echo $product['image'] ?>" style="width: 300px;height: 300px;object-fit: cover;" alt="<?php echo $product['name'] ?>">
              <ul class="card-product__imgOverlay">
                <li>
                  <form action="single-product.php">
                    <input type="hidden" name="quantity" value="1">
                    <input type="hidden" name="id" value="<?php echo $product["id"]; ?>">
                    <input type="hidden" name="add" value="">
                    <button><i class="ti-shopping-cart"></i></button>
                  </form>
                </li>
                <li><a href="index.php?pwid=<?php echo $product["id"]; ?>&addtowatchlist"><button><i class="fa-regular fa-bookmark"></i></i></button></a></li>
                <li><button><a href="index.php?pfid=<?php echo $product["id"]; ?>&addtofav"><i class="ti-heart"></i></a></button></li>
              </ul>
            </div>
            <div class="card-body">
              <p><?php echo $product['category'] ?></p>
              <h4 class="card-product__title"><a href="single-product.php?id=<?php echo $product['id'] ?>"><?php echo $product['name'] ?></a></h4>
              <p class="card-product__price">$<?php echo $product['price'] ?></p>
            </div>
          </div>
        <?php } ?>
      </div>



    </div>

  </section>



</main>

<!--================ End =================-->
<?php
require_once 'layout/footer.php';
?>