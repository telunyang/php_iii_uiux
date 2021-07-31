<?php require_once 'db.inc.php' ?>
<?php session_start() ?>
<?php require_once 'tpl/head.inc.php' ?>

<div class="container mt-5">
    <div class="row">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">訂購日期</th>
                    <th scope="col">訂單編號</th>
                    <th scope="col">付款方式</th>
                    <th scope="col">應付金額</th>
                </tr>
            </thead>
            <tbody>
            <?php
            //訂單數量
            $count_orders = 0;

            //判斷是否登入
            if( isset($_SESSION['email']) ){
                //取得所有與會員相關的訂單
                $sql = "SELECT * 
                        FROM `orders`
                        WHERE `email` = '{$_SESSION['email']}'
                        ORDER BY `created_at` DESC, `order_id` DESC ";
                $stmt = $pdo->query($sql);
                
                if($stmt->rowCount() > 0){
                    //記錄訂單數量
                    $count_orders = $stmt->rowCount();

                    //取得訂單資料
                    foreach($stmt->fetchAll() as $obj) {
            ?>
                <tr>
                    <td><?= $obj['created_at'] ?></td>
                    <td><a href="orders_detail.php?order_id=<?= $obj['order_id'] ?>"><?= $obj['order_id'] ?></a></td>
                    <td><?= $obj['transport_payment'] ?></td>
                    <td><?= $obj['total'] ?></td>
                </tr>
            <?php
                    }
                }
            }
            ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="text-end">共 <?= $count_orders ?> 筆訂單</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>


<?php require_once 'tpl/foot.inc.php' ?> 