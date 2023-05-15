<?php
require_once '../Models/product.php';
require_once '../Controller/Authcontroller.php';
require_once '../Controller/ProductController.php';

$auth = new AuthController;
$productController = new ProductController;
if (isset($_GET['search'])) {
  if (!empty($_GET['search'])) {
    $search = $_GET['search'];
    $products = $productController->search($search);
  }else{
    header("location: ../views/index.php");
  }
}else{
  header("location: ../views/index.php");

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
        <h1>Search Results</h1>
        <nav aria-label="breadcrumb" class="banner-breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Search Results Page</li>
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
        <section class="lattest-product-area pb-40 category-list">
          <div class="row">
            <?php
            if(empty($products)){
							// print_r($getFeedback)
							?>
							<h4>No Products With This Name !!,</h4>
              <h4 class="text-primary"> Try To Search Again</h4>
            <?php
            }
						else{
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
                      <li><a href="products.php?pwid=<?php echo $product["id"]; ?>&addtowatchlist"><button><i class="fa-solid fa-bookmark"></i></button></a></li>
                      <li><button><a href="products.php?pfid=<?php echo $product["id"]; ?>&addtofav"><i class="ti-heart"></i></a></button></li>
                    </ul>
                  </div>
                  <div class="card-body">
                    <p><?php echo $product['category'] ?></p>
                    <h4 class="card-product__title">
                      <a href="single-product.php?id=<?php echo $product['id'] ?>"><?php echo $product['name'] ?></a>
                    </h4>
                    <p class="card-product__price">$<?php echo $product['price'] ?></p>
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