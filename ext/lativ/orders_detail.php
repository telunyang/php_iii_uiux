<?php require_once 'db.inc.php' ?>
<?php session_start() ?>
<?php require_once 'tpl/head.inc.php' ?>

<div class="container mt-5">
    <div class="row">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">商品名稱</th>
                    <th scope="col">數量</th>
                    <th scope="col">單價</th>
                    <th scope="col">小計</th>
                </tr>
            </thead>
            <tbody>
            <?php
            //總額 與 優惠後總額
            $total = 0;
            $total_m = 0;

            //確認 GET 變數 order_id 是否存在
            if(isset($_GET['order_id'])) {
                //取得訂單資訊
                $sqlOrder = "SELECT * FROM `orders` WHERE `order_id` = '{$_GET['order_id']}'";
                $stmt = $pdo->query($sqlOrder);
                if($stmt->rowCount() > 0){
                    $objOrder = $stmt->fetch();

                    //取得優惠後總額
                    $total_m = $objOrder['total_m'];
                }

                //取得訂單明細
                $sql = "SELECT * FROM `orders_detail` WHERE `order_id` = '{$_GET['order_id']}'";
                $arr = $pdo->query($sql)->fetchAll();
                foreach($arr as $obj){
                    $total += $obj['prod_price'] * $obj['prod_qty'];
            ?>
                <tr>
                    <td>
                        <div class="row">
                            <div class="col-3">
                                <img src="<?= $obj['prod_thumbnail'] ?>" class="img-thumbnail w-50" alt="...">
                            </div>
                            <div class="col-9">
                                <div class="row"><?= $obj['prod_name'] ?></div>
                                <div class="row"><?= $obj['prod_color'] ?></div>
                            </div>
                        </div>
                    </td>
                    <td><?= $obj['prod_qty'] ?></td>
                    <td><?= $obj['prod_price'] ?></td>
                    <td><?= $obj['prod_price'] * $obj['prod_qty'] ?></td>
                </tr>
            <?php
                }
            }
            ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-end">商品金額總計</td>
                    <td class="text-end">NT$ <?= number_format($total) ?></td>
                </tr>
                <tr>
                    <td colspan="3" class="text-end">優惠後金額總計</td>
                    <td class="text-end text-danger">NT$ <?= number_format($total_m) ?></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="row border-3 border-bottom mt-5">
        <div class="col-6 justify-content-start"><p class="fs-5 fw-bold">付款方式與寄送資料</p></div>
    </div>
    <?php
    //確認 $objOrder 變數是否存在，存在則顯示訂單相關資訊
    if( isset($objOrder) ) {
    ?>
        <div class="row border-bottom py-1">
            <div class="col-3">付款方式</div>
            <div class="col-9"><?= $objOrder['transport_payment'] ?></div>
        </div>
        <div class="row border-bottom py-1">
            <div class="col-3">收件者姓名</div>
            <div class="col-9"><?= $objOrder['recipient_name'] ?></div>
        </div>
        <div class="row border-bottom py-1">
            <div class="col-3">收件者地址</div>
            <div class="col-9"><?= $objOrder['recipient_address'] ?></div>
        </div>
        <div class="row border-bottom py-1 mb-5">
            <div class="col-3">發票類型</div>
            <div class="col-9"><?= $objOrder['invoice_type'] ?></div>
        </div>
    <?php
    }
    ?>
</div>


<?php require_once 'tpl/foot.inc.php' ?> 