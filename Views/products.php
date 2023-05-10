<?php
require_once '../Models/product.php';
require_once '../Controller/Authcontroller.php';
require_once '../Controller/ProductController.php';

$productController = new ProductController;
$auth = new AuthController;
$categories = $productController->getCategories();
$products = $productController->getAllProducts();


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
<!-- ================ start banner area ================= -->
<section class="blog-banner-area" id="category">
  <div class="container h-100">
    <div class="blog-banner">
      <div class="text-center">
        <h1>Shop Category</h1>
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


<!-- ================ category section start ================= -->
<section class="section-margin--small mb-5">
  <div class="container">
    <div class="row">
      <div class="col-xl-3 col-lg-4 col-md-5">
        <div class="sidebar-categories">
          <div class="head">Browse Categories</div>
          <ul class="main-categories">
            <li class="common-filter">
              <form>
                <ul>
                  <?php
                  foreach ($categories as $category) {
                  ?>
                    <li class="filter-list">
                      <a target="_self" href="category-products.php?id=<?php echo $category["id"] ?>">
                        <input class="pixel-radio" type="radio" name="categoryName" value="<?php echo $category["id"] ?>" onclick="window.location.href='category-products.php?id=<?php echo $category['id'] ?>';">
                        <label for="<?php echo $category["name"] ?>"><?php echo $category["name"] ?><span>(<?php echo $category["categoryQuantity"] ?>)</span></label>
                      </a>
                    </li>
                  <?php
                  }


                  ?>
                </ul>
              </form>
            </li>
          </ul>
        </div>

      </div>
      <div class="col-xl-9 col-lg-8 col-md-7">
        <!-- Start Filter Bar -->
        <div class="filter-bar d-flex flex-wrap align-items-center">
          <div>
            <div class="input-group filter-bar-search">
              <form action="search.php">
              <input type="text" name="search" placeholder="Search">
              </form>
              <div class="input-group-append">
                <button type="button"><i class="ti-search"></i></button>
              </div>
            </div>
          </div>
        </div>
        <!-- End Filter Bar -->
        <!-- Start Best Seller -->
        <section class="lattest-product-area pb-40 category-list">
          <div class="row">
            <?php
            foreach ($products as $product) {
            ?>
              <div class="col-md-6 col-lg-4">
                <div class="card text-center card-product">
                  <div class="card-product__img">
                    <img class="card-img" width="500" src="<?php echo $product['image'] ?>" style="width: 200px;height: 250px;object-fit: cover;" alt="<?php echo $product['name'] ?>">
                    <ul class="card-product__imgOverlay">
                    <li>
                        <form action="single-product.php">
                          <input type="hidden" name="quantity" value="1">
                          <input type="hidden" name="id" value="<?php echo $product["id"]; ?>">
                          <input type="hidden" name="add" value="">
                          <button><i class="ti-shopping-cart"></i></button>
                        </form>
                      </li>
                      <li><a href="products.php?pwid=<?php echo $product["id"]; ?>&addtowatchlist"><button><i class="fa-regular fa-bookmark"></i></button></a></li>
                      <li><button><a href="products.php?pfid=<?php echo $product["id"]; ?>&addtofav"><i class="ti-heart"></i></a></button></li>
                    </ul>
                  </div>
                  <div class="card-body">
                    <p><?php echo $product['category'] ?></p>
                    <h4 class="card-product__title">
                      <a href="single-product.php?id=<?php echo $product['id'] ?>"><?php echo $product['name'] ?></a>
                      <!-- <a class="stretched-link" href="single-product.php?id=<?php echo $product['id'] ?>"><?php echo $product['name'] ?></a> -->
                    </h4>
                    <p class="card-product__price">$<?php echo $product['price'] ?></p>
                  </div>
                </div>
              </div>
            <?php } ?>
          </div>
        </section>
        <!-- End Best Seller -->
      </div>
    </div>
  </div>
</section>
<!-- ================ category section end ================= -->


<!-- ================ Subscribe section start ================= -->
<section class="subscribe-position">
  <div class="container">
    <div class="subscribe text-center">
      <h3 class="subscribe__title">Get Update From Anywhere</h3>
      <p>Bearing Void gathering light light his eavening unto dont afraid</p>
      <div id="mc_embed_signup">
        <form target="_blank" action="https://spondonit.us12.list-manage.com/subscribe/post?u=1462626880ade1ac87bd9c93a&amp;id=92a4423d01" method="get" class="subscribe-form form-inline mt-5 pt-1">
          <div class="form-group ml-sm-auto">
            <input class="form-control mb-1" type="email" name="EMAIL" placeholder="Enter your email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Your Email Address '">
            <div class="info"></div>
          </div>
          <button class="button button-subscribe mr-auto mb-1" type="submit">Subscribe Now</button>
          <div style="position: absolute; left: -5000px;">
            <input name="b_36c4fd991d266f23781ded980_aefe40901a" tabindex="-1" value="" type="text">
          </div>

        </form>
      </div>

    </div>
  </div>
</section>
<!-- ================ Subscribe section end ================= -->



<!--================ End =================-->
<?php
require_once 'layout/footer.php';
?>