<?php
require_once './layout/header.php';
require_once '../Models/product.php';
require_once '../Controller/ProductController.php';

$productController = new ProductController;
$categories = $productController->getCategories();
$sizes = $productController->getSizes();

$errMsg = "";

if (isset($_POST['name']) && isset($_POST['category']) && isset($_POST['size']) && isset($_POST['color']) && isset($_POST['desc']) && isset($_POST['quantity']) && isset($_POST['price']) && isset($_FILES['img'])) {
  if (!empty($_POST['name']) && !empty($_POST['category']) && !empty($_POST['size']) && !empty($_POST['color']) && !empty($_POST['desc']) && !empty($_POST['quantity']) && !empty($_POST['price'])) {

    $product = new Product;
    $product->adding($_POST['name'], $_POST['category'], $_POST['size'], $_POST['color'], $_POST['desc'], $_POST['quantity'], $_POST['price']);

    $location = "./images" . date("h-i-s") . $_FILES["img"]["name"];

    if (move_uploaded_file($_FILES["img"]["tmp_name"], $location)) {
      $product->image = $location;
      if ($productController->addProduct($product)) {
        header("location: index.php");
      } else {
        $errMsg = "Something went wrong... try again";
      }
    } else {
      $errMsg = "Error in Upload";
    }
  } else {
    $errMsg = "Please fill all fields";
  }
}



?>
<!-- ================ start banner area ================= -->
<section class="blog-banner-area" id="category">
  <div class="container h-100">
    <div class="blog-banner">
      <div class="text-center">
        <h1>Adding Product</h1>
        <nav aria-label="breadcrumb" class="banner-breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Seller</li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
</section>
<!-- ================ end banner area ================= -->


<?php

if ($errMsg != "") {
?>
  <div class="alert alert-danger" role="alert"><?php echo $errMsg ?></div>
<?php
}

?>

<!--================Cart Area =================-->
<section class="cart_area">
  <div class="container">
    <div class="col-6 mx-auto">


      <form action="add-product.php" method="post">


        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="inputEmail4">Product Name</label>
            <input type="text" name="name" class="form-control" id="inputEmail4" placeholder="Name">
          </div>
        </div>

        <div class="form-row mb-2">
          <select class="form-select mx-1" name="category" aria-label="Default select example">
            <option value="" selected disabled>Select Category</option>
            <?php
            foreach ($categories as $category) {

            ?>

              <option value="<?php echo $category["id"] ?>"><?php echo $category["name"] ?></option>
            <?php

            }


            ?>
          </select>

          <select class="form-group form-select mx-1" name="size" aria-label="Default select example">

            <option value="" selected disabled>Select Size</option>
            <?php
            foreach ($sizes as $size) {

            ?>

              <option value="<?php echo $size["id"] ?>"><?php echo $size["name"] ?></option>
            <?php

            }


            ?>
          </select>

        </div>

        <div class="form-row">
          <div class="form-group col-md-5">
            <label for="inputEmail4">Product Color</label>
            <input type="text" name="color" class="form-control" id="inputEmail4" placeholder="Color">
          </div>
        </div>

        <div class="form-group">
          <label for="inputAddress">description</label>
          <textarea class="form-control" name="desc" id="inputAddress"></textarea>
        </div>


        <div class="form-row">

          <div class="form-group col-md-6">
            <label for="inputEmail4">Product Quantity</label>
            <input type="number" name="quantity" class="form-control" id="inputEmail4">
          </div>

          <div class="form-group col-md-6">
            <label for="inputEmail4">Product Price</label>
            <div class="input-group mb-3">
              <input type="number" step="0.01" placeholder="0.00" name="price" class="form-control" aria-label="Amount (to the nearest dollar)">
              <span class="input-group-text">$</span>
            </div>
          </div>

        </div>

        <div class="mb-3">
          <label for="formFileMultiple" class="form-label">Add Product Photos</label>
          <input class="form-control" type="file" name="img" id="formFileMultiple" multiple>
        </div>
        
        <!--
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="inputCity">City</label>
              <input type="text" class="form-control" id="inputCity">
            </div>
            <div class="form-group col-md-4">
              <label for="inputState">State</label>
              <select id="inputState" class="form-control">
                <option selected>Choose...</option>
                <option>...</option>
              </select>
            </div>
            <div class="form-group col-md-2">
              <label for="inputZip">Zip</label>
              <input type="text" class="form-control" id="inputZip">
            </div>
          </div>
          <div class="form-group">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="gridCheck">
              <label class="form-check-label" for="gridCheck">
                Check me out
              </label>
            </div>
          </div>

        -->
        <button type="submit" class="btn btn-primary">Add</button>
      </form>
    </div>
  </div>
</section>
<!--================End Cart Area =================-->

<?php
require_once './layout/footer.php';
?>