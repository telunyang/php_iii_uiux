<?php
/**
 * 這裡是 回應標頭 (Response Headers)
 * refresh 代表幾秒後刷新頁面，
 * url 代表要重新導向的網址。
 */
header("refresh: 3; url=./9-1.php");

echo "cookie [username] 已刪除，3 秒後回到頁面 9-1.php";

//刪除 cookie，將值留下空字串即可 (透過指定過去時間，例如 3600 秒前)
setcookie('username', '', time() - 3600, "/");