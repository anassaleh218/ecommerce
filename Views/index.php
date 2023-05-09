<?php
if (!isset($_SESSION["errMsg"])) {
  session_start();
  if (isset($_SESSION["errMsg"])) {
    echo "<div class=\"alert alert-danger\" role=\"alert\">" . $_SESSION["errMsg"] . "</div>";
    unset($_SESSION['errMsg']);
  }
  // session_destroy();
}
?>


<?php
require_once '../Models/product.php';
require_once '../Controller/Authcontroller.php';
require_once '../Controller/ProductController.php';

$productController = new ProductController;
$categories = $productController->getCategories();
$products = $productController->getAllProducts();

if (isset($_GET['pid'])) {
  if (!empty($_GET['pid'])) {


    $id = $_GET['pid'];
    // $productController = new ProductController;
    $auth = new AuthController;


    if ($productController->getProductById($id)) {
      $product = $productController->getProductById($id)[0];
      // print_r($product);
      if (isset($_GET['add'])) {
        if ($auth->getCurrentUser() != false) {

          $currentUser = $auth->getCurrentUser();
          try {
            $productController->addToFav($currentUser, $product["id"]);
            echo "<div class=\"alert alert-success\" role=\"alert\">added successfully</div>";
          } catch (Exception $e) {
            // echo "<div class=\"alert alert-success\" role=\"alert\">added successfully</div>";
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
  <!--================ Hero banner start =================-->

  <!--================ Hero Carousel start =================-->
  <section class="section-margin mt-0">
    <div class="owl-carousel owl-theme hero-carousel">
      <div class="hero-carousel__slide">
        <img src="asstes/img/home/hero-slide1.png" alt="" class="img-fluid">
        <a href="./category-products.php?id=4" class="hero-carousel__slideOverlay">
          <h3>Shoes</h3>
          <!-- <p>Wireless Headphone</p> -->
        </a>
      </div>
      <div class="hero-carousel__slide">
        <img src="asstes/img/home/hero-slide2.png" alt="" class="img-fluid">
        <a href="./category-products.php?id=3" class="hero-carousel__slideOverlay">
          <h3>Wireless Headphone</h3>
          <!-- <p>Accessories Item</p> -->
        </a>
      </div>
      <div class="hero-carousel__slide">
        <img src="asstes/img/home/hero-slide3.png" alt="" class="img-fluid">
        <a href="./category-products.php?id=5" class="hero-carousel__slideOverlay">
          <h3>Accessories</h3>
          <!-- <p>Accessories Item</p> -->
        </a>
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
                <img class="" width="250" src="<?php echo $product['image'] ?>" alt="<?php echo $product['name'] ?>">
                <ul class="card-product__imgOverlay">
                  <!-- <li><button><i class="ti-search"></i></button></li> -->
                  <li>
                    <form action="single-product.php">
                      <input type="hidden" name="quantity" value="1">
                      <input type="hidden" name="id" value="<?php echo $product["id"]; ?>">
                      <input type="hidden" name="add" value="">
                      <button><i class="ti-shopping-cart"></i></button>
                    </form>
                  </li>
                  <li><button><a href="products.php?pid=<?php echo $product["id"]; ?>&add"><i class="ti-heart"></i></a></button></li>
                </ul>
              </div>
              <div class="card-body">
                <p><?php echo $product['category'] ?></p>
                <h4 class="card-product__title"><a class="stretched-link" href="single-product.php?id=<?php echo $product['id'] ?>"><?php echo $product['name'] ?></a></h4>
                <p class="card-product__price">$<?php echo $product['price'] ?></p>
              </div>
            </div>
          </div>
        <?php } ?>

        <!-- <div class="col-md-6 col-lg-4 col-xl-3">
          <div class="card text-center card-product">
            <div class="card-product__img">
              <img class="card-img" src="asstes/img/product/product2.png" alt="">
              <ul class="card-product__imgOverlay">
                <li><button><i class="ti-search"></i></button></li>
                <li><button><i class="ti-shopping-cart"></i></button></li>
                <li><button><i class="ti-heart"></i></button></li>
              </ul>
            </div>
            <div class="card-body">
              <p>Beauty</p>
              <h4 class="card-product__title"><a href="single-product.html">Women Freshwash</a></h4>
              <p class="card-product__price">$150.00</p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-4 col-xl-3">
          <div class="card text-center card-product">
            <div class="card-product__img">
              <img class="card-img" src="asstes/img/product/product3.png" alt="">
              <ul class="card-product__imgOverlay">
                <li><button><i class="ti-search"></i></button></li>
                <li><button><i class="ti-shopping-cart"></i></button></li>
                <li><button><i class="ti-heart"></i></button></li>
              </ul>
            </div>
            <div class="card-body">
              <p>Decor</p>
              <h4 class="card-product__title"><a href="single-product.html">Room Flash Light</a></h4>
              <p class="card-product__price">$150.00</p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-4 col-xl-3">
          <div class="card text-center card-product">
            <div class="card-product__img">
              <img class="card-img" src="asstes/img/product/product4.png" alt="">
              <ul class="card-product__imgOverlay">
                <li><button><i class="ti-search"></i></button></li>
                <li><button><i class="ti-shopping-cart"></i></button></li>
                <li><button><i class="ti-heart"></i></button></li>
              </ul>
            </div>
            <div class="card-body">
              <p>Decor</p>
              <h4 class="card-product__title"><a href="single-product.html">Room Flash Light</a></h4>
              <p class="card-product__price">$150.00</p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-4 col-xl-3">
          <div class="card text-center card-product">
            <div class="card-product__img">
              <img class="card-img" src="asstes/img/product/product5.png" alt="">
              <ul class="card-product__imgOverlay">
                <li><button><i class="ti-search"></i></button></li>
                <li><button><i class="ti-shopping-cart"></i></button></li>
                <li><button><i class="ti-heart"></i></button></li>
              </ul>
            </div>
            <div class="card-body">
              <p>Accessories</p>
              <h4 class="card-product__title"><a href="single-product.html">Man Office Bag</a></h4>
              <p class="card-product__price">$150.00</p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-4 col-xl-3">
          <div class="card text-center card-product">
            <div class="card-product__img">
              <img class="card-img" src="asstes/img/product/product6.png" alt="">
              <ul class="card-product__imgOverlay">
                <li><button><i class="ti-search"></i></button></li>
                <li><button><i class="ti-shopping-cart"></i></button></li>
                <li><button><i class="ti-heart"></i></button></li>
              </ul>
            </div>
            <div class="card-body">
              <p>Kids Toy</p>
              <h4 class="card-product__title"><a href="single-product.html">Charging Car</a></h4>
              <p class="card-product__price">$150.00</p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-4 col-xl-3">
          <div class="card text-center card-product">
            <div class="card-product__img">
              <img class="card-img" src="asstes/img/product/product7.png" alt="">
              <ul class="card-product__imgOverlay">
                <li><button><i class="ti-search"></i></button></li>
                <li><button><i class="ti-shopping-cart"></i></button></li>
                <li><button><i class="ti-heart"></i></button></li>
              </ul>
            </div>
            <div class="card-body">
              <p>Accessories</p>
              <h4 class="card-product__title"><a href="single-product.html">Blutooth Speaker</a></h4>
              <p class="card-product__price">$150.00</p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-4 col-xl-3">
          <div class="card text-center card-product">
            <div class="card-product__img">
              <img class="card-img" src="asstes/img/product/product8.png" alt="">
              <ul class="card-product__imgOverlay">
                <li><button><i class="ti-search"></i></button></li>
                <li><button><i class="ti-shopping-cart"></i></button></li>
                <li><button><i class="ti-heart"></i></button></li>
              </ul>
            </div>
            <div class="card-body">
              <p>Kids Toy</p>
              <h4 class="card-product__title"><a href="#">Charging Car</a></h4>
              <p class="card-product__price">$150.00</p>
            </div>
          </div>
        </div> -->
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
              <img class="img-fluid" src="<?php echo $product['image'] ?>" alt="<?php echo $product['name'] ?>">
              <ul class="card-product__imgOverlay">
                <li>
                  <form action="single-product.php">
                    <input type="hidden" name="quantity" value="1">
                    <input type="hidden" name="id" value="<?php echo $product["id"]; ?>">
                    <input type="hidden" name="add" value="">
                    <button><i class="ti-shopping-cart"></i></button>
                  </form>
                </li>
                <li><button><a href="products.php?pid=<?php echo $product["id"]; ?>&add"><i class="ti-heart"></i></a></button></li>
              </ul>
            </div>
            <div class="card-body">
              <p><?php echo $product['category'] ?></p>
              <h4 class="card-product__title"><a class="stretched-link" href="single-product.php?id=<?php echo $product['id'] ?>"><?php echo $product['name'] ?></a></h4>
              <p class="card-product__price">$<?php echo $product['price'] ?></p>
            </div>
          </div>
        <?php } ?>
      </div>



        <!-- <div class="card text-center card-product">
          <div class="card-product__img">
            <img class="img-fluid" src="asstes/img/product/product2.png" alt="">
            <ul class="card-product__imgOverlay">
              <li><button><i class="ti-search"></i></button></li>
              <li><button><i class="ti-shopping-cart"></i></button></li>
              <li><button><i class="ti-heart"></i></button></li>
            </ul>
          </div>
          <div class="card-body">
            <p>Beauty</p>
            <h4 class="card-product__title"><a href="single-product.html">Women Freshwash</a></h4>
            <p class="card-product__price">$150.00</p>
          </div>
        </div>

        <div class="card text-center card-product">
          <div class="card-product__img">
            <img class="img-fluid" src="asstes/img/product/product3.png" alt="">
            <ul class="card-product__imgOverlay">
              <li><button><i class="ti-search"></i></button></li>
              <li><button><i class="ti-shopping-cart"></i></button></li>
              <li><button><i class="ti-heart"></i></button></li>
            </ul>
          </div>
          <div class="card-body">
            <p>Decor</p>
            <h4 class="card-product__title"><a href="single-product.html">Room Flash Light</a></h4>
            <p class="card-product__price">$150.00</p>
          </div>
        </div>

        <div class="card text-center card-product">
          <div class="card-product__img">
            <img class="img-fluid" src="asstes/img/product/product4.png" alt="">
            <ul class="card-product__imgOverlay">
              <li><button><i class="ti-search"></i></button></li>
              <li><button><i class="ti-shopping-cart"></i></button></li>
              <li><button><i class="ti-heart"></i></button></li>
            </ul>
          </div>
          <div class="card-body">
            <p>Decor</p>
            <h4 class="card-product__title"><a href="single-product.html">Room Flash Light</a></h4>
            <p class="card-product__price">$150.00</p>
          </div>
        </div>

        <div class="card text-center card-product">
          <div class="card-product__img">
            <img class="img-fluid" src="asstes/img/product/product1.png" alt="">
            <ul class="card-product__imgOverlay">
              <li><button><i class="ti-search"></i></button></li>
              <li><button><i class="ti-shopping-cart"></i></button></li>
              <li><button><i class="ti-heart"></i></button></li>
            </ul>
          </div>
          <div class="card-body">
            <p>Accessories</p>
            <h4 class="card-product__title"><a href="single-product.html">Quartz Belt Watch</a></h4>
            <p class="card-product__price">$150.00</p>
          </div>
        </div>

        <div class="card text-center card-product">
          <div class="card-product__img">
            <img class="img-fluid" src="asstes/img/product/product2.png" alt="">
            <ul class="card-product__imgOverlay">
              <li><button><i class="ti-search"></i></button></li>
              <li><button><i class="ti-shopping-cart"></i></button></li>
              <li><button><i class="ti-heart"></i></button></li>
            </ul>
          </div>
          <div class="card-body">
            <p>Beauty</p>
            <h4 class="card-product__title"><a href="single-product.html">Women Freshwash</a></h4>
            <p class="card-product__price">$150.00</p>
          </div>
        </div>

        <div class="card text-center card-product">
          <div class="card-product__img">
            <img class="img-fluid" src="asstes/img/product/product3.png" alt="">
            <ul class="card-product__imgOverlay">
              <li><button><i class="ti-search"></i></button></li>
              <li><button><i class="ti-shopping-cart"></i></button></li>
              <li><button><i class="ti-heart"></i></button></li>
            </ul>
          </div>
          <div class="card-body">
            <p>Decor</p>
            <h4 class="card-product__title"><a href="single-product.html">Room Flash Light</a></h4>
            <p class="card-product__price">$150.00</p>
          </div>
        </div>

        <div class="card text-center card-product">
          <div class="card-product__img">
            <img class="img-fluid" src="asstes/img/product/product4.png" alt="">
            <ul class="card-product__imgOverlay">
              <li><button><i class="ti-search"></i></button></li>
              <li><button><i class="ti-shopping-cart"></i></button></li>
              <li><button><i class="ti-heart"></i></button></li>
            </ul>
          </div>
          <div class="card-body">
            <p>Decor</p>
            <h4 class="card-product__title"><a href="single-product.html">Room Flash Light</a></h4>
            <p class="card-product__price">$150.00</p>
          </div>
        </div> -->
    </div>

  </section>
  <!-- ================ Best Selling item  carousel end ================= -->

  <!-- ================ Blog section start ================= -->
  <!-- <section class="blog">
    <div class="container">
      <div class="section-intro pb-60px">
        <p>Popular Item in the market</p>
        <h2>Latest <span class="section-intro__style">News</span></h2>
      </div>

      <div class="row">
        <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
          <div class="card card-blog">
            <div class="card-blog__img">
              <img class="card-img rounded-0" src="asstes/img/blog/blog1.png" alt="">
            </div>
            <div class="card-body">
              <ul class="card-blog__info">
                <li><a href="#">By Admin</a></li>
                <li><a href="#"><i class="ti-comments-smiley"></i> 2 Comments</a></li>
              </ul>
              <h4 class="card-blog__title"><a href="single-blog.html">The Richland Center Shooping News and weekly shooper</a></h4>
              <p>Let one fifth i bring fly to divided face for bearing divide unto seed. Winged divided light Forth.</p>
              <a class="card-blog__link" href="#">Read More <i class="ti-arrow-right"></i></a>
            </div>
          </div>
        </div>

        <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
          <div class="card card-blog">
            <div class="card-blog__img">
              <img class="card-img rounded-0" src="asstes/img/blog/blog2.png" alt="">
            </div>
            <div class="card-body">
              <ul class="card-blog__info">
                <li><a href="#">By Admin</a></li>
                <li><a href="#"><i class="ti-comments-smiley"></i> 2 Comments</a></li>
              </ul>
              <h4 class="card-blog__title"><a href="single-blog.html">The Shopping News also offers top-quality printing services</a></h4>
              <p>Let one fifth i bring fly to divided face for bearing divide unto seed. Winged divided light Forth.</p>
              <a class="card-blog__link" href="#">Read More <i class="ti-arrow-right"></i></a>
            </div>
          </div>
        </div>

        <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
          <div class="card card-blog">
            <div class="card-blog__img">
              <img class="card-img rounded-0" src="asstes/img/blog/blog3.png" alt="">
            </div>
            <div class="card-body">
              <ul class="card-blog__info">
                <li><a href="#">By Admin</a></li>
                <li><a href="#"><i class="ti-comments-smiley"></i> 2 Comments</a></li>
              </ul>
              <h4 class="card-blog__title"><a href="single-blog.html">Professional design staff and efficient equipment you’ll find we offer</a></h4>
              <p>Let one fifth i bring fly to divided face for bearing divide unto seed. Winged divided light Forth.</p>
              <a class="card-blog__link" href="#">Read More <i class="ti-arrow-right"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section> -->
  <!-- ================ Blog section end ================= -->

  <!-- ================ Subscribe section start ================= -->
  <!-- <section class="subscribe-position">
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
  </section> -->
  <!-- ================ Subscribe section end ================= -->



</main>

<!--================ End =================-->
<?php
require_once 'layout/footer.php';
?>