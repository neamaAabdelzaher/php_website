<?php

include_once('./admin/includes/dbconnect.php');
// start session
session_start();
// sign up

if (isset($_POST['submit'])) {
  $uFullName = $_POST['uFullName'];
  $uName = $_POST['uName'];
  $uEmail = $_POST['uEmail'];
  $uPassword = $_POST['uPassword'];
  $sql= "SELECT username FROM users where username = '$uName'";
  $data=$conn->query($sql);
  if($data->rowCount()==0){
        $sql = "INSERT INTO users (full_name,username,email,password) VALUES (?,?,?,?)";
        $stmt = $conn->prepare($sql);
       
      
       $res=$stmt->execute([$uFullName, $uName, $uEmail, $uPassword]);
    
        $msg="register has been succeed";
       
        header("Location: login.php?msg=$msg");

        exit;
  }
  else{
        $msg="username is not available! ";
        header("Location: signup.php?msg=$msg");

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
  <div>

      <div id="register"  class="animate login_wrapper">
        <section class="login_content">
          <form method="post" action="">
            <h1>Create Account</h1>
            <div>
              <input type="text" name="uFullName" class="form-control" placeholder="Fullname" required="" />
             
            <div>
             
            <input type="text" name="uName" class="form-control" placeholder="Username" required="" />
            <div <?php if(isset($_GET['msg'])){?> class="alert alert-danger  w-100 " role="alert">
                        <?php  echo  "<p> ".$_GET['msg']."</p>";}?>
                        </div>
            </div>
            </div>
            <div>
              <input type="email" name="uEmail" class="form-control" placeholder="Email" required="" />
            </div>
            <div>
              <input type="password" name="uPassword" class="form-control" placeholder="Password" required="" />
            </div>
            <div>
              <button type="submit" class="btn btn-default submit" name="submit" >Submit</button>
            </div>

            <div class="clearfix"></div>

            <div class="separator">
              <p class="change_link">Already a member ?
                <a href="login.php" class="to_register"> Log in </a>
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
  </div>
</body>

</html>