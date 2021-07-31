<?php require_once 'db.inc.php' ?>
<?php session_start() ?>
<?php require_once 'tpl/head.inc.php' ?>

<div class="container mt-5">
    <div class="row row-cols-1 row-cols-lg-4 align-items-stretch g-4 py-2">
    <?php
    //將搜尋關鍵字當中有空白的字元，改成百分比
    $keyword = str_replace(" ", "%", $_GET['keyword']);

    //搜尋結果
    $sql = "SELECT `id`, `prod_name`, `prod_thumbnail`, `prod_price` 
            FROM `products` 
            WHERE `prod_name` LIKE '%{$keyword}%'";
    $stmt = $pdo->query($sql);
    if( $stmt->rowCount() > 0 ){
        foreach($stmt->fetchAll() as $obj){
    ?>
        <div class="col">
            <div class="card" style="width: 18rem;">
                <a href="detail.php?prod_id=<?= $obj['id'] ?>">
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

<?php require_once 'tpl/foot.inc.php' ?> 