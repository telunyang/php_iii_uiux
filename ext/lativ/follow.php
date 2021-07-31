<?php require_once 'db.inc.php' ?>
<?php session_start() ?>
<?php require_once 'tpl/head.inc.php' ?>

<div class="container mt-5">
    <div class="row">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">商品名稱</th>
                    <th scope="col">圖片</th>
                    <th scope="col">單價</th>
                    <th scope="col">功能</th>
                </tr>
            </thead>
            <tbody>
            <?php 
            //確認是否登入
            if(isset($_SESSION['email'])){
                //商品追蹤與商品資料表進行 join
                $sql = "SELECT `pf`.`prod_id`, `p`.`id`, `p`.`prod_name`, `p`.`prod_thumbnail`, `p`.`prod_price`
                        FROM `products_follow` AS `pf`
                        INNER JOIN `products` AS `p`
                        ON `pf`.`prod_id` = `p`.`id` 
                        WHERE `pf`.`email` = '{$_SESSION['email']}'";
                $stmt = $pdo->query($sql);
                if($stmt->rowCount() > 0){
                    foreach($stmt->fetchAll() as $index => $obj){
            ?>
                <tr>
                    <td><?= ($index + 1) ?></td>
                    <td><?= $obj['prod_name'] ?></td>
                    <td><img src="<?= $obj['prod_thumbnail'] ?>" class="img-thumbnail"></td>
                    <td><?= $obj['prod_price'] ?></td>
                    <td><a href="detail.php?prod_id=<?= $obj['prod_id'] ?>">進入購買</a></td>
                </tr>

            <?php 
                    }
                }
            }
            ?>
            </tbody>
        </table>
    </div>
 </div>

<?php require_once 'tpl/foot.inc.php' ?> 