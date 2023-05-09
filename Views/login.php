<?php
require_once '../Models/User.php';
require_once '../Controller/Authcontroller.php';
$errMsg = "";


if (isset($_POST['username']) && isset($_POST['password'])) {
	if (!empty($_POST['username']) && !empty($_POST['password'])) {

		$user = new User;
		$auth = new AuthController;
		$user->username = $_POST['username'];
		$user->password = $_POST['password'];
		if (!$auth->login($user)) {
			if (session_status() === PHP_SESSION_NONE) {
				session_start();
			}
			echo "<div class=\"alert alert-danger\" role=\"alert\">" . $_SESSION["errMsg"] . "</div>";
			if (isset($_SESSION["errMsg"])) {
				unset($_SESSION['errMsg']);
			}

		} else {
			//////////
			if ($auth->getCurrentUser() != false) {
				$currentUser = $auth->getCurrentUser();
				if ($auth->getUserRole($currentUser) == "seller") {
					header("location: ../views/manage-products.php");
				} else if ($auth->getUserRole($currentUser) == "admin") {
					header("location: ../views/admin.php");
				} else {
					header("location: ../views/index.php");
				}
			} else {
				$_SESSION["errMsg"] =  "you must login or regester first";
			}
			//////////

		}
	} else {
		$errMsg = "Please fill all fields";
	}
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
				<h1>Login / Register</h1>
				<nav aria-label="breadcrumb" class="banner-breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active" aria-current="page">Login/Register</li>
					</ol>
				</nav>
			</div>
		</div>
	</div>
</section>
<!-- ================ end banner area ================= -->

<!--================Login Box Area =================-->
<section class="login_box_area section-margin">
	<div class="container">
		<div class="row">
			<div class="col-lg-6">
				<div class="login_box_img">
					<div class="hover">
						<h4>New to our website?</h4>
						<p>There are advances being made in science and technology everyday, and a good example of this is the</p>
						<a class="button button-account" href="register.php">Create an Account</a>
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="login_form_inner">
					<h3>Log in to enter</h3>
					<form class="row login_form" action="login.php" id="contactForm" method="post">
						<div class="col-md-12 form-group">
							<input type="text" class="form-control" id="name" name="username" placeholder="Username" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Username'">
						</div>
						<div class="col-md-12 form-group">
							<input type="password" class="form-control" id="name" name="password" placeholder="Password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Password'">
						</div>
						<div class="col-md-12 form-group">
							<div class="creat_account">
								<input type="checkbox" id="f-option2" name="selector">
								<label for="f-option2">Keep me logged in</label>
							</div>
						</div>
						<div class="col-md-12 form-group">
							<button type="submit" value="submit" class="button button-login w-100">Log In</button>
							<a href="#">Forgot Password?</a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
<!--================End Login Box Area =================-->



<!--================ End =================-->
<?php
require_once 'layout/footer.php';
?>