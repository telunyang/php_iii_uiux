<?php
session_start();

//預設訊息
$obj['success'] = false;
$obj['info'] = "查無購物車編號";

//若購物車當中有 GET 指定的 index，則將之刪除，並重建索引
if( isset($_GET["index"]) && isset($_SESSION['cart'][$_GET["index"]]) ){
    //刪除指定的索引位置
    unset($_SESSION['cart'][$_GET["index"]]);

    //重建索引
    $_SESSION['cart'] = array_values($_SESSION['cart']);

    $obj['success'] = true;
    $obj['info'] = "已刪除指定商品";
}

//告訴前端，回傳格式為 JSON (前端接到，會是物件型態)
header('Content-Type: application/json');

//輸出 JSON 格式，供 ajax 取得 response
echo json_encode($obj, JSON_UNESCAPED_UNICODE);