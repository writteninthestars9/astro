<?php

$to="sumeetxxx@gmail.com";
$subject=$url;
$message_user="visitor came";


$headers = "From: Notify <support@writteninthestars.site>\r\n";
$headers .= "Reply-To: support@writteninthestars.site\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

mail($to, $subject, $message_user, $headers);

?>