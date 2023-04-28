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
          <form>
              <div class="form-group">
                <label for="exampleInputEmail1">Add Category</label>
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Category name">
                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
              </div>
       <!--       <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
              </div>
              -->
             <!--  <div class="form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Check me out</label>
              </div>
              -->
              <button type="submit" class="btn btn-primary">Add</button>
            </form>
      </div>
    </div>


<br />
    <div class="container">
        <div class="col-6 mx-auto">
            <form>
                <div class="form-group">
                  <label for="exampleInputEmail1">Block user</label>
                  <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter user id">
                  <!--<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                </div>
         <!--       <div class="form-group">
                  <label for="exampleInputPassword1">Password</label>
                  <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                </div>
                -->
               <!--  <div class="form-check">
                  <input type="checkbox" class="form-check-input" id="exampleCheck1">
                  <label class="form-check-label" for="exampleCheck1">Check me out</label>
                </div>
                -->
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