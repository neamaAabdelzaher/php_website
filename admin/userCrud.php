<?php 
include_once('./includes/dbconnect.php');
session_start();

// update user profile
if(isset($_POST['edit_profile']))
{

   $fullName=$_POST['fullName'];
   $uName=$_POST['userName'];
   $email=$_POST['email'];
   $password=$_POST['password'];
   $user_image=$_FILES['user_image']['name'];
   $tmp_name=$_FILES['user_image']['tmp_name'];
   $error=$_FILES['user_image']['error'];
 
   $folder="./img/".$user_image;
   if($error === 0)
   {
 
   $img_extension=pathinfo($user_image,PATHINFO_EXTENSION); //to get extension of the file
   $img_extension_tarns=strtolower($img_extension);
   $valid_extensions=array("jpg","jpeg","png");
   if(in_array($img_extension_tarns,$valid_extensions))
   {

   $sql="UPDATE users SET  full_name='$fullName', email='$email',password='$password',user_image='$user_image' WHERE username= ?";
   $stmt= $conn->prepare($sql);
   $stmt->execute([$uName]);
   if($stmt->rowCount()>0){

      if(move_uploaded_file($tmp_name,$folder))
      {
         
         header("Location: ../index.php");

   
     }
   
   }
     else{
      echo "no image extension !";
     }
   
   
   
}}
}

// delete user profile 
if(isset($_POST['delete_profile'])){

    $uName=$_SESSION['username'];

    $sql="DELETE FROM  `users` WHERE `username`=?";
    
    $stmt=$conn->prepare($sql);
    $res=$stmt->execute([$uName]);
    if($res)
    {
       echo "your profile deleted successfully";
        header("refresh:.5;URL=../logout.php");
        
    
    }
   
}



?>