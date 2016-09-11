<?php
$ErrorMsgs = array();
$DBName = "chinese_zodiac";
$DBHost = "192.168.2.2";
$DBUser = "zodiac";
$DBPass = "swordfish";
$DBConnect = mysql_connect($DBHost, $DBUser, $DBPass);

// Add modern mysqli interface as mysql is deprecated
$mysqli = mysqli_connect($DBHost, $DBUser, $DBPass, $DBName);
// print_r($mysqli);

if ($DBConnect === FALSE) {
    $ErrorMsgs[] = "The database server is not available. "
    . "Connect Error is " . mysql_errno() .
    " " . mysql_error() . ".";
}
else {
    if (mysql_select_db($DBName, $DBConnect) === FALSE) {
        $ErrorMsgs[] = "Could not select the \"$DBName\"" .
        "database: " . mysql_errno($DBConnect) .
        " " . mysql_error($DBConnect) . ".";
        mysql_close($DBConnect);
        $DBConnect = FALSE;
    }

if (mysqli_connect_errno($mysqli)) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
} ?>