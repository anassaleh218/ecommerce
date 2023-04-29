<?php
require_once './layout/header.php';
require_once '../Models/product.php';
require_once '../Controller/ProductController.php';

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

$products = $productController->getAllProducts();

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

        <table class="table">
            <thead class="thead-dark">
                <tr>
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
                        <th scope="row"><?php echo $product['name'] ?> </th>
                        <td><?php echo $product['price'] ?></td>
                        <td><?php echo $product['quantity'] ?></td>
                        <td><?php echo $product['category'] ?></td>
                        <td>
                            <form action="" method="post">
                                <input type="hidden" value="<?php echo $product['id'] ?>">
                                <button type="hidden" name="" class="btn btn-warning">Modify</button>
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