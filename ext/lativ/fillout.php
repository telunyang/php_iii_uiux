<?php require_once 'db.inc.php' ?>
<?php session_start() ?>
<?php
//如果這個階段沒有購物車，就將頁面轉到商品確認頁
if( !isset($_SESSION['cart']) ){
    header("Location: products_confirm.php");
    exit();
}

//如果購物車與商品索引與數量同時存在，則修改指定索引的商品數量
if( isset($_POST['index']) && isset($_POST['qty']) ){
    foreach($_POST['index'] as $index => $value){
        $_SESSION['cart'][$index]['prod_qty'] = $_POST['qty'][$index];
    }
}
?>
<?php require_once 'tpl/head.inc.php' ?>

<div class="text-center py-5">商品確認 - <strong>填寫資料</strong> - 確認付款 - 訂單完成</div>

<form name="myForm" method="post" action="payment.php">
    <div class="container">
        <div class="row">
            <!-- 運送資訊、收件資訊、發票明細、優惠選擇 -->
            <div class="col-6 px-5">
                <!-- 運送資訊 -->
                <div class="row border-3 border-bottom">
                    <div class="col-6 justify-content-start"><p class="fs-3 fw-bold">運送資訊</p></div>
                    <div class="col-6 d-flex align-items-center justify-content-end">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="transport_area" value="臺灣本島" checked>
                            <label class="form-check-label">臺灣本島</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="transport_area" value="離島/海外地區">
                            <label class="form-check-label">離島/海外地區</label>
                        </div>
                    </div>
                </div>
                <div class="row my-2">
                    <label for="colFormLabel" class="col-sm-2 col-form-label">運送方式</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="transport_type">
                            <option value="超商取貨">-- 請選擇 --</option>
                            <option value="超商取貨">超商取貨</option>
                            <option value="宅配">宅配</option>
                        </select>
                    </div>
                </div>
                <div class="row my-2">
                    <label for="colFormLabel" class="col-sm-2 col-form-label">付款方式</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="transport_payment">
                            <option value="貨到付款">-- 請選擇 --</option>
                            <option value="貨到付款">貨到付款</option>
                            <option value="信用卡">信用卡</option>
                        </select>
                    </div>
                </div>
                <div class="row my-2">
                    <label for="colFormLabel" class="col-sm-2 col-form-label">送達時間</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="transport_arrival_time">
                            <option value="09:00-12:00">-- 請選擇 --</option>
                            <option value="09:00-12:00">09:00-12:00</option>
                            <option value="12:00-15:00">12:00-15:00</option>
                            <option value="15:00-18:00">15:00-18:00</option>
                            <option value="18:00-21:00">18:00-21:00</option>
                        </select>
                    </div>
                </div>

                <!-- 收件資訊 -->
                <div class="row border-3 border-bottom">
                    <div class="col-6 justify-content-start"><p class="fs-3 fw-bold">運送資訊</p></div>
                    <div class="col-6 d-flex align-items-center justify-content-end">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="member_info">
                            <label class="form-check-label">填入會員資料</label>
                        </div>
                    </div>
                </div>
                <div class="row my-2">
                    <label for="colFormLabel" class="col-sm-2 col-form-label">E-mail信箱</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" name="recipient_email">
                    </div>
                </div>
                <div class="row my-2">
                    <label for="colFormLabel" class="col-sm-2 col-form-label">收件人姓名</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="recipient_name">
                    </div>
                </div>
                <div class="row my-2">
                    <label for="colFormLabel" class="col-sm-2 col-form-label">手機號碼</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="recipient_phone_number">
                    </div>
                </div>
                <div class="row my-2">
                    <label for="colFormLabel" class="col-sm-2 col-form-label">收件地址</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="recipient_address">
                    </div>
                </div>
                <div class="row my-2">
                    <label for="colFormLabel" class="col-sm-2 col-form-label">備註</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" name="recipient_comments" rows="5"></textarea>
                    </div>
                </div>

                <!-- 發票明細 -->
                <div class="row border-3 border-bottom">
                    <div class="col-6 justify-content-start"><p class="fs-3 fw-bold">發票明細</p></div>
                    <div class="col-6 d-flex align-items-center justify-content-end">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="invoice_type" value="電子發票" checked>
                            <label class="form-check-label">電子發票</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="invoice_type" value="發票證明聯">
                            <label class="form-check-label">發票證明聯</label>
                        </div>
                    </div>
                </div>
                <div class="row my-2">
                    <div class="col-12 d-flex align-items-center justify-content-start">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="invoice_carrier" value="隨包裹" checked>
                            <label class="form-check-label">隨包裹</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="invoice_carrier" value="電子條碼載具">
                            <label class="form-check-label">電子條碼載具</label>
                        </div>
                    </div>
                </div>
                <div class="row my-2">
                    <label for="colFormLabel" class="col-sm-2 col-form-label">載具編號</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="invoice_carrier_number" placeholder="(發票隨包裹不必填寫)">
                    </div>
                </div>

                <!-- 優惠選擇 -->
                <div class="row border-3 border-bottom">
                    <div class="col-6 justify-content-start"><p class="fs-3 fw-bold">優惠選擇</p></div>
                </div>
                <div class="row my-2">
                    <label for="colFormLabel" class="col-sm-2 col-form-label">優惠代碼</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="coupon_code">
                    </div>
                    <div class="col-sm-2">
                        <a href="#" class="btn btn-link" id="check_coupon_code">確認</a>
                    </div>
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

        <div class="row mb-3">
            <div class="col-10"></div>
            <div class="col-auto">
                <a class="btn btn-outline-dark" href="products_confirm.php">回上一頁</a>
                <button type="submit" class="btn btn-primary">下一步</button>
            </div>
        </div>

    </div>
</form>

<?php require_once 'tpl/foot.inc.php' ?> 