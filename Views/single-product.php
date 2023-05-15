<?php
require_once '../Controller/ProductController.php';
require_once '../Controller/CartController.php';
require_once '../Controller/Authcontroller.php';
require_once '../Models/feedback.php';

if (session_status() === PHP_SESSION_NONE) {
	session_start();
}

$productController = new ProductController;
$auth = new AuthController;
$currentUser = $auth->getCurrentUser();


if (isset($_GET['id'])) {
	if (!empty($_GET['id'])) {
		$id = $_GET['id'];
		if ($productController->getProductById($id)) {
			$product = $productController->getProductById($id)[0];
			// print_r($product);
			if (isset($_GET['add']) && isset($_GET['quantity'])) {
				if ($auth->getCurrentUser() != false) {
					$cart = new CartController();
					$currentUser = $auth->getCurrentUser();
					$quantity = $_GET['quantity'];
					try {
						$cart->addToCart($currentUser, $product["id"], $quantity);
						echo "<div class=\"alert alert-success\" role=\"alert\">added successfully to the <a href=\"cart.php\" >Cart</a></div>";
					} catch (Exception $e) {
						echo "<div class=\"alert alert-success\" role=\"alert\">already exists in the <a href=\"cart.php\" >Cart</a></div>";
						// echo 'Message: ' . $e->getMessage();
					}
				} else {
					if (session_status() === PHP_SESSION_NONE) {
						session_start();
					}
					$_SESSION["errMsg"] =  "you must login or regester first";
					header("location: ../views/login.php");
				}
			}
		} else {
			$_SESSION["errMsg"] =  "no product by this id";
			header("location: ../views/index.php");
		}
	} else {
		$_SESSION["errMsg"] =  "no product by this id";
		header("location: ../views/index.php");
	}
} else {
	$_SESSION["errMsg"] =  "no product by this id";
	header("location: ../views/index.php");
}



$feedback = new Feedback;

if (isset($_POST['rate']) && isset($_POST['feedback'])) {
	if (!empty($_POST['feedback']) && !empty($_POST['rate'])) {
		$feedback->adding($currentUser->fullname, $_POST['rate'], $_POST['feedback'], $currentUser->id, $product["id"]);
		if ($productController->addFeedback($feedback)) {
			header("location: ../Views/single-product.php?id=" . $product['id'] . "");
		} else {
			// $errMsg = $_SESSION["errMsg"] =  "error in adding bill";
		}
	}
}

$getFeedback = $productController->getFeedback($product["id"]);



?>



<?php
require_once 'layout/header.php';
?>



<!--================Single Product Area =================-->
<div class="product_image_area">
	<div class="container">
		<div class="row s_product_inner">
			<div class="col-lg-6">
				<div class="owl-carousel owl-theme s_Product_carousel">
					<div class="single-prd-item">
						<img class="img-fluid" src="<?php echo $product["image"]; ?>" alt="">
					</div>

				</div>
			</div>
			<div class="col-lg-5 offset-lg-1">
				<div class="s_product_text">
					<h3><?php echo $product["name"]; ?></h3>
					<h2>$<?php echo $product["start_price"]; ?></h2>
					<ul class="list">
						<li><span>category</span> : <?php echo $product["category"]; ?></li>
						<li><span>Color</span> : <?php echo $product["color"]; ?></li>

						<?php if($product["size"]!= null){?>
							<li><span>Size</span> : <?php echo $product["size"]; ?></li>
						<?php }?>

						<li><span>Availibility</span> : <?php echo $product["status"]; ?></li>
					</ul>

					<p>description: <?php echo $product["description"]; ?></p>
					<div>
						<label for="qty">Quantity:</label>
						<form action="single-product.php">
							<input type="number" name="quantity" size="2" maxlength="12" value="1" title="Quantity:" class="input-text qty">
							<input type="hidden" name="id" value="<?php echo $product["id"]; ?>">
							<input type="hidden" name="add" value="">
							<button class="button primary-btn d-block mt-5">Add to Cart</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!--================End Single Product Area =================-->

<!--================Product Description Area =================-->
<section class="product_description_area">
	<div class="container">
		<ul class="nav nav-tabs" id="myTab" role="tablist">
			<li class="nav-item">
				<a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Description</a>
			</li>

			<li class="nav-item">
				<a class="nav-link active" id="review-tab" data-toggle="tab" href="#review" role="tab" aria-controls="review" aria-selected="false">Reviews</a>
			</li>
		</ul>
		<div class="tab-content" id="myTabContent">
			<div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
				<p><?php echo $product["description"]; ?></p>
			</div>

			<div class="tab-pane fade show active" id="review" role="tabpanel" aria-labelledby="review-tab">
				<div class="row">
					<div class="col-lg-6">


						<?php
						// print_r($getFeedback);
						if(empty($getFeedback)){
							// print_r($getFeedback)
							?>
							<h5>This Product Has No Feedback Yet !!</h5>
							<h4>Share Your Feedback With Us Now</h4>
							<?php
						}
						else{
						foreach ($getFeedback as $fb) {
						?>
							<div class="review_list">
								<div class="review_item">
									<div class="media">
										<div class="media-body">
											<h4><?php echo $fb["fullname"]; ?></h4>
											<?php

											for ($i = 0; $i < $fb["rate"]; $i++) {
											?>
												<i class="fa fa-star"></i>
											<?php
											}

											for ($i = $fb["rate"]; $i < 5; $i++) {
											?>
												<i class="fa-regular fa-star"></i>
											<?php

											}

											?>
										</div>
									</div>
									<p><?php echo $fb["feedback"]; ?></p>
									<hr>
								</div>

							</div>
						<?php
						}
					}
						?>
					</div>
					<div class="col-lg-6">
						<div class="review_box">
							<h4>Add a Review</h4>

							<form action="single-product.php?id=<?php echo $product['id'] ?>" method="post" class="form-contact form-review mt-3">

								<div class="form-group">
									<label> Enter Rate Out Of 5 :</label>
									<input class="form-control mb-3" name="rate" type="number" placeholder="Enter Rate" min="0" max="5">
								</div>
								<div class="form-group">
									<label> Feedback :</label>
									<textarea class="form-control  w-100" name="feedback" cols="30" rows="5" placeholder="Enter Message"></textarea>
								</div>
								<div class="form-group text-center text-md-right mt-3">
									<button type="submit" class="button button--active button-review">Submit Now</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!--================End Product Description Area =================-->



<?php
require_once 'layout/footer.php';
?>