<?php 
if(isset($_POST['back']))
{
    header("Location:index.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NOT FOUND</title>
    <!-- Option 1: Include in HTML -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/templatemo-style.css">

<style>


.page-not-found {
    background-color: #3f51b5;
    height: 100vh;
}
.page-not-found h2 {
    font-size: 130px;
    color: #e91e63;
}
.page-not-found h3 {
    font-size: 42px;
}
.page-not-found .bg-light {
    width: 50%;
    padding: 50px;
    text-align: center;
    border-radius: 5px;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

@media (max-width:  767px) {
    .page-not-found h2 {
        font-size: 100px;
    }
    .page-not-found h3 {
        font-size: 28px;
    }
    .page-not-found .bg-light {
        width: 100%;
    }
}
</style>

</head>
<body>
    
<div class="page-not-found pt-5">
    <div class="bg-light shadow">
        <h2>4<i class="bi bi-bug"></i>4</h2>
        <h3 class="mt-4">Opps! Page Not Found</h3>
        <p>Back Home To enjoy with our Products </p>
        <div class="mt-5">
              <form action=""  method="post">
            <button type="submit"  name="back"  class="btn m-2 m-md-0 btn-primary"><i class="bi bi-house-door-fill"></i> Back Home</button>

              </form>
        </div>
    </div>
</div>
</body>
</html>