<?php
require_once '../Models/product.php';
require_once '../Controller/Authcontroller.php';
require_once '../Controller/ProductController.php';

$auth = new AuthController;
$productController = new ProductController;


if ($auth->getCurrentUser() != false) {
  $currentUser = $auth->getCurrentUser();
} else {
  if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }
  $_SESSION["errMsg"] =  "you must login or regester first";
  header("location: ../Views/login.php");
}

/////////// addtofav or  addtowatchlist ///////////
if (isset($_GET['pfid'])) {
  if (!empty($_GET['pfid'])) {
    /////// add to fav if addtofav is set ///////
    if (isset($_GET['addtofav'])) {
      try {
        $productController->addToFav($currentUser, $_GET['pfid']);
        echo "<div class=\"alert alert-success\" role=\"alert\">added successfully</div>";
      } catch (Exception $e) {
        echo "<div class=\"alert alert-success\" role=\"alert\">already exists in the <a href=\"fav-products.php\">Favourites Page</a></div>";
      }
    }
  }
}
/////////// ////////////////////////// ///////////


if (isset($_GET['pwid'])) {
  if (!empty($_GET['pwid'])) {
    $id =  $_GET['pwid'];
    if ($productController->removeWatchlist($id)) {
      echo "<div class=\"alert alert-success\" role=\"alert\">Product Deleted Successfully</div>";
    } else {
      echo "<div class=\"alert alert-danger\" role=\"alert\">can't delete Product</div>";
    }
  }
}



$products = $productController->getWatchlist($currentUser);


?>




<?php
require_once 'layout/header.php';
?>

<!-- ================ start banner area ================= -->
<section class="blog-banner-area" id="category">
  <div class="container h-100">
    <div class="blog-banner">
      <div class="text-center">
        <h1>Watch List</h1>
        <nav aria-label="breadcrumb" class="banner-breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Watch List Page</li>
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
      <div class="col-xl-12 col-lg-8 col-md-7">
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
						// print_r($getFeedback);
						if(empty($products)){
							// print_r($getFeedback)
							?>
							<h4>You Have No Products In Your WatchList Yet !!, </h4>
              <h4 class="text-primary">To Add Product To Your WatchList Press On <i class="fa-regular fa-bookmark"></i> Icon On Product Card</h4>
            <?php
            }
						else{
            foreach ($products as $product) {
            ?>
              <div class="col-md-6 col-lg-4">
                <div class="card text-center card-product">
                  <div class="card-product__img">
                    <img class="card-img" src="<?php echo $product['image'] ?>" style="width: 300px;height: 300px;object-fit: cover;" alt="<?php echo $product['name'] ?>">
                    <ul class="card-product__imgOverlay">
                      <li>
                        <form action="single-product.php">
                          <input type="hidden" name="quantity" value="1">
                          <input type="hidden" name="id" value="<?php echo $product["id"]; ?>">
                          <input type="hidden" name="add" value="">
                          <button><i class="ti-shopping-cart"></i></button>
                        </form>
                      </li>
                      <li><a href="watchlist.php?pwid=<?php echo $product["id"]; ?>"><button><i class="fa-solid fa-bookmark"></i></button></a></li>
                      <li><button><a href="watchlist.php?pfid=<?php echo $product["id"]; ?>&addtofav"><i class="ti-heart"></i></a></button></li>
                    </ul>
                  </div>
                  <div class="card-body">
                    <p><?php echo $product['category'] ?></p>
                    <h4 class="card-product__title"><a href="single-product.php?id=<?php echo $product['id'] ?>"><?php echo $product['name'] ?></a></h4>
                    <p class="card-product__price">$<?php echo $product['start_price'] ?></p>
                  </div>
                </div>
              </div>
            <?php }} ?>
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