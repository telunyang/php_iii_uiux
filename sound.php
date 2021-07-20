<?php
//回應標頭 (Response Headers)
header('Access-Control-Allow-Origin: *'); //開放所有網域請求
header('Content-Type: application/json'); //告訴前端，回傳格式為 JSON (前端接到，會是物件型態)

//預設回傳訊息
$obj = [];
$obj['success'] = false;
$obj['info'] = '下載失敗'; 

//如果 q 存在且不為空，則開始進行聲音下載、命名與回傳
if( isset($_POST['q']) && $_POST['q'] !== '' ){
    //建立標頭 (Request Headers)
    $headers = [
        'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.80 Safari/537.36',
    ];
    
    //請求網址
    $url = "https://translate.google.com/translate_tts?ie=UTF-8&client=tw-ob&tl=zh-TW&q=".urlencode($_POST['q']);
    
    try {
        //模擬網路請求，取得實際聲音資料
        $ch = curl_init(); //curl 初始化
        curl_setopt($ch, CURLOPT_URL, $url); //設定 URL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //若有轉址，一路轉到正常顯示的頁面
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); //指定 Request Headers
        $raw_data = curl_exec($ch); //取得聲音內容 (可能是亂碼)
        curl_close($ch); //關閉 curl
        
        //以 q 的傳遞資料，整合 md5 作為聲音檔案命名
        $fileName = hash('md5', $url);
        
        //整合路徑
        $file_path = "tmp/{$fileName}.mp3";
        
        //建立聲音檔
        if( $fp = fopen($file_path, "w") ){
            fwrite($fp, $raw_data);
            fclose($fp);
        
            $obj['success'] = true;
            $obj['info'] = '下載成功';
            $obj['link'] = "https://localhost/php_iii_uiux-master/{$file_path}";
        }
    } catch(Exception $e){
        $obj['info'] = "錯誤訊息: {$e->getMessage()}";
    }
}

//將 $obj 轉成 json，並加以輸出
echo json_encode($obj, JSON_UNESCAPED_UNICODE);