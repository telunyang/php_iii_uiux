<?php
/**
 * 這裡是 回應標頭 (Response Headers)
 * refresh 代表幾秒後刷新頁面，
 * url 代表要重新導向的網址。
 */
header("refresh: 3; url=./9-1.php");

echo "cookie [username] 已設定，3 秒後回到頁面 9-1.php";

// 86400 = 1 天， 86400 * 15 = 15 天
setcookie("username", "darren", time() + (86400 * 15), "/"); 