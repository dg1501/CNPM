<?php
$serverName = "DESKTOP-CSS8RUH\\SQLSERVERDEV"; 
$connectionOptions = array(
    "Database" => "DO_AN",
    "Uid" => "sa",
    "PWD" => "123",
    "CharacterSet" => "UTF-8"
);

$conn = sqlsrv_connect($serverName, $connectionOptions);

if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}
?>
