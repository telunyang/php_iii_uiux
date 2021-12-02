<?php
//讀取 composer 所下載的套件
require_once('vendor/autoload.php');

use PHPMailer\PHPMailer\PHPMailer;

$mail = new PHPMailer();
$mail->IsSMTP();
$mail->Mailer = "smtp";
$mail->CharSet = 'UTF-8';
$mail->SMTPDebug  = 0;  
$mail->SMTPAuth   = TRUE;
$mail->SMTPSecure = "tls";
$mail->Port       = 587;
$mail->Host       = "smtp.gmail.com";
$mail->Username   = "你的Gmail帳號@gmail.com";
$mail->Password   = "xxxxxxxxxxxxxxxxxxx";

$mail->IsHTML(true);
$mail->AddAddress("收件者的Email", "他的名稱");
$mail->SetFrom("你的Gmail帳號@gmail.com", "你的名稱");
// $mail->AddReplyTo("reply-to-email@domain", "reply-to-name");
// $mail->AddCC("cc-recipient-email@domain", "cc-recipient-name");
$mail->Subject = "測試我的 PHP 寄信功能";
$content = "驗證碼: <a href='http://localhost/lativ/verify.php?verified_code=dae44e1a4b2cd0bc49b7f9fcc5cff556' target='_blank'>按我啟用</a>";
$mail->MsgHTML($content); 

if( $mail->Send() ) {
    echo "寄送成功";
} else {
    echo "寄送失敗";
    print_r($mail);
}