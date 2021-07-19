<?php
//資料庫主機設定
const DRIVER_NAME = "mysql"; //使用哪一家資料庫
const DB_HOST = "localhost"; //資料庫網路位址 (127.0.0.1)
const DB_PORT = "3306";
const DB_USERNAME = "root"; //資料庫連線帳號
const DB_PASSWORD = ""; //資料庫連線密碼
const DB_NAME = "shopping_cart"; //指定資料庫
const DB_CHARSET = "utf8mb4"; //指定字元集，亦即是文字的編碼來源
const DB_COLLATE = "utf8mb4_unicode_ci"; //在字元集之下的排序依據

//資料庫連線變數
$pdo = null;

//錯誤處理
try {
    //設定 PDO 屬性 (Array 型態)
    $options = [
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES ' . DB_CHARSET . ' COLLATE ' . DB_COLLATE
    ];

    //PDO 連線
    $pdo = new PDO(
        DRIVER_NAME. ':host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME . ';charset=' .DB_CHARSET, 
        DB_USERNAME, 
        DB_PASSWORD, 
        $options
    );
} catch (PDOException $e) {
    echo "資料庫連結失敗，訊息: " . $e->getMessage();
    exit();
}

//讀取 JSON
$filename = __DIR__ . "/lativ.json";
$fp = fopen($filename, "r");
$strJson = fread($fp, filesize($filename));
fclose($fp);

//將 JSON 轉換成 Object
$arrObj = json_decode($strJson, true);

foreach($arrObj as $o){
    $pdo->query("INSERT INTO `categories` (`cat_name`) VALUES ('{$o['main_text']}')");
    $id_lv1 = $pdo->lastInsertId();
    foreach($o['sub'] as $oo){
        $pdo->query("INSERT INTO `categories` (`cat_name`, `parent_id`) VALUES ('{$oo['cat_text']}', {$id_lv1})");
        $id_lv2 = $pdo->lastInsertId();
        foreach($oo['cat_links'] as $ooo){
            $pdo->query("INSERT INTO `categories` (`cat_name`, `parent_id`) VALUES ('{$ooo['text']}', {$id_lv2})");
            $id_lv3 = $pdo->lastInsertId();
            foreach($ooo['content'] as $oooo){
                $pdo->query("INSERT INTO `categories` (`cat_name`, `parent_id`) VALUES ('{$oooo['sub_cat_text']}', {$id_lv3})");
                $id_lv4 = $pdo->lastInsertId();
                foreach($oooo['sub_cat_links'] as $ooooo){
                    if(isset($ooooo['detail'])) {
                        try{
                            $pdo->query(
                                "INSERT INTO `products` 
                                (`prod_name`, `prod_thumbnail`, `prod_image`, `prod_price`, `prod_description`, `cat_id`, `cat_id_set`) 
                                VALUES 
                                (
                                    '{$ooooo['text']}', 
                                    '{$ooooo['thumbnail']}', 
                                    '{$ooooo['detail']['img_init']}', 
                                    {$ooooo['detail']['price']}, 
                                    NULL, 
                                    {$id_lv3}, 
                                    '".$id_lv1.",".$id_lv2.",".$id_lv3.",".$id_lv4."'
                                )"
                            );
                            $prod_id = $pdo->lastInsertId();
                            foreach($ooooo['detail']['img_color'] as $strColor){
                                $pdo->query("INSERT INTO `products_colors` (`color_name`, `prod_id`) VALUES ('{$strColor}', {$prod_id})");
                            }
                            foreach($ooooo['detail']['img_zoom'] as $strImgZoomFileName){
                                $pdo->query("INSERT INTO `products_img` (`func`, `filename`, `prod_id`) VALUES ('zoom', '{$strImgZoomFileName}', {$prod_id})");
                            }
                            foreach($ooooo['detail']['img_other'] as $strImgOtherFileName){
                                $pdo->query("INSERT INTO `products_img` (`func`, `filename`, `prod_id`) VALUES ('other', '{$strImgOtherFileName}', {$prod_id})");
                            }
                        } catch (PDOException $e){
                            print_r($pdo->errorInfo());
                        }
                    }
                }
            }
        }
    }
}



