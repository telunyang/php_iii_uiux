<?php require_once 'db.inc.php' ?>
<?php session_start() ?>
<?php
//如果這個階段沒有登入帳號，或沒有購物車，就將頁面轉到商品確認頁
if( !isset($_SESSION['email']) || !isset($_SESSION['cart']) ){
    header("Location: products_confirm.php");
    exit();
}

//總額 與 優惠後總額
$total = 0;
$total_m = 0;

//計算總價
foreach($_SESSION['cart'] as $key => $obj){
    $total += $obj['prod_price'] * $obj['prod_qty'];
}

/**
 * 先讓 總額 與 優惠後總額 的值一樣, 
 * 之後看看是否使用優惠代碼，來決定實際的優惠後總額
 */
$total_m = $total;

//判斷優惠代碼是否存在，有則計算出優惠後價格
if( $_SESSION['form']['coupon_code'] != '' ){
    $sqlCoupon = "SELECT * FROM `coupon` WHERE `code` = '{$_SESSION['form']['coupon_code']}'";
    $stmt = $pdo->query($sqlCoupon);
    if($stmt->rowCount() > 0){
        //取得優惠資訊
        $obj = $stmt->fetch();

        //計算優惠後總額
        $total_m = ceil($total * $obj['percentage']);

        //將優惠券設定為已使用
        $sqlUpdate = "UPDATE `coupon` SET `isUsed` = 1 WHERE `code` = '{$_SESSION['form']['coupon_code']}'";
        $pdo->query($sqlUpdate);
    }
}

//信用卡資訊
$card_number = $_POST['card_number_1'] . $_POST['card_number_2'] . $_POST['card_number_3'] . $_POST['card_number_4'];
$card_valid_date = $_POST['card_valid_date'];
$card_ccv = $_POST['card_ccv'];
$card_holder = $_POST['card_holder'];

//建立訂單
$sql = "INSERT INTO 
        `orders`
        (`email`, `transport_area`, `transport_type`, 
         `transport_payment`, `transport_arrival_time`, `recipient_email`, 
         `recipient_name`, `recipient_phone_number`, `recipient_address`, 
         `recipient_comments`, `invoice_type`, `invoice_carrier`, 
         `invoice_carrier_number`, `coupon_code`, `card_number`, 
         `card_valid_date`, `card_ccv`, `card_holder`, 
         `total`, `total_m`) 
        VALUES 
        ('{$_SESSION['email']}', '{$_SESSION['form']['transport_area']}', '{$_SESSION['form']['transport_type']}', 
         '{$_SESSION['form']['transport_payment']}', '{$_SESSION['form']['transport_arrival_time']}', '{$_SESSION['form']['recipient_email']}', 
         '{$_SESSION['form']['recipient_name']}', '{$_SESSION['form']['recipient_phone_number']}', '{$_SESSION['form']['recipient_address']}', 
         '{$_SESSION['form']['recipient_comments']}', '{$_SESSION['form']['invoice_type']}', '{$_SESSION['form']['invoice_carrier']}', 
         '{$_SESSION['form']['invoice_carrier_number']}', '{$_SESSION['form']['coupon_code']}', '{$card_number}', 
         '{$card_valid_date}', '{$card_ccv}', '{$card_holder}', 
          {$total}, {$total_m})";
$stmt = $pdo->query($sql);

/**
 * 若訂單成立，則取得新增資料的 ID (自動編號，Auto Increment 的 ID)，
 * 透過 ID 來建立訂單資料表的訂單編號 (order_id)。
 */
if($stmt->rowCount() > 0){
    //取得新增資料時的自動編號
    $lastInsertId = $pdo->lastInsertId();

    //建立訂單編號
    $order_id = date("Ymd") . sprintf('%05d', $lastInsertId);

    //將訂單編號更新回 orders 資料表
    $sqlUpdate = "UPDATE `orders` SET `order_id` = '{$order_id}' WHERE `id` = {$lastInsertId}";
    $pdo->query($sqlUpdate);

    //處理商品明細資訊
    foreach($_SESSION['cart'] as $key => $obj){
        //計算小計
        $subtotal = $obj['prod_price'] * $obj['prod_qty'];

        //新增商品名細
        $sqlDetail = "INSERT INTO `orders_detail` (`order_id`, `prod_id`, `prod_name`, `prod_thumbnail`, `prod_price`, `prod_color`, `prod_qty`, `prod_subtotal`) 
                    VALUES ('{$order_id}', {$obj['prod_id']}, '{$obj['prod_name']}', '{$obj['prod_thumbnail']}', {$obj['prod_price']}, '{$obj['prod_color']}', {$obj['prod_qty']}, {$subtotal})";
        $pdo->query($sqlDetail);
    }

    //刪除購物車
    unset($_SESSION['cart'], $_SESSION['form']);
}
?>
<?php require_once 'tpl/head.inc.php' ?>

<div class="text-center py-5">商品確認 - 填寫資料 - 確認付款 - <strong>訂單完成</strong></div>

<?php require_once 'tpl/foot.inc.php' ?> 