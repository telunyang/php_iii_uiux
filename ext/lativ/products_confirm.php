<?php require_once 'db.inc.php' ?>
<?php session_start() ?>
<?php require_once 'tpl/head.inc.php' ?>

<div class="text-center py-5"><strong>商品確認</strong> - 填寫資料 - 確認付款 - 訂單完成</div>

<form name="myForm" method="post" action="fillout.php">
    <div class="container">
        <div class="row">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">商品說明</th>
                        <th scope="col">數量</th>
                        <th scope="col">價格</th>
                        <th scope="col">刪除</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    //購物車商品數量、小計、總計
                    $count = 0;
                    $total = 0;

                    //判斷購物車是否存在，若存在，同時確認裡頭的商品數量
                    if( isset($_SESSION['cart']) && count($_SESSION['cart']) > 0){
                        //更新商品數量
                        $count = count($_SESSION['cart']);

                        foreach($_SESSION['cart'] as $key => $obj){
                            //計算小計
                            $total += $obj['prod_price'] * $obj['prod_qty'];
                    ?>
                        <tr>
                            <td>
                                <div class="row">
                                    <div class="col-6">
                                        <img src="<?= $obj['prod_thumbnail'] ?>" class="img-thumbnail" alt="...">
                                    </div>
                                    <div class="col-6">
                                        <div class="row"><?= $obj['prod_name'] ?></div>
                                        <div class="row"><?= $obj['prod_color'] ?></div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="input-group mb-3">
                                    <!-- 將購物車中的商品索引透過 form 帶到下一頁去 -->
                                    <input type="hidden" name="index[]" value="<?= $key ?>">

                                    <button class="btn btn-outline-secondary btn_minus" 
                                            type="button" 
                                            data-index="<?= $key ?>"
                                            data-prod-price="<?= $obj['prod_price'] ?>"><i class="fas fa-minus"></i></button>
                                    <input type="text" 
                                            name="qty[]"
                                            class="form-control qty" 
                                            placeholder="" 
                                            data-index="<?= $key ?>" 
                                            data-prod-price="<?= $obj['prod_price'] ?>"
                                            value="<?= $obj['prod_qty'] ?>">
                                    <button class="btn btn-outline-secondary btn_plus" 
                                            type="button" 
                                            data-index="<?= $key ?>"
                                            data-prod-price="<?= $obj['prod_price'] ?>"><i class="fas fa-plus"></i></button>
                                </div>
                            </td>
                            <td>
                                <span data-index="<?= $key ?>"><?= $obj['prod_price'] * $obj['prod_qty'] ?></span>
                            </td>
                            <td>
                                <a href="#" class="delete" data-index="<?= $key ?>"><i class="fas fa-trash-alt"></i></a>
                            </td>
                        </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td></td>
                        <td>共 <span class="count_products"><?= $count ?></span> 件商品</td>
                        <td colspan="2">
                            <label>小計：NT. </label><span id="total"><?= $total ?></span>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- 購物車內商品數量大於 0，才會出現下一步按鈕 -->
        <?php if($count > 0) { ?>
        <div class="row mb-3">
            <div class="col-10"></div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">下一步</button>
            </div>
        </div>
        <?php } ?>

    </div>
</form>

<?php require_once 'tpl/foot.inc.php' ?> 