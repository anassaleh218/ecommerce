<?php
require_once '../Models/admin.php';
require_once '../Models/category.php';
require_once '../Controller/AdminController.php';
require_once '../Controller/ProductController.php';
require_once '../Controller/Authcontroller.php';

?>


<?php
$errMsg = "";
$adminC = new AdminController;
$productController = new ProductController;


///////////////////
$auth = new AuthController;
if($auth->getCurrentUser() != false){
  $currentUser = $auth->getCurrentUser();
  print_r($currentUser);
  echo "<br />" . $auth->getUserRole();
}else{
  $_SESSION["errMsg"] =  "you must login or regester first";
}
//////////////////


/////////// add category ///////////
if (isset($_POST['catName'])) {
  if (!empty($_POST['catName'])) {
    $cat = new Category;
    $cat->setName($_POST['catName']);

    if (!$adminC->addCategory($cat)) {
      if (session_status() === PHP_SESSION_NONE) {
        session_start();
      }
      $errMsg = $_SESSION["errMsg"];
    } else {
      echo "<div class=\"alert alert-success\" role=\"alert\">category \"" . $cat->getName() . "\" added successfully</div>";
    }
  } else {
    $errMsg = "Please fill all fields";
  }
}
/////////// End add category ////////


/////////// delete category ///////////
if (isset($_POST['catId'])) {
  if (!empty($_POST['catId'])) {
    $catId = $_POST['catId'];
    if (!$adminC->deleteCategory($catId)) {
      if (session_status() === PHP_SESSION_NONE) {
        session_start();
      }
      $errMsg = $_SESSION["errMsg"];
    } else {
      echo "<div class=\"alert alert-success\" role=\"alert\">category with id \"" . $catId . "\" deleted successfully</div>";
    }
  } else {
    $errMsg = "Please fill all fields";
  }
}
/////////// End delete category ////////


/////////// block user ///////////
if (isset($_POST['blockUser'])) {
  if (!empty($_POST['blockUser'])) {
    $adminC = new AdminController;
    $email = $_POST['blockUser'];
    if (!$adminC->blockUser($email)) {
      $errMsg = $_SESSION["errMsg"];
    } else {
      echo "<div class=\"alert alert-success\" role=\"alert\">user with email \"" . $email . "\" blocked successfully</div>";
    }
  } else {
    $errMsg = "Please fill all fields";
  }
}
/////////// End block user ////////


/////////// unblock user ///////////
if (isset($_POST['unblockUser'])) {
  if (!empty($_POST['unblockUser'])) {
    $adminC = new AdminController;
    $email = $_POST['unblockUser'];
    if (!$adminC->unblockUser($email)) {
      $errMsg = $_SESSION["errMsg"];
    } else {
      echo "<div class=\"alert alert-success\" role=\"alert\">user with email \"" . $email . "\" unblocked successfully</div>";
    }
  } else {
    $errMsg = "Please fill all fields";
  }
}
/////////// End unblock user ////////

?>


<?php
require_once 'layout/header.php';
?>
<!-- ================ start banner area ================= -->
<section class="blog-banner-area" id="category">
  <div class="container h-100">
    <div class="blog-banner">
      <div class="text-center">
      <h1>Admin</h1>
        <nav aria-label="breadcrumb" class="banner-breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Admin</li>
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
    <div class="col-6 mx-auto">
    <h2 class="mb-2">Manage Category:</h2>

      <?php

      if ($errMsg != "") {
      ?>
        <div class="alert alert-danger" role="alert"><?php echo $errMsg ?></div>
      <?php
      }

      ?>
      <form method="post" action="admin.php">
        <div class="form-group">
          <label for="exampleInputEmail1">Add Category</label>
          <input type="text" class="form-control" id="exampleInputEmail1" name="catName" aria-describedby="emailHelp" placeholder="Enter Category name">
          <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
        </div>
        <button type="submit" class="btn btn-primary">Add</button>
      </form>

      <?php
      if ($productController->getCategories()) {
        $categories = $productController->getCategories();
      ?>
        <ul class="list-group mt-3">
          <li href="#" class="list-group-item list-group-item-secondary"><b>All Categories</b></li>
          <?php

          foreach ($categories as $category) {
          ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <?php echo $category['id'] . ": " . $category['name'] ?>
              <form method="post" action="admin.php">
                <input type="hidden" class="form-control" name="catId" value="<?php echo $category['id'] ?>">
                <span class="badge rounded-pill"><button type="submit" class="btn btn-primary">delete</button></span>
              </form>

            </li>

          <?php
          }
          ?>
        </ul>
      <?php
      }
      ?>
    </div>
  </div>


  <br />

</section>

<!--================End Cart Area =================-->
<hr />
<!--================Cart Area =================-->
<section class="cart_area">
<div class="container">
    <div class="col-6 mx-auto">
    <h2 class="mb-2">Manage Users:</h2>

      <form method="post" action="admin.php">
        <div class="form-group">
          <label for="exampleInputEmail1">Block user</label>
          <input type="text" class="form-control" id="exampleInputEmail1" name="blockUser" aria-describedby="emailHelp" placeholder="Enter user email">
        </div>
        <button type="submit" class="btn btn-primary">Block</button>
      </form>


      <?php
      if ($adminC->getBlockUsers()) {
        $blockedUsers = $adminC->getBlockUsers();
      ?>
        <ul class="list-group mt-3">
          <li href="#" class="list-group-item list-group-item-secondary"><b>Blocked users</b></li>
          <?php

          foreach ($blockedUsers as $user) {
          ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <?php echo " Name: " . $user['fullname'] . " / Email: " . $user['email'] ?>
              <form method="post" action="admin.php">
                <input type="hidden" class="form-control" name="unblockUser" value="<?php echo $user['email'] ?>">
                <span class="badge rounded-pill"><button type="submit" class="btn btn-primary">unblock</button></span>
              </form>

            </li>

          <?php
          }
          ?>
        </ul>
      <?php
      }
      ?>


    </div>
  </div>
</section>
<!--================End Cart Area =================-->


<!--================ End =================-->
<?php
require_once 'layout/footer.php';
?>