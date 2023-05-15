<?php
require_once './layout/header.php';
require_once '../Models/product.php';
require_once '../Controller/ProductController.php';



$productController = new ProductController;
$categories = $productController->getCategories();
$sizes = $productController->getSizes();

$errMsg = "";

//// check if user is login and seller /////
$auth = new AuthController;
if ($auth->getCurrentUser() != false) {
  $currentUser = $auth->getCurrentUser();
  if ($auth->getUserRole($currentUser) != "seller") {
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }
    $_SESSION["errMsg"] =  "you must be Seller";
    header("location: ../views/login.php");
  }
} else {
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }
  $_SESSION["errMsg"] =  "you must login or regester first";
  header("location: ../views/login.php");
}
/////////////////////////////////////////

if (isset($_POST['productId'])) {
  if (!empty($_POST['productId'])) {
    $product = $productController->getProductById($_POST['productId']);
    // print_r($product);
    if (isset($_POST['name']) && isset($_POST['category']) && isset($_POST['size']) && isset($_POST['color']) && isset($_POST['desc']) && isset($_POST['quantity']) && isset($_POST['price']) && isset($_FILES['img'])) {
      if (!empty($_POST['name']) && !empty($_POST['category']) && !empty($_POST['size']) && !empty($_POST['color']) && !empty($_POST['desc']) && !empty($_POST['quantity']) && !empty($_POST['price'])) {
        $product = new Product;
        $product->adding($_POST['name'], $_POST['category'], $_POST['size'], $_POST['color'], $_POST['desc'], $_POST['quantity'], $_POST['price']);
        print_r($product);
        $location = "images/" . date("h-i-s") . $_FILES["img"]["name"];

        if (move_uploaded_file($_FILES["img"]["tmp_name"], $location)) {
          $product->image = $location;
          if ($productController->updateProduct($currentUser, $product, $_POST['productId'])) {
            // header("location: manage-products.php");
            echo ("<script>location.href = 'http://localhost/ecommerce/views/manage-products.php';</script>");
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
  } else {

    // echo("<script>location.href = 'http://localhost/ecommerce/views/manage-products.php';</script>");
  }
} else {
  // echo("<script>location.href = 'http://localhost/ecommerce/views/manage-products.php';</script>");
}





?>
<!-- ================ start banner area ================= -->
<section class="blog-banner-area" id="category">
  <div class="container h-100">
    <div class="blog-banner">
      <div class="text-center">
        <h1>Updating Product</h1>
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


      <form action="update-product.php" method="post" enctype="multipart/form-data">


        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="inputEmail4">Product Name</label>
            <?php
            if (isset($_POST['productId'])) {
              if (!empty($_POST['productId'])) {
            ?>
                <input type="hidden" name="productId" value="<?php echo $_POST['productId'] ?>">

            <?php
              }
            } ?>
            <input type="text" name="name" value="<?php echo $product[0]["name"]; ?>" class="form-control" id="inputEmail4" placeholder="Name">
          </div>
        </div>

        <div class="form-row mb-2">
          <select class="form-select mx-1" name="category" aria-label="Default select example">
            <option value="" selected disabled>Select Category</option>
            <?php
            foreach ($categories as $category) {
              if ($category["id"] == $product[0]["category_id"]) {
            ?>
                <option selected value="<?php echo $category["id"] ?>"><?php echo $category["name"] ?></option>
              <?php
              } else {
              ?>
                <option value="<?php echo $category["id"] ?>"><?php echo $category["name"] ?></option>
            <?php
              }
            }
            ?>
          </select>

          <select class="form-group form-select mx-1" name="size" aria-label="Default select example">

            <option value="" disabled>Select Size</option>
            <option value="NULL" selected>No Size</option>
            <?php
            foreach ($sizes as $size) {
              if ($size["id"] == $product[0]["size_id"]) {
            ?>
                <option selected value="<?php echo $size["id"] ?>"><?php echo $size["name"] ?></option>
              <?php
              } else {
              ?>
                <option value="<?php echo $size["id"] ?>"><?php echo $size["name"] ?></option>
            <?php
              }
            }
            ?>
          </select>

        </div>

        <div class="form-row">
          <div class="form-group col-md-5">
            <label for="inputEmail4">Product Color</label>
            <input type="text" name="color" class="form-control" value="<?php echo $product[0]["color"]; ?>" id="inputEmail4" placeholder="Color" required>
          </div>
        </div>

        <div class="form-group">
          <label for="inputAddress">description</label>
          <textarea class="form-control" name="desc" id="inputAddress"><?php echo $product[0]["description"]; ?></textarea>
        </div>


        <div class="form-row">

          <div class="form-group col-md-6">
            <label for="inputEmail4">Product Quantity</label>
            <input type="number" name="quantity" class="form-control" value="<?php echo $product[0]["quantity"]; ?>" id="inputEmail4" required>
          </div>

          <div class="form-group col-md-6">
            <label for="inputEmail4">Product Price</label>
            <div class="input-group mb-3">
              <input type="number" step="0.01" placeholder="0.00" name="price" value="<?php echo $product[0]["start_price"]; ?>" class="form-control" aria-label="Amount (to the nearest dollar)" required>
              <span class="input-group-text">$</span>
            </div>
          </div>

        </div>

        <div class="mb-3">
          <img src="<?php echo $product[0]['image'] ?>"  alt="<?php echo $product[0]['name'] ?>" width="250"><br />
          <label for="formFileMultiple" class="form-label">Add Product Photos</label>
          <input class="form-control" type="file" name="img" id="formFileMultiple" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
      </form>
    </div>
  </div>
</section>
<!--================End Cart Area =================-->

<?php
require_once './layout/footer.php';
?>