<?php
//simple hack to bypass purchase code
//nulled by Swalzpro
$swalzpro = new stdClass();
$swalzpro->valid = true;
$swalzpro->message = "Success, Enjoy";
header('Content-Type: application/json');


$res = json_encode($swalzpro, JSON_PRETTY_PRINT);

echo $res;
?>