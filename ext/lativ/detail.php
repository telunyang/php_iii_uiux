<?php require_once 'db.inc.php' ?>
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

                        <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3">
                            <input type="search" class="form-control form-control-dark" placeholder="Search..." aria-label="Search">
                        </form>

                        <div class="text-end">
                            <a class="btn btn-outline-light me-2" href="#">Login</a>
                            <a class="btn btn-warning" hhref="register.php" data-bs-toggle="modal" data-bs-target="#exampleModal">Sign-up</a>
                        </div>

                        <div class="text-end">
                            
                        </div>
                    </div>
                </div>
            </header>
        </div>

        <div class="row">
            <!-- 放次要類別的區塊 -->
            <div class="col-2">
            <?php if(isset($_GET['cat_id'])) { ?>
                <ul class="nav flex-column">
                    <?php
                        $sql = "SELECT `id`, `cat_name` FROM `categories` WHERE `parent_id` = {$_GET['cat_id']}";
                        $arr1 = $pdo->query($sql)->fetchAll();
                        foreach($arr1 as $obj1){
                    ?>
                    <li class="nav-item">
                        <?= $obj1['cat_name'] ?>
                        <ul class="nav flex-column">
                        <?php
                            $sql = "SELECT `id`, `cat_name` FROM `categories` WHERE `parent_id` = {$obj1['id']}";
                            $arr2 = $pdo->query($sql)->fetchAll();
                            foreach($arr2 as $obj2){
                        ?>
                            <a class="nav-link" href="index.php?cat_id=<?= $_GET['cat_id'] ?>&sub_cat_id=<?= $obj2['id'] ?>"><?= $obj2['cat_name'] ?></a>
                        <?php 
                            }
                        ?>
                        </ul>
                    </li>
                    <?php 
                        }
                    ?>
                </ul>
            <?php } ?>
            </div>

            <!-- 放商品詳細資訊的區塊 -->
            <div class="col-10">
            <?php 
            if(isset($_GET['prod_id'])) { 
                $sql = "SELECT * FROM `products` WHERE `id` = {$_GET['prod_id']}";
                $obj = $pdo->query($sql)->fetch();
            ?>
                <div class="row">

                    <div class="col-5 pt-3">

                        <div class="text-center">
                            <img src="<?= $obj['prod_image'] ?>" class="rounded" alt="<?= $obj['prod_name'] ?>" title="<?= $obj['prod_name'] ?>">
                            <button id="zoom"><i class="fas fa-search-plus"></i></button>
                        </div>

                        <div class="text-center">
                        <?php
                        $sql = "SELECT * FROM `products_img` WHERE `func` = 'zoom' AND `prod_id` = {$_GET['prod_id']}";
                        $arr = $pdo->query($sql)->fetchAll();
                        foreach($arr as $objImg){
                        ?>
                            <a data-lightbox="roadtrip" href="<?= $objImg['filename'] ?>" style="display: none;">
                            <img src="<?= $objImg['filename'] ?>" class="img-thumbnail figure-img img-fluid rounded float-start m-1" style="width: 100px;" alt="...">
                            </a>
                        <?php
                        }
                        ?>
                        </div>
                    </div>

                    <div class="col-7">

                        <div class="row p-3 border-bottom">
                            <div class="col-6"><h4><?= $obj['prod_name'] ?></h4></div>
                            <div class="col-6"><p class="fs-1">NT: <?= $obj['prod_price'] ?></p></div>
                        </div>

                        <div class="row p-3 border-bottom">
                            <label>顏色</label>
                            <select class="form-select">
                            <?php
                                $sql = "SELECT * FROM `products_colors` WHERE `prod_id` = {$_GET['prod_id']}";
                                $arr = $pdo->query($sql)->fetchAll();
                                foreach($arr as $objColor){
                            ?>
                                <option value="<?= $objColor['color_name'] ?>"><?= $objColor['color_name'] ?></option>
                            <?php
                                }
                            ?>
                            </select>
                        </div>

                        <div class="row p-3 border-bottom">
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <button class="btn btn-outline-secondary" type="button" id="btn_minus"><i class="fas fa-minus"></i></button>
                                    <input type="text" class="form-control" placeholder="" id="qty" value="1">
                                    <button class="btn btn-outline-secondary" type="button" id="btn_plus"><i class="fas fa-plus"></i></button>
                                </div>
                            </div>
                            <div class="col-6 border-bottom">
                                <button type="button" class="btn btn-dark">加入購物車</button>
                                <button type="button" class="btn btn-secondary">追蹤商品</button>
                            </div>
                        </div>

                    </div>

                </div>
            <?php 
            } 
            ?> 
            </div>
        </div>

    </div>

    <!-- 浮動視窗 -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">註冊帳號</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="row g-3" id="myForm">
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" placeholder="請填寫 E-mail">
                        </div>
                        <div class="col-md-6">
                            <label for="inputPassword4" class="form-label">密碼</label>
                            <input type="password" class="form-control" id="password" placeholder="請輸入密碼">
                        </div>
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">姓名</label>
                            <input type="text" class="form-control" id="name" placeholder="請輸入姓名">
                        </div>
                        <div class="col-md-6">
                            <label for="inputPassword4" class="form-label">生日</label>
                            <input type="text" class="form-control" id="birthdate" placeholder="請填寫生日">
                        </div>
                        <div class="col-12">
                            <label for="inputAddress" class="form-label">地址</label>
                            <input type="text" class="form-control" id="address" placeholder="請填寫地址">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary" id="btn_register">註冊</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    

    <!-- jQuery CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- awesome js -->
    <script src="js/awesome.all.min.js"></script>

    <!-- lightbox: https://lokeshdhakar.com/projects/lightbox2/ -->
    <script src="js/lightbox.min.js"></script>

    <!-- 自訂 js -->
    <script src="js/custom.js"></script>
    
</body>
</html>