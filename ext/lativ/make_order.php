<?php require_once 'db.inc.php' ?>
<?php session_start() ?>
<?php
//如果這個階段沒有購物車，就將頁面轉到商品確認頁
if( !isset($_SESSION['cart']) ){
    header("Location: products_confirm.php");
    exit();
}

//計算總價
$total = 0;
foreach($_SESSION['cart'] as $key => $obj){
    $total += $obj['prod_price'] * $obj['prod_qty'];
}

//信用卡資訊
$card_number = $_POST['card_number_1'] . $_POST['card_number_2'] . $_POST['card_number_3'] . $_POST['card_number_4'];
$card_valid_date = $_POST['card_valid_date'];
$card_ccv = $_POST['card_ccv'];
$card_holder = $_POST['card_holder'];

//建立訂單
$sql = "INSERT INTO 
        `orders`
        (`email`, `transport_area`, `transport_type`, `transport_payment`, `transport_arrival_time`, 
         `recipient_email`, `recipient_name`, `recipient_phone_number`, `recipient_address`, `recipient_comments`, 
         `invoice_type`, `invoice_carrier`, `invoice_carrier_number`, `coupon_code`, `card_number`, 
         `card_valid_date`, `card_ccv`, `card_holder`, `total`) 
        VALUES 
        ('{$_SESSION['email']}', '{$_SESSION['transport_area']}', '{$_SESSION['transport_type']}', '{$_SESSION['transport_payment']}', '{$_SESSION['transport_arrival_time']}',
         '{$_SESSION['recipient_email']}', '{$_SESSION['recipient_name']}', '{$_SESSION['recipient_phone_number']}', '{$_SESSION['recipient_address']}', '{$_SESSION['recipient_comments']}', 
         '{$_SESSION['invoice_type']}', '{$_SESSION['invoice_carrier']}', '{$_SESSION['invoice_carrier_number']}', '{$_SESSION['coupon_code']}', '{$card_number}', 
         '{$card_valid_date}', '{$card_ccv}', '{$card_holder}', '{$total}')";
$stmt = $pdo->query($sql);

/**
 * 若訂單成立，則取得新增資料的自動編號，
 * 建立訂單編號後，透過剛才新增的自動編號，
 * 來更新訂單資料表的訂單編號。
 */
if($stmt->rowCount() > 0){
    //取得新增資料時的自動編號
    $lastInsertId = $pdo->lastInsertId();

    //建立訂單編號
    $sqlCount = "SELECT COUNT(1) as `sn` FROM `orders`";
    $sn = $pdo->query($sqlCount)->fetch()['sn'];
    $order_id = date("Ymd") . sprintf('%05d', $sn);

    //將訂單編號更新回 orders 資料表
    $sqlUpdate = "UPDATE `orders` SET `order_id` = '{$order_id}' WHERE `id` = {$lastInsertId}";
    $pdo->query($sqlUpdate);

    //處理商品明細資訊
    foreach($_SESSION['cart'] as $key => $obj){
        //計算小計
        $subtotal = $obj['prod_price'] * $obj['prod_qty'];

        //新增商品名細
        $sqlDetail = "INSERT INTO `orders_detail` (`order_id`, `prod_id`, `prod_name`, `prod_price`, `prod_color`, `prod_qty`, `prod_subtotal`) 
                    VALUES ('{$order_id}', {$obj['prod_id']}, '{$obj['prod_name']}', {$obj['prod_price']}, '{$obj['prod_color']}', {$obj['prod_qty']}, {$subtotal})";
        $pdo->query($sqlDetail);
    }

    //刪除購物車
    unset($_SESSION['cart']);
}
?>
<?php require_once 'tpl/head.inc.php' ?>

<div class="text-center py-5">商品確認 - 填寫資料 - 確認付款 - <strong>訂單完成</strong></div>

<?php require_once 'tpl/foot.inc.php' ?> 