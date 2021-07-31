<?php require_once 'db.inc.php' ?>
<?php session_start() ?>
<?php require_once 'tpl/head.inc.php' ?>

<div class="row">
    <!-- 放次要類別的區塊 -->
    <?php require_once 'tpl/sidebar.php' ?>

    <!-- 放商品詳細資訊的區塊 -->
    <div class="col-10">
    <?php 
    if(isset($_GET['prod_id'])) { 
        $sql = "SELECT * FROM `products` WHERE `id` = {$_GET['prod_id']}";
        $obj = $pdo->query($sql)->fetch();
    ?>
        <div class="row">

            <div class="col-5 pt-3">

                <div class="text-center">
                    <img src="<?= $obj['prod_image'] ?>" class="rounded" alt="<?= $obj['prod_name'] ?>" title="<?= $obj['prod_name'] ?>">
                    <button id="zoom"><i class="fas fa-search-plus"></i></button>
                </div>

                <div class="text-center">
                <?php
                $sql = "SELECT * FROM `products_img` WHERE `func` = 'zoom' AND `prod_id` = {$_GET['prod_id']}";
                $arr = $pdo->query($sql)->fetchAll();
                foreach($arr as $objImg){
                ?>
                    <a data-lightbox="roadtrip" href="<?= $objImg['filename'] ?>" style="display: none;">
                    <img src="<?= $objImg['filename'] ?>" class="img-thumbnail figure-img img-fluid rounded float-start m-1" style="width: 100px;" alt="...">
                    </a>
                <?php
                }
                ?>
                </div>
            </div>

            <div class="col-7">
                
                <div class="row p-3 border-bottom">
                    <div class="col-6"><h4><?= $obj['prod_name'] ?></h4></div>
                    <div class="col-6"><p class="fs-1">NT: <?= $obj['prod_price'] ?></p></div>
                </div>

                <div class="row p-3 border-bottom">
                    <label>顏色</label>
                    <select class="form-select" id="prod_color">
                    <?php
                        $sql = "SELECT * FROM `products_colors` WHERE `prod_id` = {$_GET['prod_id']}";
                        $arr = $pdo->query($sql)->fetchAll();
                        foreach($arr as $objColor){
                    ?>
                        <option value="<?= $objColor['color_name'] ?>"><?= $objColor['color_name'] ?></option>
                    <?php
                        }
                    ?>
                    </select>
                </div>

                <div class="row p-3 border-bottom">
                    <div class="col-6">
                        <div class="input-group mb-3">
                            <button class="btn btn-outline-secondary" type="button" id="btn_minus"><i class="fas fa-minus"></i></button>
                            <input type="text" class="form-control" placeholder="" id="qty" value="1">
                            <button class="btn btn-outline-secondary" type="button" id="btn_plus"><i class="fas fa-plus"></i></button>
                        </div>
                    </div>
                    <div class="col-6">
                        <button type="button" 
                                class="btn btn-dark" 
                                id="btn_set_cart" 
                                data-prod-id="<?= $obj['id'] ?>"
                                data-prod-name="<?= $obj['prod_name'] ?>"
                                data-prod-thumbnail="<?= $obj['prod_thumbnail'] ?>"
                                data-prod-price="<?= $obj['prod_price'] ?>">加入購物車</button>
                        <button 
                                type="button" 
                                class="btn btn-secondary"
                                id="btn_follow" 
                                data-prod-id="<?= $obj['id'] ?>">追蹤商品</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- 如果還有商品其它描述或展示資訊，可以放在這裡 -->
        </div>
    <?php 
    } 
    ?> 
    </div>
</div>

<?php require_once 'tpl/foot.inc.php' ?> 