<?php

require_once '../Models/User.php';
require_once '../Controller/Authcontroller.php';
require_once '../Controller/DBController.php';

// // // // // // // // // // // // // if (session_status() === PHP_SESSION_NONE) {
// // // // // // // 	session_start();
// // // // // // //   }

$errMsg = "";
$user = new User();
$auth = new AuthController;
$roles = $auth->getRoles();


if (!isset($_SESSION["errMsg"])) {
	if (session_status() === PHP_SESSION_NONE) {
		session_start();
	}
	if (isset($_SESSION["errMsg"])) {
		echo "<div class=\"alert alert-danger\" role=\"alert\">" . $_SESSION["errMsg"] . "</div>";
		unset($_SESSION['errMsg']);
	}
}


if (isset($_POST['fullname']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['username']) && isset($_POST['phone']) && isset($_POST['address'])) {

	if (!empty($_POST['fullname']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['username']) && !empty($_POST['address']) && !empty($_POST['phone'])) {

		$user->fullname = $_POST['fullname'];
		$user->username = $_POST['username'];
		$user->email = $_POST['email'];
		$user->password = $_POST['password'];
		$user->phone = $_POST['phone'];
		$user->address = $_POST['address'];
		$user->roleid = $_POST['role'];

		if ($auth->register($user)) {
			//////////
			if ($auth->getCurrentUser() != false) {
				$currentUser = $auth->getCurrentUser();
				if ($auth->getUserRole($currentUser) == "seller") {
					header("location: manage-products.php");
				} else if ($auth->getUserRole($currentUser) == "admin") {
					header("location: admin.php");
				} else {
					header("location: index.php");
				}
			} else {
				$_SESSION["errMsg"] =  "you must login or regester first";
			}
			//////////
		} else {
			$errMsg = $_SESSION["errMsg"];
		}
	} else {


		// if($_POST['submitbutton']){
		$errMsg = "Please fill all fields";
		$_SESSION["submitbutton"] = "";

		// }

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
				<h1>Register</h1>
				<nav aria-label="breadcrumb" class="banner-breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active" aria-current="page">Register</li>
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
						<h4>Already have an account?</h4>
						<p>There are advances being made in science and technology everyday, and a good example of this is the</p>
						<a class="button button-account" href="login.php">Login Now</a>
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="login_form_inner register_form_inner" style="padding-top: 39px;">
					<h3 style=" margin-bottom: 22px; ">Create an account </h3>
					<form class="row login_form" action="register.php" id="register_form" method="post">
						<div class="col-md-12 form-group">
							<input type="text" class="form-control" id="FUllname" name="fullname" placeholder="Fullname" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Fullname'">
						</div>
						<div class="col-md-12 form-group">
							<input type="text" class="form-control" id="username" name="username" placeholder="Username" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Username'">
						</div>
						<div class="col-md-12 form-group">
							<input type="text" class="form-control" id="email" name="email" placeholder="Email Address" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email Address'">
						</div>
						<div class="col-md-12 form-group">
							<input type="password" class="form-control" id="password" name="password" placeholder="Password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Password'">
						</div>
						<div class="col-md-12 form-group">
							<input type="text" class="form-control" id="phone" name="phone" placeholder="phone no" onfocus="this.placeholder = ''" onblur="this.placeholder = 'phone no'">
						</div>

						<div class="col-md-12 form-group">
							<input type="text" class="form-control mb-4" id="address" name="address" placeholder="address" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Address'">

						</div>

						<legend class="col-form-label col-sm-2 pt-0">Roles:</legend>
						<div class="row ml-5">
							<?php
							foreach ($roles as $role) {
								if ($role['role_name'] != "admin") {


							?>
									<div class="form-check mr-5">
										<input class="form-check-input" type="radio" name="role" id="gridRadios1" value="<?php echo $role['id'] ?>" checked>
										<label class="form-check-label" for="gridRadios1">
											<?php echo $role['role_name'] ?>
										</label>
									</div>
							<?php
								}
							}
							?>
						</div>

						<?php
						if ($errMsg != "") {
						?>
							<div class="alert" style="padding: 20px; background-color: #f44336; color: white; margin-left: 15px; color: white; font-weight: bold; float: right;font-size: 22px;line-height: 20px;transition: 0.3s;">
								<?php
								echo $errMsg;
								?>
							</div>

						<?php
						}
						?>

						<div class="col-md-12 form-group mt-4">
							<button type="submit" value="submit" name="submitbutton" class="button button-login w-100">Register</button>
						</div>

					</form>
				</div>
			</div>
		</div>
	</div>

</section>
<!--================End Login Box Area =================-->



<?php
require_once 'layout/footer.php';

?>