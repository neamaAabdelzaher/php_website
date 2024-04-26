<?php 
session_start();
include_once('./admin/includes/dbconnect.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalog-Z Photo Detail Page</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/templatemo-style.css">
<!--
    
TemplateMo 556 Catalog-Z

https://templatemo.com/tm-556-catalog-z

-->
</head>
<body>
    <!-- Page Loader -->
    <div id="loader-wrapper">
        <div id="loader"></div>

        <div class="loader-section section-left"></div>
        <div class="loader-section section-right"></div>

    </div>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-film mr-2"></i>
                Catalog-Z
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link nav-link-1 active" aria-current="page" href="index.php">Photos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-3" href="about.php">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-4" href="contact.php">Contact</a>
                </li>
                <li class="nav-item dropdown open " <?php if (isset($_SESSION['username'])) { ?>>
                        <a href="" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                        <?php  
                     $query="SELECT user_image FROM users WHERE username  = ?  ";
                     $stmt= $conn->prepare($query);
                     $stmt->execute([$_SESSION['username']]);
                     $result=$stmt->fetch();
                     ?>
                            <img src="./admin/img/<?=$result['user_image']?>" width="100px" height="50px" class="rounded-circle w-50" alt=""><?php


                                                                                                    echo $_SESSION['username'];
                                                                                                } ?>
                        </a>
                        <div class="dropdown-menu dropdown pull-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="./admin/userProfile.php?username=<?=$_SESSION['username']?>"> Profile</a>
                            <a class="dropdown-item" href="logout.php"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                        </div>
                    </li>
                    <li class="nav-item" <?php if (!isset($_SESSION['username'])) { ?>>
                        <a class="nav-link nav-link-4" href="login.php">Sign In</a>
                    </li>
                <?php } ?>
            </ul>
            </div>
        </div>
    </nav>

    <div class="tm-hero d-flex justify-content-center align-items-center" data-parallax="scroll" data-image-src="./admin/img/hero.jpg">
        <form class="d-flex tm-search-form">
            <input class="form-control tm-search-input" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success tm-search-btn" type="submit">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>
    <?php
    if(isset($_GET['prd_id']))
    {
        $prd_id=$_GET['prd_id'];
        $query = "SELECT * FROM products WHERE prd_id  = ?  ";
        $stmt = $conn->prepare($query);
        $stmt->execute([$prd_id]);
        $result = $stmt->fetch();
        $catID=$result['cat_id'];
        $prdID=$result['prd_id'];
       


    
    ?>

    <div class="container-fluid tm-container-content tm-mt-60">
        <div class="row mb-4">
            <h2 class="col-12 tm-text-primary"><?=$result['title']?></h2>
        </div>
        <div class="row tm-mb-90">            
            <div class="col-xl-8 col-lg-7 col-md-6 col-sm-12">
                <img src="./admin/img/<?= $result['prd_image']?>" width="350px" height="350px" alt="Image" class="img-fluid">
                
            </div>

            
            <div class="col-xl-4 col-lg-5 col-md-6 col-sm-12">
                <div class="tm-bg-gray tm-video-details">
                    <p class="mb-4">
                        Please support us by making <a href="https://paypal.me/templatemo" target="_parent" rel="sponsored">a PayPal donation</a>. Nam ex nibh, efficitur eget libero ut, placerat aliquet justo. Cras nec varius leo.
                    </p>
                    <div class="text-center mb-5">
                        <a href="cart.php?prd_id=<?=$prdID?>" class="btn btn-primary tm-btn-big">Add To Cart</a>
                    </div>                    
                    <div class="mb-4 d-flex flex-wrap">
                        <div class="mr-4 mb-2">
                            <span class="tm-text-gray-dark">Product Dimension:</span><span class="tm-text-primary"><?=$result['prd_dimension']?></span>
                        </div>
                        <div class="mr-4 mb-2">
                            <span class="tm-text-gray-dark">Format: </span><span class="tm-text-primary"><?=$result['image_formate']?></span>
                        </div>
                    </div>
                    <div class="mb-4">
                        <h3 class="tm-text-gray-dark mb-3">License</h3>
                        <p>Free for both personal and commercial use. No need to pay anything. No need to make any attribution.</p>
                    </div>
                    <div>
                        <h3 class="tm-text-gray-dark mb-3">Tags</h3>
                        <?php
                        $sql="SELECT cat_name  FROM category";
                         $data=$conn->query($sql);
                         foreach($data as $cat){


                        ?>
                        <a href="#" class="tm-text-primary mr-4 mb-2 d-inline-block"><?=$cat['cat_name']?></a>
                        <?php }?>
                       
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row mb-4">
            <h2 class="col-12 tm-text-primary">
                Related Photos
            </h2>
        </div>
        <div class="row mb-3 tm-gallery">
            
               <?php 
            //    show related products according to category except the shown image
              $sql=" SELECT * FROM  products WHERE cat_id =$catID AND prd_id !=$prdID AND is_active='Yes' ";
              $data=$conn->query($sql);
              foreach($data as $img)
           {
               ?>
         
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-5">
                <figure class="effect-ming tm-video-item">
                    <img src="./admin/img/<?= $img['prd_image'] ?>" width="350px" height="350px" alt="Image" class="img-fluid">
                    <figcaption class="d-flex align-items-center justify-content-center">
                    <?php 
                            // inner join to show name of product category
                               $sql=" SELECT category.cat_name FROM category INNER JOIN products ON category.cat_id = products.cat_id AND products.prd_id= $prdID  ";
                               $data2=$conn->query($sql);
                               foreach($data2 as $cat)

                              {
                                ?>
                            <h2><?=$cat['cat_name']?></h2>
                            <?php } ?>
                        <a href="photo-detail.php?prd_id=<?= $img['prd_id'] ?>">View more</a>
                    </figcaption>                    
                </figure>
                <div class="d-flex justify-content-between tm-text-gray">
                    <span class="tm-text-gray-light"><?=$img['prd_date']?></span>
                    <span><?=$img['title']?></span>
                </div>
            </div>        
              <?php }?>
        </div> <!-- row -->
    </div> <!-- container-fluid, tm-container-content -->
    <?php }?>
    <footer class="tm-bg-gray pt-5 pb-3 tm-text-gray tm-footer">
        <div class="container-fluid tm-container-small">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-12 px-5 mb-5">
                    <h3 class="tm-text-primary mb-4 tm-footer-title">About Catalog-Z</h3>
                    <p>Integer ipsum odio, pharetra ac massa ac, pretium facilisis nibh. Donec lobortis consectetur molestie. Nullam nec diam dolor. Fusce quis viverra nunc, sit amet varius sapien.</p>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 px-5 mb-5">
                    <h3 class="tm-text-primary mb-4 tm-footer-title">Our Links</h3>
                    <ul class="tm-footer-links pl-0">
                        <li><a href="#">Advertise</a></li>
                        <li><a href="#">Support</a></li>
                        <li><a href="#">Our Company</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 px-5 mb-5">
                    <ul class="tm-social-links d-flex justify-content-end pl-0 mb-5">
                        <li class="mb-2"><a href="https://facebook.com"><i class="fab fa-facebook"></i></a></li>
                        <li class="mb-2"><a href="https://twitter.com"><i class="fab fa-twitter"></i></a></li>
                        <li class="mb-2"><a href="https://instagram.com"><i class="fab fa-instagram"></i></a></li>
                        <li class="mb-2"><a href="https://pinterest.com"><i class="fab fa-pinterest"></i></a></li>
                    </ul>
                    <a href="#" class="tm-text-gray text-right d-block mb-2">Terms of Use</a>
                    <a href="#" class="tm-text-gray text-right d-block">Privacy Policy</a>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-md-7 col-12 px-5 mb-3">
                    Copyright 2020 Catalog-Z Company. All rights reserved.
                </div>
                <div class="col-lg-4 col-md-5 col-12 px-5 text-right">
                    Designed by <a href="https://templatemo.com" class="tm-text-gray" rel="sponsored" target="_parent">TemplateMo</a>
                </div>
            </div>
        </div>
    </footer>
    
    <script src="js/plugins.js"></script>
    <script>
        $(window).on("load", function() {
            $('body').addClass('loaded');
        });
    </script>
</body>
</html>