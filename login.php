<?php

include_once('./admin/includes/dbconnect.php');
// start session
session_start();


// login 
if (isset($_POST['login'])) {
  $username = $_POST['uName'];
  $password = $_POST['uPassword'];
  $sql = "SELECT * FROM users  WHERE username=? AND  password=?";
  $stmt = $conn->prepare($sql);
  $stmt->execute([$username, $password]);
  $data = $stmt->fetch();
  $user = $data['is_admin'];
  $_SESSION['username'] = $_POST['uName'];
  ;
  $_SESSION['password'] = $_POST['uPassword'];

  if ($data['username'] == $_POST['uName'] && $data["is_admin"] == "Yes") {

    header('refresh:1; URL=./admin/users.php');

  } elseif ($data['username'] == $_POST['uName'] && $data["is_admin"] == "No") {

    header('refresh:1; URL=index.php');
  } else {

    $msg = "invalid data!";
    header("refresh:.00001; URL=login.php?msg=$msg");
    exit;

  }
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

  <title>Images Admin | Login/Register</title>

  <!-- Bootstrap -->
  <link href="./admin/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="./admin/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <!-- NProgress -->
  <link href="./admin/vendors/nprogress/nprogress.css" rel="stylesheet">
  <!-- Animate.css -->
  <link href="./admin/vendors/animate.css/animate.min.css" rel="stylesheet">

  <!-- Custom Theme Style -->
  <link href="./admin/build/css/custom.min.css" rel="stylesheet">
</head>

<body class="login">



    <div class="login_wrapper">
      <div class="animate form login_form">
        <section class="login_content">
          <!-- login form  -->
          <h1>Login Form</h1>
          <form method="post" action="#">
           
            <div>

              <input type="text" name="uName" class="form-control" placeholder="Username" required="" />
              <div <?php if (isset($_GET['msg'])) { ?> class="alert alert-danger  w-100 " role="alert">
                  <?php echo $_GET['msg'];
              } ?>
              </div>
            </div>
            <div>
              <input type="password" name="uPassword" class="form-control" placeholder="Password" required="" />
            </div>
            <div>
              <button type="submit" name="login" class="btn btn-default submit">Log in</button>
              <a class="reset_pass" href="#">Lost your password?</a>
            </div>

            <div class="clearfix"></div>

            <div class="separator">
              <p class="change_link">New to site?
                <a href="signup.php" class="to_register"> Create Account </a>
              </p>

              <div class="clearfix"></div>
              <br />

              <div>
                <h1><i class="fa fa-file-image-o"></i></i> Images Admin</h1>
                <p>©2016 All Rights Reserved. Images Admin is a Bootstrap 4 template. Privacy and Terms</p>
              </div>
            </div>
          </form>
        </section>
      </div>


    </div>

</body>

</html>