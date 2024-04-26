<?php
include_once('./admin/includes/dbconnect.php');
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
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
    <nav class="navbar navbar-expand-lg ">
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
                    // if(empty($result['user_image']))
                    // {
                    //     echo "there is no picture";
                    // }
                     ?>
                           <img <?php if(!empty($result['user_image'])){?>  src="./admin/img/<?=$result['user_image'] ?>" <?php } else {?> src="admin/img/userprofile4.jpg" <?php }?> width="100px" height="50px" class="rounded-circle w-50" alt="user image"> <?php

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

    <div class="container-fluid tm-container-content tm-mt-60">
        <div class="row mb-4">
            <?php 
                 $start=0;
                 $products_per_page=8;
                 // get all products in database
                 $records=$conn->query("SELECT * FROM products");
                 $total_products=$records->rowCount();
                  $pages =ceil( $total_products/$products_per_page);
                if(isset($_GET['page-num']))
                {
                  $page=$_GET['page-num']  -1 ;

                  $start=$page * $products_per_page;
                }
                if(!isset($_GET['page-num']))
                {
                  $page=1;

                }
                else{

                  $page=$_GET['page-num'] ;
                }
               
                 ?>
            <h2 class="col-6 tm-text-primary">
                Latest Photos
            </h2>
            <div class="col-6 d-flex justify-content-end align-items-center">
                <form action="" class="tm-text-primary">
                    Page <input type="text" value="<?=$page?>" size="1" class="tm-input-paging tm-text-primary"> of <?=$pages?>
                </form>
            </div>
        </div>


        <div class="row tm-mb-90 tm-gallery">
            <?php
             $sql = "SELECT * FROM products LIMIT $start,$products_per_page";
             $data = $conn->query($sql);
            foreach ($data as $prd) { 
                if($prd['is_active']=="Yes"){ 
                $prdID=$prd['prd_id']
                ?>

                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-5">
                    <figure class="effect-ming tm-video-item">
                       
                        <img src="./admin/img/<?= $prd['prd_image'] ?>" width="350px" height="350px" class="img-thumbnail rounded " alt="" srcset="">
                        
                        <figcaption class="d-flex align-items-center justify-content-center" >
                            <?php 
                            // inner join to show name of product category
                               $sql=" SELECT category.cat_name FROM category INNER JOIN products ON category.cat_id = products.cat_id AND products.prd_id= $prdID ";
                               $data2=$conn->query($sql);
                               foreach($data2 as $cat)

                              {
                                ?>
                            <h2><?=$cat['cat_name']?></h2>
                            <?php }?>
                            
                            <a href="photo-detail.php?prd_id=<?= $prd['prd_id'] ?>">View more</a>
                        </figcaption>
                    </figure>
                    <div class="d-flex justify-content-between tm-text-dark">
                        <span class="tm-text-gray"><?= $prd['prd_date'] ?></span>
                        <span><?= $prd['title'] ?></span> 
                    </div>
                </div>
                <?php }?>
            <?php } ?>


        </div> <!-- row -->
        <div class="row tm-mb-90">
            <div class="col-12 d-flex justify-content-between align-items-center tm-paging-col">
            <?php if(isset($_GET['page-num']) && $_GET['page-num']-1)
                    {?>
                <a href="?page-num=<?=$_GET['page-num']-1?>" class="btn btn-primary tm-btn-prev mb-2 ">Previous</a>
                <?php } else {
                    ?>
                 <a class="btn btn-primary tm-btn-prev mb-2 disabled">Previous</a>

                    <?php
                   }
                   ?>
                    <div class="tm-paging d-flex">
                     <?php 
                     for($counter =1 ;$counter<=$pages ; $counter++)
                     {
                    ?>
                    <a href="?page-num=<?=$counter ?>" class="tm-paging-link"><?=$counter?></a>


                    <?php  }
                    ?>
                
                </div>

                <?php

                if(!isset($_GET['page-num'])){

                ?>
                <a href="?page-num=2" class="btn btn-primary tm-btn-next">Next Page</a>
                <?php }
                else{
                     if($_GET['page-num']>=$pages)
                     { ?>
                <a class="btn btn-primary tm-btn-next disabled">Next Page</a>
                          <?php
                     }
                     else{

                        ?>
                <a href="?page-num=<?=$_GET['page-num'] + 1 ?>" class="btn btn-primary tm-btn-next">Next Page</a>
                <?php

                     }
                }
                ?>
            </div>
        </div>
    </div> <!-- container-fluid, tm-container-content -->


    <footer class="tm-bg-gray pt-5 pb-3 tm-text-gray tm-footer">
        <div class="container-fluid tm-container-small">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-12 px-5 mb-5">
                    <h3 class="tm-text-primary mb-4 tm-footer-title">About Catalog-Z</h3>
                    <p>Catalog-Z is free <a rel="sponsored" href="https://v5.getbootstrap.com/">Bootstrap 5</a> Alpha 2 HTML Template for video and photo websites. You can freely use this TemplateMo layout for a front-end integration with any kind of CMS website.</p>
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