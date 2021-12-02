<?php
require_once 'ext/lativ/db.inc.php';
$sql = "UPDATE `users` 
        SET `isActivated` = 1 
        WHERE `verified_code` = '{$_GET['verified_code']}'";
$stmt = $pdo->query($sql);

header("refresh: 3; url = index.php");

if($stmt->rowCount() > 0){
    echo "啟用成功";
} else {
    echo "啟用失敗";
}