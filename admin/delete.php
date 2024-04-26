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
 
//delete user
if(isset($_GET['username'])){
    $userName=$_GET['username'];

    $sql="DELETE FROM  `users` WHERE `username`=?";
    
    $stmt=$conn->prepare($sql);
    $res=$stmt->execute([$userName]);
    if($res)
    {
        $msg="user deleted successfully";
        header("refresh:.5;URL=users.php?msg=$msg");
        
    
    }
   
}


// delete category
if(isset($_GET['cat_id']))
{ 
  $categoryId=$_GET['cat_id'];

  $sql= "SELECT prd_id  FROM products where cat_id =$categoryId";
  $data=$conn->query($sql);
if( $data->rowCount()<=0)
{

    $sql="DELETE FROM  `category` WHERE `cat_id`=?";
    
    $stmt=$conn->prepare($sql);
    $stmt->execute([$categoryId]);
    
   $msg= "category deleted successfully";
    header("refresh:.5; URL=categories.php?msg=$msg");
}
else{
  $msg= "category can't be deleted";
    header("refresh:.5; URL=categories.php?msg=$msg");
}
}
// delete products

if(isset($_GET['prd_id']))
{
    $productId=$_GET['prd_id'];
  

    $sql="DELETE FROM  `products` WHERE `prd_id`=?";
    
    $stmt=$conn->prepare($sql);
    $stmt->execute([$productId]);
    
    $msg= "product deleted successfully";
    header("refresh:2; URL=photos.php?msg=$msg");

}




?>