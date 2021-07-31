<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- jQuery UI -->
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- awesome css -->
    <link href="css/awesome.all.min.css" rel="stylesheet">

    <!-- lightbox: https://lokeshdhakar.com/projects/lightbox2/ -->
    <link href="css/lightbox.min.css" rel="stylesheet">

    <!-- 信用卡套件 -->
    <link rel="stylesheet" href="css/card.css" type="text/css">
</head>
<body>
    <div class="container-fluid">
        <!-- 放主要類別的區塊 -->
        <div class="row">
            <header class="p-3 bg-dark text-white">
                <div class="container">
                    <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                        <a href="index.php" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                            <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use></svg>
                        </a>

                        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                            <?php
                                $sql = "SELECT `id`, `cat_name` FROM `categories` WHERE `parent_id` = 0";
                                $arr = $pdo->query($sql)->fetchAll();
                                foreach($arr as $obj){
                            ?>
                                <li><a href="index.php?cat_id=<?= $obj['id'] ?>" class="nav-link px-2 text-white"><?= $obj['cat_name'] ?></a></li>
                            <?php
                                }
                            ?>
                        </ul>

                        <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" method="get" action="search.php">
                            <input type="search" class="form-control form-control-dark" placeholder="Search..." aria-label="Search" name="keyword">
                        </form>

                        <div class="text-end">
                            <a class="btn btn-outline-light me-2" href="#"  data-bs-toggle="modal" data-bs-target="#exampleModalLogin">Login</a>
                            <a class="btn btn-warning" href="register.php" data-bs-toggle="modal" data-bs-target="#exampleModal">Sign-up</a>
                        </div>

                        <div class="ml-5">
                            <?php if(isset($_SESSION['name'])){ ?>
                                <?= $_SESSION['name'] ?> | <a href="#" id="logout">登出</a>
                            <?php } ?>
                            |
                            <a href="products_confirm.php">
                                <span id="count_products">
                                    <?php 
                                    if(isset($_SESSION['cart'])) 
                                        echo count($_SESSION['cart']); 
                                    else 
                                        echo '0'; 
                                    ?>
                                </span> 個商品
                            </a>
                            | <a href="orders.php">訂單查詢</a> | <a href="follow.php">商品追蹤</a>
                        </div>
                    </div>
                </div>
            </header>
        </div>