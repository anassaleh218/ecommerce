<?php
require_once '../Models/product.php';
require_once '../Controller/Authcontroller.php';
require_once '../Controller/ProductController.php';

$productController = new ProductController;
$categories = $productController->getCategories();
$auth = new AuthController;


if (isset($_GET["id"])) {
  if (!empty($_GET["id"])) {
    $cat_id = $_GET["id"];
    $products = $productController->getCategoryProducts($cat_id);
  } else {
    header("location: index.php");
  }
} else {
  header("location: index.php");
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
              <form action="#">
                <ul>
                  <?php
                  foreach ($categories as $category) {

                  ?>
                    <li class="filter-list">
                      <a target="_self" href="category-products.php?id=<?php echo $category["id"] ?>">
                        <input class="pixel-radio" type="radio" <?php
                                                                if ($_GET["id"] == $category["id"]) {
                                                                ?> checked <?php
                                                                }
            ?> name="categoryName" value="<?php echo $category["id"] ?>" onclick="window.location.href='category-products.php?id=<?php echo $category['id'] ?>';">
                        <label for="<?php echo $category["name"] ?>"><?php echo $category["name"] ?><span>(<?php echo $category["categoryQuantity"] ?>)</span></label>
                    </li>
                    </a>
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
                    <img class="card-img" src="<?php echo $product['image'] ?>" style="width: 200px;height: 250px;object-fit: cover;" alt="<?php echo $product['name'] ?>">
                    <ul class="card-product__imgOverlay">
                      <li>
                        <form action="single-product.php">
                          <input type="hidden" name="quantity" value="1">
                          <input type="hidden" name="id" value="<?php echo $product["id"]; ?>">
                          <input type="hidden" name="add" value="">
                          <button><i class="ti-shopping-cart"></i></button>
                        </form>
                      </li>
                      <li><a href="category-products.php?id=<?php echo $cat_id; ?>&pwid=<?php echo $product["id"]; ?>&addtowatchlist"><button><i class="fa-regular fa-bookmark"></i></button></a></li>
                      <li><button><a href="category-products.php?id=<?php echo $cat_id; ?>&pfid=<?php echo $product["id"]; ?>&addtofav"><i class="ti-heart"></i></a></button></li>
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
        </section>
        <!-- End Best Seller -->
      </div>
    </div>
  </div>
</section>
<!-- ================ category section end ================= -->


<!--================ End =================-->
<?php
require_once 'layout/footer.php';
?>