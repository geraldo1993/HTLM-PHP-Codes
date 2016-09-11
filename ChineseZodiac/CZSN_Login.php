<?php
session_start();

/* This is the login page, so we clear any existing session information using session_unset(). */
session_unset();

/* This is the login page, so instead of retrieving the ProfileID from a cookie, we clear any existing ProfileID cookie using setcookie() with a time in the past and an empty value. */
if (isset($_COOKIE['ProfileID'])) {
    setcookie("ProfileID", "", time()-(24*60*60), "/ChineseZodiac/");
} 

/* Connect to DB and set some global variables. */
require_once("DB/inc_ChineseZodiacDB.php");
    $BadIndicator="<span style='color: red; font-weight: bold;'>&nbsp;&#215;</span>";
    $BadUsernameIndicator="";
    $BadPasswordIndicator="";
    $UsernameValue="";
    $PasswordValue="";
    $ShowForm=TRUE;
    $ErrorMsgs=array();
    $FirstName="";

/* Validation */
if (isset($_POST['submit'])) {
    if (isset($_POST['username'])) {
        $UsernameValue=trim(stripslashes($_POST['username']));
        if (strlen($UsernameValue)==0) {
            $ErrorMsgs[]="A user name is required.";
            $BadUsernameIndicator=$BadIndicator;
        }
    }
    else {
        $ErrorMsgs[]="Internal Error (1)";
    }
    if (isset($_POST['password'])) {
        $PasswordValue=trim(stripslashes(
        $_POST['password']));
        if (strlen($PasswordValue)==0) {
            $ErrorMsgs[]="A password is required.";
            $BadPasswordIndicator=$BadIndicator;
        } 
    }
else {
    $ErrorMsgs[]="Internal Error (2)";
    }

/* Attempt to log in id username and password are supplied.
*/
if (count($ErrorMsgs)==0) {
// Get the last 25 characters of the MD5
// value of the password to store in the
// database.
    $DBPassword=substr(md5($PasswordValue),-25);
    $SQLQuery="select profile_id, first_name " .
    " from zodiac_profiles " .
    " where user_name='" . addslashes($UsernameValue) . "' " .
    " and user_password='" . addslashes($DBPassword) . "';";
    $result=@mysql_query($SQLQuery, $DBConnect);
    if ($result===FALSE) {
        $ErrorMsgs[]="Internal Error (3)";
    }
    else {
        if (mysql_num_rows($result)>0) {
            /* Successful login, so we set the session variable and the cookie to the ProfileID value from the database and display the success message instead of the form. */
            $row=mysql_fetch_array($result);
            $_SESSION['ProfileID']=$row[0];
            setcookie("ProfileID", $row[0],
            time()+(365*24*60*60),
            "/ChineseZodiac/");
            $ShowForm=FALSE;
            $FirstName=htmlentities(stripslashes($row[1]),ENT_QUOTES);
            }
        else {
            $ErrorMsgs[]="The username/password combination provided is not valid.";
        }
        mysql_free_result($result);
        }
    }
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <link href='http://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="stylesheet.css" />
    <title>Chinese Zodiac Social Network - Member Login</title>
</head>
<body>
<?php
if (isset($_SESSION['ProfileID'])) {
    echo "<div style='text-align: right'>" . 
    "<a href='CZSN_Login.php'>Log Out</a></div>\n";
} ?>
<h1>Chinese Zodiac Social Network</h1>
    <h2>Member Login</h2>
<?php
/* Display login message */
if ($ShowForm) {
    echo "<p>Please enter your user name and " .
    " password below. Remember that both fields are required and " .
    " both are case-sensitive. If you are not a member of " .
    " the Chinese Zodiac Social Network, you can  " .
    " <a href='CZSN_MyProfile.php'>create a profile</a> to join.</p>\n";
    if (count($ErrorMsgs)>0) {
        echo "<span style='color: red'>\n";
        echo "<p>The following errors were found when validating " .
        " your user name and password.</p>\n";
        echo "<ul>\n";
        foreach ($ErrorMsgs as $Msg) {
            echo "<li>$Msg</li>\n";
        }
        echo "</ul>\n";
        echo "</span>";
    }
    
    /* Display a sticky login form */
    echo "<form action='CZSN_Login.php' method='POST'>\n";
    echo "<label>Username:</label> ";
    echo "<input type='text' name='username' value='" .
        htmlentities($UsernameValue,ENT_QUOTES) . "' />" .
        $BadUsernameIndicator . "<br />\n";
    echo "<label>Password:</label> ";
    echo "<input type='password' name='password' value=''" .
        htmlentities($PasswordValue,ENT_QUOTES) . "' />" .
        $BadPasswordIndicator . "<br />\n";
    echo "<input type='submit' name='submit' " .
        " value='Log In' /><br />\n";
    echo "</form>\n";
}

/* Display welcome message if the login was successful */
else {
    echo "<p>Welcome back, $FirstName!</p>\n";
    echo "<p>Would you like to visit the <a href='CZSN_Home.php'>" .
    "member list</a> or <a href='CZSN_MyProfile.php'>" .
    "update your profile</a>?</p>\n";
}
    ?>
</body>
</html>