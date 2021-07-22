<?php
require_once 'db.inc.php';

//第一種: 格式一
$cat_id = 3;
$sql = "SELECT * FROM `products` WHERE `cat_id` = {$cat_id} ";
$stmt = $pdo->query($sql);
if($stmt->rowCount() > 0){
    $arr = $stmt->fetchAll();
    foreach($arr as $obj){
        echo "商品編號: {$obj['id']}<br>";
        echo "商品名稱: {$obj['prod_name']}<br>";
        echo "商品縮圖: <a href='{$obj['prod_thumbnail']}' target='_blank'>按我看圖</a><br>";
        echo "商品價格: {$obj['prod_price']}<br>";
        echo "=============================<br>";
    }
}

//第一種: 格式二
$cat_id = 3;
$sql = "SELECT * FROM `products` WHERE `cat_id` = {$cat_id} ";
$arr = $pdo->query($sql)->fetchAll();
if( count($arr) > 0 ){
    foreach($arr as $obj){
        echo "商品編號: {$obj['id']}<br>";
        echo "商品名稱: {$obj['prod_name']}<br>";
        echo "商品縮圖: <a href='{$obj['prod_thumbnail']}' target='_blank'>按我看圖</a><br>";
        echo "商品價格: {$obj['prod_price']}<br>";
        echo "=============================<br>";
    }
}

//第二種
$sql = "SELECT * FROM `products` WHERE `cat_id` = ? ";
$stmt = $pdo->prepare($sql);
$stmt->execute([3]);
if($stmt->rowCount() > 0){
    $arr = $stmt->fetchAll();
    foreach($arr as $obj){
        echo "商品編號: {$obj['id']}<br>";
        echo "商品名稱: {$obj['prod_name']}<br>";
        echo "商品縮圖: <a href='{$obj['prod_thumbnail']}' target='_blank'>按我看圖</a><br>";
        echo "商品價格: {$obj['prod_price']}<br>";
        echo "=============================<br>";
    }
}