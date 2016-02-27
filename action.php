<?php
require_once "vendor/autoload.php";
require_once "vendor/phpmailer/phpmailer/language/phpmailer.lang-ru.php";

//собираем данные для отправки
$name		= $_POST['name'];
$email 		= $_POST['email'];
$dataBack 	= array();
$captcha 	= $_POST['g-recaptcha-response'];
$ip 		= $_SERVER['REMOTE_ADDR'];
$secret_key = '6LeKqhATAAAAANtethQ2tFl8_m-HR8C4F4Gnk5LM';


if (send_message_to_email(array('name' => $name, 'email' => $email))) {
    $dataBack['status'] = 'OK';
    $dataBack['text'] = 'Ваше письмо успешно отправлено!';
} else {
    $dataBack['status'] = 'error';
    $dataBack['text'] = 'Что-то пошло не так, письмо не отправлено! Возможно проблемы с сервером.';
}


function send_message_to_email($dataMail)
{
    $mail = new PHPMailer;

    $mail->IsSMTP();
    $mail->Host 		= "smtp.jino.ru";
    $mail->SMTPAuth 	= true;
    $mail->Username = 'info@run-ski.ru';
    $mail->Password = 'S42195';
    $mail->SMTPSecure	= "ssl";
    $mail->Port 		= '465';

    $mail->CharSet 		= 'UTF-8';
    $mail->From = 'info@serger777.myjino.ru';
    $mail->FromName = 'GS';
    $mail->addCC('serger777@gmail.com');
    $mail->isHTML(true);

    $mail->Subject = "Письмо с сайта http://merlikaopt.ru/";



    $mail->isHTML(false);

    // Устанавливаем текст сообщения
    $mail->msgHTML(" Письмо с сайта http://merlikaopt.ru/ : ". $dataMail['email' ] . ' ' . $dataMail['name'] . ': ' . $dataMail['phone'] . ' '  );
    return $mail->send();
};







header("Content-Type: application/json");
echo json_encode($dataBack);
exit;
?>