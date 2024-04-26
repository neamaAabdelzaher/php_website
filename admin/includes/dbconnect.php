<?php
$localhost="localhost";
$username="root";
$password="";

try{
    
$conn= new PDO ("mysql:host=$localhost;dbname=un_project",$username,$password );
$conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);

// echo "successful connection";

}

catch(PDOException $e)

{
echo "failed connection".$e->getMessage();

}
?>

