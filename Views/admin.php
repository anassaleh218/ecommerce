<?php
require_once 'layout/header.php';

require_once '../Models/admin.php';
require_once '../Models/category.php';
require_once '../Controller/AdminController.php';
?>


<?php
$errMsg = "";
/////////// add category ///////////
if (isset($_POST['catName'])) {
  if (!empty($_POST['catName'])) {
    $cat = new Category;
    $cat->setName($_POST['catName']);
    $adminC = new AdminController;

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
    </div>
  </div>


  <br />
  <div class="container">
    <div class="col-6 mx-auto">
      <form method="post" action="admin.php">
        <div class="form-group">
          <label for="exampleInputEmail1">Block user</label>
          <input type="text" class="form-control" id="exampleInputEmail1" name="blockUser" aria-describedby="emailHelp" placeholder="Enter user email">
        </div>
        <button type="submit" class="btn btn-primary">Block</button>
      </form>
    </div>
  </div>
</section>
<!--================End Cart Area =================-->

<!--================Cart Area =================-->
<section class="cart_area">

</section>
<!--================End Cart Area =================-->


<!--================ End =================-->
<?php
require_once 'layout/footer.php';
?>