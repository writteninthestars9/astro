<?php
$mobile = false;
$useragent = $_SERVER['HTTP_USER_AGENT'];

if (preg_match('/android|iphone|ipod|iemobile|blackberry|kindle|opera mini|mobile/i', $useragent)) {
    $mobile="yes";
}
?>
