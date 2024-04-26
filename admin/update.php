<?php
include_once('./includes/dbconnect.php');
session_start();

// if user not log in
if (!isset($_SESSION['username'])) {
   header("Location:../notFound.php");
 }
 // user not allow to deal with admin panel
 if (isset($_SESSION['username'])) {
   $user = $_SESSION['username'];
   $sql = "SELECT * FROM users Where username= ?";
   $stmt = $conn->prepare($sql);
   $stmt->execute([$user]);
   $result = $stmt->fetch();
 
   if ($result['is_admin'] == 'Yes') {
 
     header('URL=users.php');
   } elseif ($result['is_admin'] == 'No') {
     header("Location:../notFound.php");
   }}
// update user data
if(isset($_POST['edit']))
{
   if(isset($_POST['is_active']))
   {
      $is_admin="Yes";
   }
   else{
      $is_admin="No";

   }
  
   $fullName=$_POST['fullName'];
   $uName=$_POST['userName'];
   $email=$_POST['email'];
   $password=$_POST['password'];

   $sql="UPDATE users SET  full_name='$fullName', email='$email' ,is_admin='$is_admin',password='$password' WHERE username= ?";
   $stmt= $conn->prepare($sql);
   $stmt->execute([$uName]);
   if($stmt->rowCount()>0){

          $msg="user updated successfully";
          header("refresh:.5;URL=users.php?msg=$msg");
          
   }
   

 
}




// update category name
if(isset($_POST['update_catName']))
{
	$catInputName=$_POST['cat_name'];
	$catId=$_POST['cat_id'];



	$sql="UPDATE category SET cat_name='$catInputName' WHERE cat_id= ?";
	$stmt=$conn->prepare($sql);
   $stmt->execute([$catId]);
   if($stmt->rowCount()>0){


   $msg= "category updated successfully";
   header("refresh:.5; URL=categories.php?msg=$msg");
   
   }
 
}


// update product data 
if(isset($_POST['update_prd']))
{

   
	$prd_id=$_POST['prd_id'];
	$prd_date=$_POST['prd_date'];
	$prd_title=$_POST['prd_title'];
	$prd_License=$_POST['license'];
	$prd_dimension =$_POST['dimension'];
	$img_formate =$_POST['format'];
	$category =$_POST['category'];
	if(isset($_POST['is_active']))
		{
			$is_active="Yes";
		}
		else{
			$is_active="No";

		}

// image properties
if(!empty($_FILES['image']) )
{
  

  $tmp_name=$_FILES['image']['tmp_name'];
//   $imageType=$_FILES['image']['type'];
  $imageName=$_FILES['image']['name'];
//   $imageSize=$_FILES['image']['size'];
  $error=$_FILES['image']['error'];

  $folder="./img/".$imageName;
  if($error === 0)
  {

  $img_extension=pathinfo($imageName ,PATHINFO_EXTENSION); //to get extension of the file
  $img_extension_tarns=strtolower($img_extension);
  $valid_extensions=array("jpg","jpeg","png");
  if(in_array($img_extension_tarns,$valid_extensions))
  {
    
	//   updating product
	$sql="UPDATE products SET title='$prd_title',prd_date='$prd_date',prd_license='$prd_License',prd_dimension='$prd_dimension',image_formate='$img_formate',is_active='$is_active',prd_image='$imageName' ,cat_id='$category'
	WHERE prd_id=? ";
	$stmt=$conn->prepare($sql);
    $stmt->execute([$prd_id]);

	if(move_uploaded_file($tmp_name,$folder))
	{
		
	
    $msg= "product updated successfully";
    header("refresh:2; URL=photos.php?msg=$msg");

	}


  }

  else{
	echo "no image extension !";
  }
}
}




}

?>