<?php
//關閉 session
session_start();
session_destroy();

//預設訊息
$obj['success'] = true;
$obj['info'] = "登出成功";

//告訴前端，回傳格式為 JSON (前端接到，會是物件型態)
header('Content-Type: application/json');

//輸出 JSON 格式，供 ajax 取得 response
echo json_encode($obj, JSON_UNESCAPED_UNICODE);