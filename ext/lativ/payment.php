<?php require_once 'db.inc.php' ?>
<?php session_start() ?>
<?php
//如果這個階段沒有購物車，就將頁面轉到商品確認頁
if( !isset($_SESSION['cart']) ){
    header("Location: products_confirm.php");
    exit();
}

//將表單資訊寫入 session，之後建立訂單時，一起變成訂單資訊
$_SESSION['form'] = [];
$_SESSION['form']['transport_area'] = $_POST['transport_area'];
$_SESSION['form']['transport_type'] = $_POST['transport_type'];
$_SESSION['form']['transport_payment'] = $_POST['transport_payment'];
$_SESSION['form']['transport_arrival_time'] = $_POST['transport_arrival_time'];
$_SESSION['form']['recipient_email'] = $_POST['recipient_email'];
$_SESSION['form']['recipient_name'] = $_POST['recipient_name'];
$_SESSION['form']['recipient_phone_number'] = $_POST['recipient_phone_number'];
$_SESSION['form']['recipient_address'] = $_POST['recipient_address'];
$_SESSION['form']['recipient_comments'] = $_POST['recipient_comments'];
$_SESSION['form']['invoice_type'] = $_POST['invoice_type'];
$_SESSION['form']['invoice_carrier'] = $_POST['invoice_carrier'];
$_SESSION['form']['invoice_carrier_number'] = $_POST['invoice_carrier_number'];
$_SESSION['form']['coupon_code'] = $_POST['coupon_code'];
?>
<?php require_once 'tpl/head.inc.php' ?>

<div class="text-center py-5">商品確認 - 填寫資料 - <strong>確認付款</strong> - 訂單完成</div>

<form name="myForm" method="post" action="make_order.php">
    <div class="container">
        <div class="row">
            <!-- 信用卡套件 -->
            <div class="col-6 px-5">
                <div class="row border-3 border-bottom">
                    <div class="col-6 justify-content-start"><p class="fs-3 fw-bold">信用卡資訊</p></div>
                </div>
                <div class="cc">
                    <h2>擺渡人銀行</h2>
                    <span class="provider mastercard">MasterCard</span>
                    <span class="provider amex">American Express</span>
                    <span class="provider visa">Visa</span>
                    <div class="number">
                            <input type="text" class="card_border" maxlength="4" placeholder="1234" name="card_number_1">
                            <input type="text" class="card_border" maxlength="4" placeholder="1234" name="card_number_2">
                            <input type="text" class="card_border" maxlength="4" placeholder="1234" name="card_number_3">
                            <input type="text" class="card_border" maxlength="4" placeholder="1234" name="card_number_4">
                        <span class="instructions">信用卡卡號</span>
                    </div>
                    <div class="date">
                        <span class="instructions valid">到期年限</span>
                        <input type="text" class="card_border" maxlength="5" placeholder="00/00" name="card_valid_date">
                        <span class="instructions valid">CCV</span>
                        <input type="text" class="card_border" maxlength="3" placeholder="123" name="card_ccv">  
                    </div>
                    <div class="name">
                        <input class="full-name card_border" type="text" maxlength="" placeholder="擺渡人" name="card_holder">
                        <span class="instructions">持卡人姓名</span>
                    </div>
                    <div class="shine"></div>
                    <div class="shine shine-layer-two"></div>
                </div>

            </div>

            <!-- 購物明細 -->
            <div class="col-6 px-5">
                <div class="row border-3 border-bottom">
                    <div class="col-6 justify-content-start"><p class="fs-3 fw-bold">購物明細</p></div>
                </div>
                <?php
                if( isset($_SESSION['cart']) ){
                    foreach($_SESSION['cart'] as $key => $obj){
                ?>
                <div class="row border-bottom py-2">
                    <div class="col-4">
                        <img src="<?= $obj['prod_thumbnail'] ?>" class="img-thumbnail w-75" alt="...">
                    </div>
                    <div class="col-4">
                        <div class="row"><?= $obj['prod_name'] ?></div>
                        <div class="row">顏色: <?= $obj['prod_color'] ?></div>
                    </div>
                    <div class="col-4">共 <?= $obj['prod_qty'] ?> 件<br>NT$ <?= $obj['prod_price'] * $obj['prod_qty'] ?></div>
                </div>
                <?php
                    }
                }
                ?>
            </div>
        </div>

        <div class="row my-3">
            <div class="col-10"></div>
            <div class="col-auto">
                <a class="btn btn-outline-dark" href="fillout.php">回上一頁</a>
                <button type="submit" class="btn btn-primary">確認付款</button>
            </div>
        </div>
    </div>
</form>

<?php require_once 'tpl/foot.inc.php' ?> 