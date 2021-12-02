<?php
//開啟 session
session_start();

//匯入資料庫
require_once 'db.inc.php';

//預設訊息
$obj['success'] = false;
$obj['info'] = "商品追蹤失敗";

if( !isset($_SESSION['email'])){ //確認登入與否
    $obj['info'] = '請先登入';
} else if( isset($_POST['prod_id'])){ //確認前端請求資料是否完整
    try{
        //新增商品追蹤的 SQL 語法
        $sql = "INSERT INTO `products_follow` (`email`, `prod_id`) 
                VALUES ('{$_SESSION['email']}', {$_POST['prod_id']})";
        
        //執行 SQL 語法
        $stmt = $pdo->query($sql);

        //判斷是否寫入資料
        if($stmt->rowCount() > 0){
            //修改預設訊息
            $obj['success'] = true;
            $obj['info'] = "商品追蹤成功";
        }
    } catch(PDOException $e){
        /**
         * $pdo->errorInfo() 內容
         * [
         *     "23000", 
         *     1062, 
         *     "Duplicate entry 'abc@abc.abc' for key 'PRIMARY'"
         * ]
         * 
         * 參考連結
         * https://mariadb.com/kb/en/mariadb-error-codes/
         */
        switch($pdo->errorInfo()[1]){
            case 1062:
                $obj['info'] = '此商品已追蹤';
            break;

            case 1064:
                $obj['info'] = 'SQL 語法錯誤';
            break;
        }
    }
}

//告訴前端，回傳格式為 JSON (前端接到，會是物件型態)
header('Content-Type: application/json');

//輸出 JSON 格式，供 ajax 取得 response
echo json_encode($obj, JSON_UNESCAPED_UNICODE);