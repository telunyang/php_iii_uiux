<?php require_once 'db.inc.php' ?>
<?php session_start() ?>
<?php
//整合特定商品類別分頁的 SQL 字串
$where = "";
if( isset($_GET['sub_cat_id']) ){
    $where = "WHERE `cat_id` = {$_GET['sub_cat_id']}";
}

//取得 products 資料表總筆數
$sqlTotal = "SELECT count(1) AS `count` FROM `products` {$where}";
$totalRows = $pdo->query($sqlTotal)->fetch()['count'];

//每頁幾筆
$numPerPage = 12;

// 總頁數，ceil()為無條件進位
$totalPages = ceil($totalRows/$numPerPage); 

//目前第幾頁
$page = (isset($_GET['page']) && $_GET['page'] > 0) ? (int)$_GET['page'] : 1;

//計算分頁偏移量
$offset = ($page - 1) * $numPerPage;
?>
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
                            <a class="btn btn-outline-light me-2" href="#"  data-bs-toggle="modal" data-bs-target="#exampleModalLogin">Login</a>
                            <a class="btn btn-warning" href="register.php" data-bs-toggle="modal" data-bs-target="#exampleModal">Sign-up</a>
                        </div>

                        <div class="text-end">
                        <?php if(isset($_SESSION['name'])){ ?>
                            <?= $_SESSION['name'] ?> | <a href="#" id="logout" class="btn btn-link">登出</a>
                        <?php } ?>
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
            
            <!-- 放商品一覽和分頁連結的區塊 -->
            <div class="col-10">
                <!-- 商品一覽 -->
                <div class="row">
                    <?php if(isset($_GET['sub_cat_id'])) { ?>
                    <div class="row row-cols-1 row-cols-lg-3 align-items-stretch g-4 py-5">
                    <?php
                        $sql = "SELECT `id`, `prod_name`, `prod_thumbnail`, `prod_price` 
                                FROM `products` 
                                WHERE `cat_id` = {$_GET['sub_cat_id']} 
                                LIMIT {$offset}, {$numPerPage}";
                        $arr = $pdo->query($sql)->fetchAll();
                        foreach($arr as $obj){
                    ?>
                        <div class="col">
                            <div class="card" style="width: 18rem;">
                                <a href="detail.php?cat_id=<?= $_GET['cat_id'] ?>&sub_cat_id=<?= $_GET['sub_cat_id'] ?>&prod_id=<?= $obj['id'] ?>"><img src="<?= $obj['prod_thumbnail'] ?>" class="card-img-top" alt="..."></a>
                                <div class="card-body">
                                    <h5 class="card-title"><?= $obj['prod_name'] ?></h5>
                                    <p class="card-text">價格: <?= $obj['prod_price'] ?></p>
                                    <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
                                </div>
                            </div>
                        </div>
                    <?php
                        }
                    }
                    ?>
                    </div>
                </div>

                <!-- 分頁 -->
                <?php if( isset($_GET['cat_id']) && isset($_GET['sub_cat_id']) ){ ?>
                <div class="row">
                    
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <!-- 第一頁 -->
                            <li class="page-item <?php if($page == 1) echo 'disabled'; ?>">
                                <a class="page-link" href="index.php?cat_id=<?= $_GET['cat_id'] ?>&sub_cat_id=<?= $_GET['sub_cat_id'] ?>&page=1" tabindex="-1" aria-disabled="true">
                                    <i class="fas fa-backward"></i>
                                </a>
                            </li>

                            <!-- 上一頁 -->
                            <li class="page-item <?php if($page == 1) echo 'disabled'; ?>">
                                <a class="page-link" href="index.php?cat_id=<?= $_GET['cat_id'] ?>&sub_cat_id=<?= $_GET['sub_cat_id'] ?>&page=<?= ($page - 1) ?>" tabindex="-1" aria-disabled="true">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            </li>

                            <?php
                            //列出所有分頁連結
                            for($i = 1; $i <= $totalPages; $i++){ 

                                //當「目前第幾頁」($page)等於準備顯示在網頁上的分頁號碼($i)，以加上 class
                                $strClass = '';
                                if($page === $i) $strClass = 'active';

                                //$i 列出的數字範圍，會大於「目前第幾頁」($page) 減 5，以及小於「目前第幾頁」($page) 加 5
                                if ( $i > $page - 5 && $i < $page + 5 ) {
                            ?>
                                <li class="page-item <?= $strClass; ?>">
                                    <a class="page-link" href="index.php?cat_id=<?= $_GET['cat_id'] ?>&sub_cat_id=<?= $_GET['sub_cat_id'] ?>&page=<?= $i ?>">
                                        <?= $i ?>
                                    </a>
                                </li>
                            <?php
                                } 
                            } 
                            ?>

                            <!-- 下一頁 -->
                            <li class="page-item <?php if($page == $totalPages) echo 'disabled'; ?>">
                                <a class="page-link" href="index.php?cat_id=<?= $_GET['cat_id'] ?>&sub_cat_id=<?= $_GET['sub_cat_id'] ?>&page=<?= ($page + 1) ?>" tabindex="-1" aria-disabled="true">
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            </li>

                            <!-- 最後一頁 -->
                            <li class="page-item <?php if($page == $totalPages) echo 'disabled'; ?>">
                                <a class="page-link" href="index.php?cat_id=<?= $_GET['cat_id'] ?>&sub_cat_id=<?= $_GET['sub_cat_id'] ?>&page=<?= $totalPages ?>" tabindex="-1" aria-disabled="true">
                                    <i class="fas fa-forward"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>
                    
                </div>
                <?php } ?>

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
                            <input type="password" class="form-control" id="pwd" placeholder="請輸入密碼">
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

    <!-- 登入視窗 -->
    <div class="modal fade" id="exampleModalLogin" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">登入</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="row g-3" id="myForm_login">
                        <div class="col-md-12">
                            <label for="inputEmail4" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email_login" placeholder="請填寫 E-mail">
                        </div>
                        <div class="col-md-12">
                            <label for="inputPassword4" class="form-label">密碼</label>
                            <input type="password" class="form-control" id="pwd_login" placeholder="請輸入密碼">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary" id="btn_login">送出</button>
                        </div>
                    </form>
                </div>
            </div>
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

    <!-- lightbox: https://lokeshdhakar.com/projects/lightbox2/ -->
    <script src="js/lightbox.min.js"></script>

    <!-- 自訂 js -->
    <script src="js/custom.js"></script>
</body>
</html>