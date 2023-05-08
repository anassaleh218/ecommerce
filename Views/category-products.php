<?php
require_once '../Models/product.php';
require_once '../Controller/Authcontroller.php';
require_once '../Controller/ProductController.php';

$productController = new ProductController;
$categories = $productController->getCategories();
// $products = $productController->getAllProducts();



if (isset($_GET["id"])) {
  if (!empty($_GET["id"])) {
    $products = $productController->getCategoryProducts($_GET["id"]);
  } else {
    header("location: index.php");
  }
} else {
  header("location: index.php");
}


if (isset($_GET['pid'])) {
  if (!empty($_GET['pid'])) {


    $id = $_GET['pid'];
    $productController = new ProductController;
    $auth = new AuthController;


    if ($productController->getProductById($id)) {
      $product = $productController->getProductById($id)[0];
      // print_r($product);
      if (isset($_GET['add'])) {
        if ($auth->getCurrentUser() != false) {

          $currentUser = $auth->getCurrentUser();
          try {
            $productController->addToFav($currentUser, $product["id"]);
            echo "<div class=\"alert alert-success\" role=\"alert\">added To Fav successfully</div>";
          } catch (Exception $e) {
            // echo "<div class=\"alert alert-success\" role=\"alert\">added To Fav successfully</div>";
            echo 'Message: ' . $e->getMessage();
          }
        } else {
          if (session_status() === PHP_SESSION_NONE) {
            session_start();
          }
          $_SESSION["errMsg"] =  "you must login or regester first";
          header("location: ../Views/login.php");
        }
      }
    } else {
      $_SESSION["errMsg"] =  "no product by this id";
      header("location: ../Views/index.php");
    }
  } else {
    // $_SESSION["errMsg"] =  "no product by this id";
    // header("location: ../Views/index.php");
  }
} else {
  // $_SESSION["errMsg"] =  "no product by this id";
  // header("location: ../Views/index.php");
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
        <!-- <div class="sidebar-filter">
          <div class="top-filter-head">Product Filters</div>
          <div class="common-filter">
            <div class="head">Brands</div>
            <form action="#">
              <ul>
                <li class="filter-list"><input class="pixel-radio" type="radio" id="apple" name="brand"><label for="apple">Apple<span>(29)</span></label></li>
                <li class="filter-list"><input class="pixel-radio" type="radio" id="asus" name="brand"><label for="asus">Asus<span>(29)</span></label></li>
                <li class="filter-list"><input class="pixel-radio" type="radio" id="gionee" name="brand"><label for="gionee">Gionee<span>(19)</span></label></li>
                <li class="filter-list"><input class="pixel-radio" type="radio" id="micromax" name="brand"><label for="micromax">Micromax<span>(19)</span></label></li>
                <li class="filter-list"><input class="pixel-radio" type="radio" id="samsung" name="brand"><label for="samsung">Samsung<span>(19)</span></label></li>
              </ul>
            </form>
          </div>
          <div class="common-filter">
            <div class="head">Color</div>
            <form action="#">
              <ul>
                <li class="filter-list"><input class="pixel-radio" type="radio" id="black" name="color"><label for="black">Black<span>(29)</span></label></li>
                <li class="filter-list"><input class="pixel-radio" type="radio" id="balckleather" name="color"><label for="balckleather">Black
                    Leather<span>(29)</span></label></li>
                <li class="filter-list"><input class="pixel-radio" type="radio" id="blackred" name="color"><label for="blackred">Black
                    with red<span>(19)</span></label></li>
                <li class="filter-list"><input class="pixel-radio" type="radio" id="gold" name="color"><label for="gold">Gold<span>(19)</span></label></li>
                <li class="filter-list"><input class="pixel-radio" type="radio" id="spacegrey" name="color"><label for="spacegrey">Spacegrey<span>(19)</span></label></li>
              </ul>
            </form>
          </div>
          <div class="common-filter">
            <div class="head">Price</div>
            <div class="price-range-area">
              <div id="price-range"></div>
              <div class="value-wrapper d-flex">
                <div class="price">Price:</div>
                <span>$</span>
                <div id="lower-value"></div>
                <div class="to">to</div>
                <span>$</span>
                <div id="upper-value"></div>
              </div>
            </div>
          </div>
        </div> -->
      </div>
      <div class="col-xl-9 col-lg-8 col-md-7">
        <!-- Start Filter Bar -->
        <div class="filter-bar d-flex flex-wrap align-items-center">
          <!-- <div class="sorting">
            <select>
              <option value="1">Default sorting</option>
              <option value="1">Default sorting</option>
              <option value="1">Default sorting</option>
            </select>
          </div>
          <div class="sorting mr-auto">
            <select>
              <option value="1">Show 12</option>
              <option value="1">Show 12</option>
              <option value="1">Show 12</option>
            </select>
          </div> -->
          <div>
            <div class="input-group filter-bar-search">
              <input type="text" placeholder="Search">
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
                    <img class="card-img" src="<?php echo $product['image'] ?>" alt="<?php echo $product['name'] ?>">
                    <ul class="card-product__imgOverlay">
                      <!-- <li><button><i class="ti-search"></i></button></li> -->
                      <li>
                        <form action="single-product.php">
                          <input type="hidden" name="quantity" value="1">
                          <input type="hidden" name="id" value="<?php echo $product["id"]; ?>" >
                          <input type="hidden" name="add" value="" >
                          <button><i class="ti-shopping-cart"></i></button>
                        </form>
                      </li>                      <li><button><a href="category-products.php?pid=<?php echo $product["id"]; ?>&add"><i class="ti-heart"></i></a></button></li>
                    </ul>
                  </div>
                  <div class="card-body">
                    <p><?php echo $product['category'] ?></p>
                    <h4 class="card-product__title"><a href="#"><?php echo $product['name'] ?></a></h4>
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

<!-- ================ top product area start ================= -->
<!-- <section class="related-product-area">
  <div class="container">
    <div class="section-intro pb-60px">
      <p>Popular Item in the market</p>
      <h2>Top <span class="section-intro__style">Product</span></h2>
    </div>
    <div class="row mt-30">
      <div class="col-sm-6 col-xl-3 mb-4 mb-xl-0">
        <div class="single-search-product-wrapper">
          <div class="single-search-product d-flex">
            <a href="#"><img src="asstes/img/product/product-sm-1.png" alt=""></a>
            <div class="desc">
              <a href="#" class="title">Gray Coffee Cup</a>
              <div class="price">$170.00</div>
            </div>
          </div>
          <div class="single-search-product d-flex">
            <a href="#"><img src="asstes/img/product/product-sm-2.png" alt=""></a>
            <div class="desc">
              <a href="#" class="title">Gray Coffee Cup</a>
              <div class="price">$170.00</div>
            </div>
          </div>
          <div class="single-search-product d-flex">
            <a href="#"><img src="asstes/img/product/product-sm-3.png" alt=""></a>
            <div class="desc">
              <a href="#" class="title">Gray Coffee Cup</a>
              <div class="price">$170.00</div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-sm-6 col-xl-3 mb-4 mb-xl-0">
        <div class="single-search-product-wrapper">
          <div class="single-search-product d-flex">
            <a href="#"><img src="asstes/img/product/product-sm-4.png" alt=""></a>
            <div class="desc">
              <a href="#" class="title">Gray Coffee Cup</a>
              <div class="price">$170.00</div>
            </div>
          </div>
          <div class="single-search-product d-flex">
            <a href="#"><img src="asstes/img/product/product-sm-5.png" alt=""></a>
            <div class="desc">
              <a href="#" class="title">Gray Coffee Cup</a>
              <div class="price">$170.00</div>
            </div>
          </div>
          <div class="single-search-product d-flex">
            <a href="#"><img src="asstes/img/product/product-sm-6.png" alt=""></a>
            <div class="desc">
              <a href="#" class="title">Gray Coffee Cup</a>
              <div class="price">$170.00</div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-sm-6 col-xl-3 mb-4 mb-xl-0">
        <div class="single-search-product-wrapper">
          <div class="single-search-product d-flex">
            <a href="#"><img src="asstes/img/product/product-sm-7.png" alt=""></a>
            <div class="desc">
              <a href="#" class="title">Gray Coffee Cup</a>
              <div class="price">$170.00</div>
            </div>
          </div>
          <div class="single-search-product d-flex">
            <a href="#"><img src="asstes/img/product/product-sm-8.png" alt=""></a>
            <div class="desc">
              <a href="#" class="title">Gray Coffee Cup</a>
              <div class="price">$170.00</div>
            </div>
          </div>
          <div class="single-search-product d-flex">
            <a href="#"><img src="asstes/img/product/product-sm-9.png" alt=""></a>
            <div class="desc">
              <a href="#" class="title">Gray Coffee Cup</a>
              <div class="price">$170.00</div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-sm-6 col-xl-3 mb-4 mb-xl-0">
        <div class="single-search-product-wrapper">
          <div class="single-search-product d-flex">
            <a href="#"><img src="asstes/img/product/product-sm-1.png" alt=""></a>
            <div class="desc">
              <a href="#" class="title">Gray Coffee Cup</a>
              <div class="price">$170.00</div>
            </div>
          </div>
          <div class="single-search-product d-flex">
            <a href="#"><img src="asstes/img/product/product-sm-2.png" alt=""></a>
            <div class="desc">
              <a href="#" class="title">Gray Coffee Cup</a>
              <div class="price">$170.00</div>
            </div>
          </div>
          <div class="single-search-product d-flex">
            <a href="#"><img src="asstes/img/product/product-sm-3.png" alt=""></a>
            <div class="desc">
              <a href="#" class="title">Gray Coffee Cup</a>
              <div class="price">$170.00</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section> -->
<!-- ================ top product area end ================= -->

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