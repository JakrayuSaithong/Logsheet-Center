<?php
include_once(__DIR__ . '/../route.php');
include_once    'connection.php';
include_once    'function.php';
include_once    'security.php';



$route            =    new Route();
$srvsql            =    new    srvsql();
$konnext_lqsym    =    $srvsql->konnext_lqsym();
$connection_Logsheet    =    $srvsql->connection_Logsheet();
?>