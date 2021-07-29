<?php
session_start();
require_once 'db.inc.php';

//預設訊息
$obj['success'] = false;
$obj['info'] = "取得代碼失敗";

//確認優惠代碼是否存在
if( isset($_POST['code']) ){
    try{
        //新增使用者的 SQL 語法
        $sql = "SELECT 1 
                FROM `coupon` 
                WHERE `email` = '{$_SESSION['email']}' 
                AND `code` = '{$_POST['code']}'
                AND `isUsed` = 0";
        
        //執行 SQL 語法
        $stmt = $pdo->query($sql);

        //判斷是否寫入資料
        if($stmt->rowCount() > 0){
            //修改預設訊息
            $obj['success'] = true;
            $obj['info'] = "確認成功";
        } else {
            $obj['info'] = '此代碼無法使用';
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
                $obj['info'] = '此帳號已註冊';
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