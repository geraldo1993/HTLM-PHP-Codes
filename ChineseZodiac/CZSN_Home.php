<?php
/* Start the session and retrieve the ProfileID
from a cookie on the client if the session
ProfileID is not set. */
session_start();
if (!isset($_SESSION['ProfileID'])) {
    if (isset($_COOKIE['ProfileID'])) {
        $_SESSION['ProfileID'] = $_COOKIE['ProfileID'];
    } 
}
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <link href='http://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="stylesheet.css" />
    <title>Chinese Zodiac Social Network</title>
</head>
<body>
<?php
if (isset($_SESSION['ProfileID'])) {
    echo "<div style='text-align: right'>" . "<a href='CZSN_Login.php'>Log " . 
    " Out</a></div>\n";
} ?>
<h1>Chinese Zodiac Social Network</h1>
<?php
require_once("DB/inc_ChineseZodiacDB.php");
if (isset($_SESSION['ProfileID'])) {
    echo "<h2>Member Pages</h2>\n";
    echo "<p>Below is a list of the members of the Chinese Zodiac Social " .
        " Network. Click on a member's name to view that member's " .
        " detailed information. You may also choose to " .
        " <a href='CZSN_MyProfile.php'> update your profile</a>.</p>\n";

$SQLQuery="select first_name, last_name, user_name " .
    " from zodiac_profiles " .
    "order by last_name, first_name, user_name;";
$result=@mysql_query($SQLQuery, $DBConnect);
if ($result===FALSE) {
    echo "Internal Error (1)";
    }
else {
    // This should never happen, but
    // we can check anyway.
    if (mysql_num_rows($result)==0) {
      echo "<p>There are no members to show.</p>\n";
    }
    else {
    echo "<ul>\n";
    while (($row=mysql_fetch_assoc($result))!==FALSE) {
        echo "<li>" . 
        "<a href='CZSN_Member.php?username=" .
        urlencode(stripslashes($row['user_name'])) .
         "'>" .
        htmlentities(stripslashes($row['first_name']), ENT_QUOTES) .
        " " . htmlentities( stripslashes( $row['last_name']), ENT_QUOTES) . 
        "</a></li>\n";
    }
    echo "</ul>\n";
    }
}
}
else {
    echo "<h2>Not Signed In</h2>\n";
    echo "<p>You are not currently logged into the Chinese Zodiac Social " .
    " Network. If you are a member, please <a href='CZSN_Login.php'>" .
    "log in</a> to view this page.</p>" .
    "<p>If you are not a member but would like to join, please " .
    "<a href='CZSN_MyProfile.php'>create a profile</a> to become " .
    " a member.</p>\n";
}
?>
</body>
</html>