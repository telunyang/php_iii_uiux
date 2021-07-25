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
                            <a class="btn btn-warning" href="register.php">Sign-up</a>
                        </div>

                        <div class="text-end">
                            
                        </div>
                    </div>
                </div>
            </header>
        </div>

        <!-- 註冊欄位 -->
        <div class="row">
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

    


 


    

    <!-- jQuery CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- jQuery UI -->
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- awesome js -->
    <script src="js/awesome.all.min.js"></script>

    <!-- 自訂 js -->
    <script src="js/custom.js"></script>
</body>
</html>