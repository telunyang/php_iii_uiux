<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<a href="./9-1-1.php">建立 cookie</a>
<hr>
<a href="./9-1-2.php">刪除 cookie</a>
<hr>

<?php
//如果 cookie 當中的 key 不存在，則顯示尚未設定
if(!isset($_COOKIE['username'])) {
    echo "Cookie [username] 尚未設定…";
} else { //若是設定，則顯示 cookie 內容
    echo "Cookie [username] 已經設定，它的值是: {$_COOKIE['username']}";
}
?>
</body>
</html>