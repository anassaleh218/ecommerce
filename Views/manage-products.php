<?php
require_once '../Models/product.php';
require_once '../Controller/ProductController.php';
require_once '../Controller/Authcontroller.php';

//// check if user is login and seller /////
$auth = new AuthController;
if ($auth->getCurrentUser() != false) {
  $currentUser = $auth->getCurrentUser();
  if($auth->getUserRole($currentUser) != "seller"){
    if (!isset($_SESSION["errMsg"])) {
      session_start();
    }
    $_SESSION["errMsg"] =  "you must be Seller";
    header("location: ../views/login.php");
  }
} else {
  if (!isset($_SESSION["errMsg"])) {
    session_start();
  }
  $_SESSION["errMsg"] =  "you must login or regester first";
  header("location: ../views/login.php");
}
/////////////////////////////////////////


$deleteMsg = "";
$productController = new ProductController;

if (isset($_POST['delete'])) {
    if (!empty($_POST['productId'])) {
        if ($productController->deleteProduct($_POST['productId'])) {
            $deleteMsg = "Product Deleted Successfully";
            $productController->getAllProducts();
        }
    }
}

$products = $productController->getSellerProducts($currentUser);

?>


<?php
require_once 'layout/header.php';
?>
<!-- ================ start banner area ================= -->
<section class="blog-banner-area" id="category">
    <div class="container h-100">
        <div class="blog-banner">
            <div class="text-center">
                <h1>Manage-Product</h1>
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

<!--================Cart Area =================-->
<section class="cart_area">
    <div class="container">
        <?php

        if ($deleteMsg != "") {
        ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $deleteMsg ?>
            </div>
        <?php
        }

        ?>


        <a href="add-product.php" class="button  float-right mb-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-plus-fill" viewBox="0 0 16 16">
                <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zM8.5 7v1.5H10a.5.5 0 0 1 0 1H8.5V11a.5.5 0 0 1-1 0V9.5H6a.5.5 0 0 1 0-1h1.5V7a.5.5 0 0 1 1 0z" />
            </svg>
            Add Product
        </a>



        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Image</th>
                    <th scope="col">Product Name</th>
                    <th scope="col">Price</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Category</th>
                    <th scope="col">Modify</th>
                    <th scope="col">Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($products as $product) {
                ?>
                    <tr>
                        
                        <td><img src="<?php echo $product['image'] ?>" alt="<?php echo $product['name'] ?>" width="250"></td>
                        <th scope="row"><?php echo $product['name'] ?> </th>
                        <td><?php echo $product['price'] ?></td>
                        <td><?php echo $product['quantity'] ?></td>
                        <td><?php echo $product['category'] ?></td>
                        <td>
                            <form action="update-product.php" method="post">
                            <input type="hidden" name="productId" value="<?php echo $product['id'] ?>">
                                <button type="hidden"  class="btn btn-warning">Modify</button>
                            </form>
                        </td>
                        <td>
                            <form action="manage-products.php" method="post">
                                <input type="hidden" name="productId" value="<?php echo $product['id'] ?>">
                                <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

    </div>
</section>

<!--================End Cart Area =================-->

<?php
require_once './layout/footer.php';
?>