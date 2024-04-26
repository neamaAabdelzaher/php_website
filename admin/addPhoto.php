<?php 
include_once('./includes/dbconnect.php');
session_start() ;

// if user not log in
if(!isset($_SESSION['username']))
{
  header("Location:../notFound.php");


}
// user not allow to deal with admin panel
if(isset($_SESSION['username']))
{
  $user=$_SESSION['username'];
  $sql ="SELECT * FROM users Where username= ?";
  $stmt= $conn->prepare($sql);
  $stmt->execute([$user]);
  $result=$stmt->fetch();

  if($result['is_admin']=='Yes')
  {

    header('URL=addPhoto.php');
	




  }

  elseif($result['is_admin']=='No')

{
  header("Location:../notFound.php");

}}
if(isset($_POST['add_product'])) 
{
  	
 if(!empty($_FILES['prd_image']))
{
	$prd_date=$_POST['prd_date'];
	$prd_title=$_POST['prd_title'];
	$prd_License=$_POST['license'];
	$prd_dimension =$_POST['prd_dimension'];
	$img_formate =$_POST['img_formate'];
	if(isset($_POST['is_active']))
		{
			$is_active="Yes";
		}
		else{
			$is_active="No";

		}
	$prd_cat=$_POST['category'];
	$admin_name=$_POST['admin_name'];
	
// image properties
  $tmp_name=$_FILES['prd_image']['tmp_name'];
  $imageType=$_FILES['prd_image']['type'];
  $imageName=$_FILES['prd_image']['name'];
  $imageSize=$_FILES['prd_image']['size'];
  $error=$_FILES['prd_image']['error'];
  $folder="./img/".$imageName;
  echo $folder;
  if($error === 0)
  {

  $img_extension=pathinfo($imageName ,PATHINFO_EXTENSION); //to get extension of the file
  $img_extension_tarns=strtolower($img_extension);
  $valid_extensions=array("jpg","jpeg","png");
  if(in_array($img_extension_tarns,$valid_extensions))
  {
    
	//   insert image into data base
	$sql="INSERT INTO products (title,prd_date,prd_license,prd_dimension,image_formate,is_active,prd_image,username,cat_id) 
	VALUES (?,?,?,?,?,?,?,?,?)";
	$stmt=$conn->prepare($sql);
    $stmt->execute([$prd_title,$prd_date,$prd_License,$prd_dimension,$img_formate,$is_active,$imageName,$admin_name,$prd_cat]);

	if( move_uploaded_file($tmp_name,$folder))
	{
		
		$msg= "product added successfully";
		header("refresh:.5; URL=photos.php?msg=$msg");

	}

  }

  else{
	echo "error";
  }
}

else{
	header("Location: addPhoto.php");

}}}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<!-- Meta, title, CSS, favicons, etc. -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Images Admin | Add Photo</title>

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
						<a href="../index.php" class="site_title"><i class="fa fa-file-image-o"></i> <span>Images Admin</span></a>
					</div>

					<div class="clearfix"></div>

					<!-- menu profile quick info -->
					<div class="profile clearfix">
						<div class="profile_pic">
						<img src="./img/<?= $result['user_image'] ?>" alt="..." class="img-circle profile_img">

							
						</div>
						<div class="profile_info">
							<span>Welcome,</span>
							<h2><?=$_SESSION['username']?></h2>
						</div>
					</div>
					<!-- /menu profile quick info -->

					<br />

					<!-- sidebar menu -->
					<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
						<div class="menu_section">
							<h3>General</h3>
							<ul class="nav side-menu">
								<li><a><i class="fa fa-users"></i> Users <span class="fa fa-chevron-down"></span></a>
									<ul class="nav child_menu">
										<li><a href="users.php">Users List</a></li>
										<li><a href="addUser.php">Add User</a></li>
									</ul>
								</li>
								<li><a><i class="fa fa-edit"></i> Tags <span class="fa fa-chevron-down"></span></a>
									<ul class="nav child_menu">
										<li><a href="addCategory.php">Add Tag</a></li>
										<li><a href="categories.php">Tags List</a></li>
									</ul>
								</li>
								<li><a><i class="fa fa-desktop"></i> Photos <span class="fa fa-chevron-down"></span></a>
									<ul class="nav child_menu">
										<li><a href="addPhoto.php">Add Photo</a></li>
										<li><a href="photos.php">Photos List</a></li>
									</ul>
								</li>
							</ul>
						</div>

					</div>
					<!-- /sidebar menu -->

					<!-- /menu footer buttons -->
					<div class="sidebar-footer hidden-small">
						<a data-toggle="tooltip" data-placement="top" title="Settings">
							<span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
						</a>
						<a data-toggle="tooltip" data-placement="top" title="FullScreen">
							<span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
						</a>
						<a data-toggle="tooltip" data-placement="top" title="Lock">
							<span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
						</a>
						<a data-toggle="tooltip" data-placement="top" title="Logout" href="../logout.php">
							<span class="glyphicon glyphicon-off" aria-hidden="true"></span>
						</a>
					</div>
					<!-- /menu footer buttons -->
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

                  <img src="./img/<?= $result['user_image'] ?>" alt=""><?=$_SESSION['username']?>
								</a>
								<div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
								<a class="dropdown-item" href="userProfile.php?username=<?= $_SESSION['username'] ?>"> Profile</a>
                  <a class="dropdown-item" href="../logout.php"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
								</div>
							</li>

							<li role="presentation" class="nav-item dropdown open">
								<a href="javascript:;" class="dropdown-toggle info-number" id="navbarDropdown1" data-toggle="dropdown" aria-expanded="false">
									<i class="fa fa-envelope-o"></i>
									<span class="badge bg-green">6</span>
								</a>
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
				<div class="">
					<div class="page-title">
						<div class="title_left">
							<h3>Manage Photos</h3>
						</div>

						<div class="title_right">
							<div class="col-md-5 col-sm-5  form-group pull-right top_search">
								<div class="input-group">
									<input type="text" class="form-control" placeholder="Search for...">
									<span class="input-group-btn">
										<button class="btn btn-default" type="button">Go!</button>
									</span>
								</div>
							</div>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="row">
						<div class="col-md-12 col-sm-12 ">
							<div class="x_panel">
								<div class="x_title">
									<h2>Add Photo</h2>
									<ul class="nav navbar-right panel_toolbox">
										<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
										</li>
										<li class="dropdown">
											<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-wrench"></i></a>
											<ul class="dropdown-menu" role="menu">
												<li><a class="dropdown-item" href="#">Settings 1</a>
												</li>
												<li><a class="dropdown-item" href="#">Settings 2</a>
												</li>
											</ul>
										</li>
										<li><a class="close-link"><i class="fa fa-close"></i></a>
										</li>
									</ul>
									<div class="clearfix"></div>
								</div>
								<div class="x_content">
									<br />
									<form method="post" action="" id="demo-form2" enctype="multipart/form-data"  data-parsley-validate class="form-horizontal form-label-left">
										<!-- product-date -->
									<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="product-date">Product Date <span class="required">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<input type="date" name="prd_date" id="product-date" required="required" class="form-control ">
											</div>

										</div> 
										<!-- product title -->
										 <div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="title">Title <span class="required">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<input type="text" name="prd_title" id="title" required="required" class="form-control ">
											</div>
										</div> 
										<!-- product license -->
										 <div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="license">License <span class="required">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<textarea id="content" name="license" required="required" class="form-control">License</textarea>
											</div>
										</div> 
										<!-- product dimension -->
										 <div class="item form-group">
											<label for="dimension" class="col-form-label col-md-3 col-sm-3 label-align">Dimension <span class="required">*</span></label>
											<div class="col-md-6 col-sm-6 ">
												<input type="text" name="prd_dimension" id="dimension"  class="form-control"  name="dimension" required="required">
											</div>
										</div> 
										<!-- product image Formate   -->
										 <div class="item form-group">
											<label for="format" class="col-form-label col-md-3 col-sm-3 label-align">Format <span class="required">*</span></label>
											<div class="col-md-6 col-sm-6 ">
												<input type="text" name="img_formate" id="format" class="form-control"  name="format" required="required">
											</div>
										</div> 
										<!-- product active or not  -->
										<div class="item form-group">
										
                                          <label for="is_active" class="col-form-label col-md-3 col-sm-3 label-align">Active</label>	
				
											<div class="checkbox">

												<label>
											
  						                   	
  						                   	 <input type="checkbox"  class="flat" id="is_active"  name="is_active" >
													
												</label>
											</div>
										</div>
										<!-- product image -->
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="image">Image <span class="required">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<input type="file" id="image"  name="prd_image" required="required" class="form-control">
											</div>
										</div>

										
											
                                           <!-- show category list  -->
										   <?php 
									      $sql="SELECT * FROM category";
										 $data= $conn->query( $sql);
										 
										 if($data->rowCount() >0)
											
										 {
											
										   ?>
										        
										  
										 <div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="title">Category Data:<span class="required">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<select class="form-control" name="category" id=""> <?php foreach($data as $cat) 
											{  
												?>
													
													<option value="<?=$cat['cat_id']?>"> <?=$cat['cat_id']."_".$cat['cat_name']?>
													 </option> <?php } ?>
													
												</select>  
											</div>
										</div> 

										<?php }?>

										<!-- Admin Name -->
										<div class="item form-group">
											<label for="dimension" class="col-form-label col-md-3 col-sm-3 label-align">Admin Name <span class="required">*</span></label>
											<div class="col-md-6 col-sm-6 ">
												<input type="text" value="<?=$_SESSION['username']?>" name="admin_name" id="dimension"  class="form-control"  name="dimension" required="required">
											</div>
										</div> 
										<div class="ln_solid"></div>
										<div class="item form-group">
											<div class="col-md-6 col-sm-6 offset-md-3">
												<button class="btn btn-primary" type="button">Cancel</button>
												<button type="submit" name="add_product" class="btn btn-success">Add</button>
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

</body></html>
