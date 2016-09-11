<?php
/* Start the session and retrieve the ProfileID from a cookie on the client if the session ProfileID is not set. */
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
    <title>Chinese Zodiac Social Network – Member Profile</title>
</head>
<body>

<?php
if (isset($_SESSION['ProfileID'])) {
    echo "<div style='text-align: right'>" .
        "<a href='CZSN_Login.php'>Log Out</a></div>\n";
} ?>
<h1>Chinese Zodiac Social Network</h1>
<?php
require_once("DB/inc_ChineseZodiacDB.php");

/* Determine if the ProfileID session element is set
and display the appropriate text */
if (isset($_SESSION['ProfileID'])) {
    if (isset($_GET['username'])) {
        echo "<h2>Member Profile</h2>\n";

        /*Read the member info drom DB */
        $SQLQuery="select profile_id, first_name, last_name, " . 
            "user_email, user_sign, user_profile " .
            "from zodiac_profiles " .
            "where user_name='" . $_GET['username'] . "';";
        $result=@mysql_query($SQLQuery, $DBConnect);

        /* Display member info on the page*/
        if ($result===FALSE) {
            echo "<p>Internal Error (1)</p>\n";
        }
        else {
            if (mysql_num_rows($result)==0) {
                echo "<p>There is no member with the user name " .
                " '" . $_GET['username'] . "'.</p>\n";
            }
            else {
                $row=mysql_fetch_assoc($result);
                // Name
                echo "<h3>" .
                    htmlentities(stripslashes($row['first_name']), ENT_QUOTES) .
                    "" . htmlentities( stripslashes( $row['last_name']), ENT_QUOTES) . 
                    "</h3>\n";
                // Username
                echo "<p><strong>User Name:" . "</strong> " .
                    $_GET['username'] . "<br >\n";
                //Email
                echo "<strong>Email Address:" .
                    "</strong> <a href='mailto:" .
                    urlencode(stripslashes($row['user_email'])) . "'>" .
                    htmlentities(stripslashes($row['user_email']),ENT_QUOTES) .
                    "</a><br >\n";
                //Zodiac sign
                echo "<strong>Zodiac Sign:</strong> " .
                    htmlentities(stripslashes($row['user_sign']), ENT_QUOTES) .
                    "<br >\n";
                echo "<strong>Profile:</strong><br />\n" .
                    htmlentities(stripslashes($row['user_profile']), ENT_QUOTES) .
                    "<br >\n";
                echo "<hr >\n";
            }
        mysql_free_result($result);
        }
        // Display links to pages accessible to logged in users
        echo "<p>You may choose to visit the " .
        "<a href='CZSN_Home.php'>member list</a> to select " .
        " a different member. You may also choose to " .
        " <a href='CZSN_MyProfile.php'>update your profile</a>.</p>\n";
    }
    else {
        echo "<h2>No Member Selected</h2>\n";
        echo "<p>You have not selected a member of " . 
            "the Chinese Zodiac Social Network. " . 
            "Please visit the <a href='CZSN_Home.php'>" . 
            "member list</a> to select a member.</p>\n";
    }
}
else {
    echo "<h2>Not Signed In</h2>\n";
    echo "<p>You are not currently logged into " .
    " the Chinese Zodiac Social Network. If you are a  " .
    " member, please <a href='CZSN_Login.php'>log in</a> " . 
    "to view this page.</p>" .
    "<p>If you are not a member but would like to join, please " .
    "<a href='CZSN_MyProfile.php'>create a profile</a> to become " .
    " a member.</p>\n";
}
?>
</body>
</html>