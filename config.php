<?php
$serverName = "LANN\SQLEXPRESS01";  
$connectionOptions = [
    "Database" => "DLSU",
    "Uid" => "", 
    "PWD" => ""
];

$conn = sqlsrv_connect($serverName, $connectionOptions);

if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}

?>