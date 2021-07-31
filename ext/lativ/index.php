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
<?php require_once 'tpl/head.inc.php' ?>

<div class="row">
    <!-- 放次要類別的區塊 -->
    <?php require_once 'tpl/sidebar.php' ?>
    
    <!-- 放商品一覽和分頁連結的區塊 -->
    <div class="col-10">
        <!-- 商品一覽 -->
        <div class="row">
            <?php if(isset($_GET['sub_cat_id'])) { ?>
            <div class="row row-cols-1 row-cols-lg-4 align-items-stretch g-4 py-2">
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
                        <a href="detail.php?cat_id=<?= $_GET['cat_id'] ?>&sub_cat_id=<?= $_GET['sub_cat_id'] ?>&prod_id=<?= $obj['id'] ?>">
                            <img src="<?= $obj['prod_thumbnail'] ?>" class="card-img-top" alt="...">
                        </a>
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

<?php require_once 'tpl/foot.inc.php' ?> 