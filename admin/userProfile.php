<?php
include_once('./includes/dbconnect.php');
session_start();
// if user not log in
if (!isset($_SESSION['username'])) {
	header("Location:../notFound.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<!-- Meta, title, CSS, favicons, etc. -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title> User Profile</title>

	<!-- Bootstrap -->
	<link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<!-- Font Awesome -->
	<link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<!-- NProgress -->
	<link href="vendors/nprogress/nprogress.css" rel="stylesheet">
	<!-- iCheck -->
	<link href="vendors/iCheck/skins/flat/green.css" rel="stylesheet">
	<!-- bootstrap-wysiwyg -->
	<link href="vendors/google-code-prettify/bin/prettify.min.css" rel="stylesheet">
	<!-- Select2 -->
	<link href="vendors/select2/dist/css/select2.min.css" rel="stylesheet">
	<!-- Switchery -->
	<link href="vendors/switchery/dist/switchery.min.css" rel="stylesheet">
	<!-- starrr -->
	<link href="vendors/starrr/dist/starrr.css" rel="stylesheet">
	<!-- bootstrap-daterangepicker -->
	<link href="vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

	<!-- Custom Theme Style -->
	<link href="build/css/custom.min.css" rel="stylesheet">
</head>

<body class="nav-md">
	<div class="container body">
		<div class="main_container">
			<div class="col-md-3 left_col">
				<div class="left_col scroll-view">
					<div class="navbar nav_title" style="border: 0;">
						<a href="../index.php" class="site_title"><i class="fa fa-file-image-o"></i> <span>Home Page</span></a>
					</div>


					<br />



				</div>
			</div>

			<!-- top navigation -->
			<div class="top_nav">
				<div class="nav_menu">
					<div class="nav toggle">
						<a id="menu_toggle"><i class="fa fa-bars"></i></a>
					</div>
					<nav class="nav navbar-nav">
						<ul class=" navbar-right">
							<li class="nav-item dropdown open" style="padding-left: 15px;">
								<a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
								<?php
                  $query = "SELECT user_image FROM users WHERE username  = ?  ";
                  $stmt = $conn->prepare($query);
                  $stmt->execute([$_SESSION['username']]);
                  $result = $stmt->fetch();
                  ?>

                  <img src="./img/<?= $result['user_image'] ?>" alt=""><?= $_SESSION['username'] ?>
								</a>
								<div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">

									<a class="dropdown-item" href="../logout.php"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
								</div>
							</li>

							<li role="presentation" class="nav-item dropdown open">

								<ul class="dropdown-menu list-unstyled msg_list" role="menu" aria-labelledby="navbarDropdown1">
									<li class="nav-item">
										<a class="dropdown-item">
											<span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
											<span>
												<span>John Smith</span>
												<span class="time">3 mins ago</span>
											</span>
											<span class="message">
												Film festivals used to be do-or-die moments for movie makers. They were where...
											</span>
										</a>
									</li>
									<li class="nav-item">
										<a class="dropdown-item">
											<span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
											<span>
												<span>John Smith</span>
												<span class="time">3 mins ago</span>
											</span>
											<span class="message">
												Film festivals used to be do-or-die moments for movie makers. They were where...
											</span>
										</a>
									</li>
									<li class="nav-item">
										<a class="dropdown-item">
											<span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
											<span>
												<span>John Smith</span>
												<span class="time">3 mins ago</span>
											</span>
											<span class="message">
												Film festivals used to be do-or-die moments for movie makers. They were where...
											</span>
										</a>
									</li>
									<li class="nav-item">
										<a class="dropdown-item">
											<span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
											<span>
												<span>John Smith</span>
												<span class="time">3 mins ago</span>
											</span>
											<span class="message">
												Film festivals used to be do-or-die moments for movie makers. They were where...
											</span>
										</a>
									</li>
									<li class="nav-item">
										<div class="text-center">
											<a class="dropdown-item">
												<strong>See All Alerts</strong>
												<i class="fa fa-angle-right"></i>
											</a>
										</div>
									</li>
								</ul>
							</li>
						</ul>
					</nav>
				</div>
			</div>
			<!-- /top navigation -->

			<!-- page content -->
			<div class="right_col" role="main">
				<div>

					<div class="clearfix"></div>
					<div class="row">
						<div class="col-md-12 col-sm-12 ">
							<div class="x_panel">
								<div class="x_title">
									<h2>User Information </h2>
									<ul class="nav navbar-right panel_toolbox">
										<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
										</li>
										<li><a class="close-link"><i class="fa fa-close"></i></a>
										</li>
									</ul>
									<div class="clearfix"></div>
								</div>
								<div class="x_content">
									<br />


									<?php
									if (isset($_GET['username'])) {

										$userName = $_GET['username'];

										$query = "SELECT * FROM users WHERE username  = ?  ";
										$stmt = $conn->prepare($query);
										$stmt->execute([$userName]);
										$result = $stmt->fetch();
									}
									?>
									<form method="post" action="userCrud.php" enctype="multipart/form-data" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Full Name <span class="required">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<input type="text" id="first-name" value="<?= $result['full_name'] ?>" name="fullName" required="required" class="form-control ">
											</div>
										</div>
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="user-name">Username <span class="required">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<input type="text" id="user-name" readonly name="userName" value="<?= $result['username'] ?>" required="required" class="form-control">
											</div>
										</div>
										<div class="item form-group">
											<label for="email" class="col-form-label col-md-3 col-sm-3 label-align">Email <span class="required">*</span></label>
											<div class="col-md-6 col-sm-6 ">
												<input id="email" class="form-control" type="email" name="email" value="<?= $result['email'] ?>" required="required">
											</div>
										</div>

										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="password">Password <span class="required">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<input type="text" id="password" name="password" value="<?= $result['password'] ?> " required="required" class="form-control">
											</div>
										</div>
										<!-- user image -->
										<div class="text-center">
											<img src="./img/<?= $result['user_image'] ?>" width="200px" height="200px" class=" img-thumbnail rounded m-2" alt="user picture">
										</div>
										
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="image">Change Image: <span class="required">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<input type="file" id="image" name="user_image" class="form-control">
											</div>
										</div>
										<div class="ln_solid"></div>
										<div class="item form-group">
											<div class="col-md-6 col-sm-6 offset-md-3">
												<button type="submit" name="delete_profile" class="btn btn-success">Delete Account</button>
												<button type="submit" name="edit_profile" class="btn btn-success">Update</button>
											</div>
										</div>

									</form>


								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
			<!-- /page content -->

			<!-- footer content -->
			<footer>
				<div class="pull-right">
					Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
				</div>
				<div class="clearfix"></div>
			</footer>
			<!-- /footer content -->
		</div>
	</div>

	<!-- jQuery -->
	<script src="vendors/jquery/dist/jquery.min.js"></script>
	<!-- Bootstrap -->
	<script src="vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
	<!-- FastClick -->
	<script src="vendors/fastclick/lib/fastclick.js"></script>
	<!-- NProgress -->
	<script src="vendors/nprogress/nprogress.js"></script>
	<!-- bootstrap-progressbar -->
	<script src="vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
	<!-- iCheck -->
	<script src="vendors/iCheck/icheck.min.js"></script>
	<!-- bootstrap-daterangepicker -->
	<script src="vendors/moment/min/moment.min.js"></script>
	<script src="vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
	<!-- bootstrap-wysiwyg -->
	<script src="vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js"></script>
	<script src="vendors/jquery.hotkeys/jquery.hotkeys.js"></script>
	<script src="vendors/google-code-prettify/src/prettify.js"></script>
	<!-- jQuery Tags Input -->
	<script src="vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>
	<!-- Switchery -->
	<script src="vendors/switchery/dist/switchery.min.js"></script>
	<!-- Select2 -->
	<script src="vendors/select2/dist/js/select2.full.min.js"></script>
	<!-- Parsley -->
	<script src="vendors/parsleyjs/dist/parsley.min.js"></script>
	<!-- Autosize -->
	<script src="vendors/autosize/dist/autosize.min.js"></script>
	<!-- jQuery autocomplete -->
	<script src="vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js"></script>
	<!-- starrr -->
	<script src="vendors/starrr/dist/starrr.js"></script>
	<!-- Custom Theme Scripts -->
	<script src="build/js/custom.min.js"></script>

</body>

</html>