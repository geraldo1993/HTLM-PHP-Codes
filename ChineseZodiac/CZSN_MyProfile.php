<?php
/* Start the session and retrieve the ProfileID from a cookie on the client if the session ProfileID is not set. */
session_start();
    if (!isset($_SESSION['ProfileID'])) {
        if (isset($_COOKIE['ProfileID'])) {
            $_SESSION['ProfileID'] = $_COOKIE['ProfileID'];
        }
    }

/* Set up DB connection, define global variables
*/
require_once("DB/inc_ChineseZodiacDB.php");
$BadIndicator="<span style='color: red; font-weight: bold;'>&nbsp;&#215;</span>";
$BadFields=array();
$FieldValues=array();
$ErrorMsgs=array();
$SuccessMsg="";
$Signs=array("Rat", "Ox", "Tiger", "Rabbit", "Dragon", "Snake", "Horse", 
    "Goat", "Monkey", "Rooster", "Dog", "Pig");

/* Handle form input */
if (isset($_POST['submit'])) {
    switch ($_POST['submit']) {
        case 'Update My Info':
            
        case 'Create Profile':
            // Validate fields common for all users
            $FieldValues['first_name'] = trim(stripslashes($_POST['first_name']));
            if (strlen($FieldValues['first_name'])==0) {
                $ErrorMsgs[]="A first name is required.";
                $BadFields['first_name'] = $BadIndicator;
            }
            $FieldValues['last_name'] = trim(stripslashes($_POST['last_name']));
            if (strlen($FieldValues['last_name']) == 0) {
                $ErrorMsgs[]="A last name is required.";
                $BadFields['last_name'] = $BadIndicator;
            }

            // Validate the email address.
            $FieldValues['user_email'] = trim(stripslashes($_POST['user_email']));
            if (strlen($FieldValues['user_email'])==0) {
                $ErrorMsgs[] = "An email address is required.";
                $BadFields['user_email'] = $BadIndicator;
            }
          
            else {
                $pattern = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@" .
                    "[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i";
                if (preg_match($pattern, $FieldValues['user_email'])==0) {
                    $ErrorMsgs[]="The email address entered is not valid.<br />\n";
                    $BadFields['user_email'] = $BadIndicator;
                } 
            }

            // validate username
            $FieldValues['user_name'] = trim(stripslashes($_POST['user_name']));
            if (strlen($FieldValues['user_name'])==0) {
                $ErrorMsgs[]="A user name is required.";
                $BadFields['user_name'] = $BadIndicator;
            }
            // check to see if the user name is in use
            else {
                $SQLQuery="select count(*) " .
                " from zodiac_profiles " .
                " where user_name='" . addslashes($FieldValues['user_name']) . "'";
                // If it's my ID, don't count it
                if (isset($_SESSION['ProfileID'])) {
                    $SQLQuery .= " and profile_id<>" . $_SESSION['ProfileID'];
                }
                $SQLQuery .= ";";
                $result=mysql_query($SQLQuery, $DBConnect);

                if ($result!==FALSE) {
                    if (mysql_num_rows($result)>0) {
                    $row=mysql_fetch_array($result);
                        if ($row[0]>0) {
                            $ErrorMsgs[]="The specified user name is already in use. " .
                                "Please choose a different user name.";
                            $BadFields['user_name'] = $BadIndicator;
                        }
                    }
                    mysql_free_result($result);
                }
            }
$FieldValues['user_sign'] = trim(stripslashes($_POST['user_sign']));
if ((strlen($FieldValues['user_name']) == 0) ||
    (strcmp($FieldValues['user_name'],'-') == 0)) {
    $ErrorMsgs[]="A zodiac sign is required.";
    $BadFields['user_sign'] = $BadIndicator;
}
// user_profile is not required
$FieldValues['user_profile'] = trim(stripslashes($_POST['user_profile']));

// validate profile fields that are specific to new users
if (strcmp($_POST['submit'],'Create Profile')==0) {
    $FieldValues['new_password'] = trim(stripslashes($_POST['new_password']));
    if (strlen($FieldValues['new_password'])==0) {
        $ErrorMsgs[]="A password is required.";
        $BadFields['new_password'] = $BadIndicator;
    }
$FieldValues['confirm_password'] = trim(stripslashes($_POST['confirm_password']));

if (strlen($FieldValues['confirm_password']) == 0) {
    $ErrorMsgs[]="A password confirmation is required.";
    $BadFields['confirm_password'] = $BadIndicator;
}
if (strcmp($FieldValues['new_password'], $FieldValues['confirm_password']) != 0) {
    $ErrorMsgs[]="The passwords don't match.";
    $BadFields['new_password'] = $BadIndicator;
    $BadFields['confirm_password'] = $BadIndicator;
    }
}

// If successful, update the database
if (count($ErrorMsgs)==0) {
    // Update info for an existing member.
    if (strcmp($_POST['submit'], 'Update My Info')==0) {
        $SQLQuery="UPDATE zodiac_profiles " .
        " SET first_name='" .
        addslashes($FieldValues['first_name']) .
        "', last_name='" .
        addslashes($FieldValues['last_name']) .
        "', user_email='" .
        addslashes($FieldValues['user_email']) .
        "', user_name='" .
        addslashes($FieldValues['user_name']) .
        "', user_profile='" .
        addslashes($FieldValues['user_profile']) .
        "' WHERE profile_id=" . $_SESSION['ProfileID'] . ";";

        if (mysql_query($SQLQuery, $DBConnect)===FALSE) {
            echo "<p>Internal Error (1)</p>\n";
        }
        else {
            $SuccessMsg="Your profile information has been updated.";
        } 
    }

// Create profile for a new member. 
else {
    $DBPassword=substr(md5($FieldValues['new_password']), -25);
    $SQLQuery = "INSERT INTO zodiac_profiles " .
        "(first_name, " .
        "last_name, " .
        "user_email, " .
        "user_name, " .
        "user_password, " .
        "user_sign, " .
        "user_profile) " .
        "VALUES ('" .
        addslashes($FieldValues['first_name']) . "', '" .
        addslashes($FieldValues['last_name']) . "', '" .
        addslashes($FieldValues['user_email']) . "', '" .
        addslashes($FieldValues['user_name']) . "', '" .
        addslashes($DBPassword) . "', '" .
        addslashes($FieldValues['user_sign']) . "', '" .
        addslashes($FieldValues['user_profile']) . "');";

    if (mysql_query($SQLQuery, $DBConnect)===FALSE) {
         echo "<p>Internal Error (2)</p>\n";
    }
    else {
        $_SESSION['ProfileID'] = mysql_insert_id($DBConnect);
        setcookie("ProfileID", "", time()+(365*24*60*60), "/ChineseZodiac/");
        $SuccessMsg="Congratulations! You are now a " .
        " member of the Chinese Zodiac Social Network.";

        // Clear out the password information
        unset($FieldValues['new_password']);
        unset($FieldValues['confirm_password']);
    }
}
}
break;

        case 'Change My Password':
            $FieldValues['old_password'] = trim(stripslashes($_POST['old_password']));
            if (strlen($FieldValues['old_password'])==0) {
            $ErrorMsgs[]="An old password is required.";
            $BadFields['old_password'] = $BadIndicator;
            } 
            else {
                $SQLQuery="SELECT user_password " .
                    " FROM zodiac_profiles " .
                    " WHERE profile_id=" . $_SESSION['ProfileID'] . ";";
                $result=mysql_query($SQLQuery, $DBConnect);
                if ($result===FALSE) {
                    echo "<p>Internal Error (3)</p>\n";
                }
                else {
                    if (mysql_num_rows($result)>0) {
                        $row=mysql_fetch_array($result);
                        $DBOldPassword=stripslashes($row[0]);
                        $FormOldPassword=substr(md5($FieldValues['old_password']), -25);
                        if (strcmp($DBOldPassword, $FormOldPassword)!=0) {
                            $ErrorMsgs[]="The old password is invalid.";
                            $BadFields['old_password'] = $BadIndicator;
                        }
                    }
                    else {
                        echo "<p>Internal Error (4)</p>\n";
                    } 
                }
            }
            $FieldValues['new_password'] = trim(stripslashes($_POST['new_password']));
            if (strlen($FieldValues['new_password'])==0) {
                $ErrorMsgs[]="A new password is required.";
                $BadFields['new_password'] = $BadIndicator;
            }
            $FieldValues['confirm_password'] = trim(stripslashes($_POST['confirm_password']));
            if (strlen($FieldValues['confirm_password'])==0) {
                $ErrorMsgs[]="A password confirmation is required.";
                $BadFields['confirm_password'] = $BadIndicator;
            }
            if (strcmp($FieldValues['new_password'], $FieldValues['confirm_password']) != 0) {
                $ErrorMsgs[]="The passwords don't match.";
                $BadFields['new_password'] = $BadIndicator;
                $BadFields['confirm_password'] = $BadIndicator;
            }

            if (count($ErrorMsgs)==0) {
                $DBPassword=substr(md5($FieldValues['new_password']), -25);
                $SQLQuery="UPDATE zodiac_profiles " .
                    " SET user_password='" . addslashes($DBPassword) .
                    "' WHERE profile_id=" . $_SESSION['ProfileID'] . ";";
                if (mysql_query($SQLQuery, $DBConnect)===FALSE) {
                    echo "<p>Internal Error (5)</p>\n";
                }
                else {
                    $SuccessMsg="Your password has been changed.";
                    // Clear out the password information
                    unset($FieldValues['old_password']);
                    unset($FieldValues['new_password']);
                    unset($FieldValues['confirm_password']);
                } 
            }
            break;
// Add cases for deleting and uploading images.
        default:
            break;
    }
    } 
else {
    if (isset($_SESSION['ProfileID'])) {
        $SQLQuery="SELECT * FROM zodiac_profiles " .
            " WHERE profile_id=" . $_SESSION['ProfileID'];
        $result=mysql_query($SQLQuery, $DBConnect);
            if ($result!==FALSE) {
                if (mysql_num_rows($result)>0) {
                    $FieldValues = mysql_fetch_assoc($result);
                    $FieldCount = count($FieldValues);
                    for ($i=0;$i<$FieldCount;++$i) {
                        $FieldValues[$i] = stripslashes($FieldValues[$i]);
                    }
                } 
            }
    }
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <link href='http://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="stylesheet.css" />
    <title>Chinese Zodiac Social Network – My Profile</title>
</head>
<body>
<?php
if (isset($_SESSION['ProfileID'])) {
    echo "<div style='text-align: right'>" .
        "<a href='CZSN_Login.php'>Log Out</a></div>\n";
} ?>
<h1>Chinese Zodiac Social Network</h1>
    <h2>My Profile</h2>

<?php
function DisplayProfileForm($ProfileID, $BadFields, $FieldValues) {
    global $Signs;
    echo "<div>";
    echo "<form action='CZSN_MyProfile.php' method='POST'>\n";
    echo "<label>First Name:</label> <input type='text' size='25' name='first_name'";

    // Process first name
    if (isset($FieldValues['first_name'])) {
        echo " value='" .
            htmlentities($FieldValues['first_name'], ENT_QUOTES) . "'";
    }
    echo "/>";
    if (isset($BadFields['first_name'])) {
        echo $BadFields['first_name'];
    }
    echo "&nbsp;*<br />\n";

    // Process last name
    echo "<label>Last Name:</label> <input type='text' size='25' name='last_name'";
    if (isset($FieldValues['last_name'])) {
        echo " value='" .
            htmlentities($FieldValues['last_name'],ENT_QUOTES) . "'";
    }
    echo " />";
    if (isset($BadFields['last_name'])) {
         echo $BadFields['last_name'];
    }
    echo "&nbsp;*<br />\n";

    // Process email
    echo "<label>Email Address:</label> <input type='text' " . " size='25' name='user_email'";
    if (isset($FieldValues['user_email'])) {
        echo " value='" .
            htmlentities($FieldValues['user_email'], ENT_QUOTES) . "'";
    }
    echo " />";
    if (isset($BadFields['user_email'])) {
        echo $BadFields['user_email'];
    }
    echo "&nbsp;*<br />\n";

    // Process user name
    echo "<label>User Name:</label> <input type='text' size='25' name='user_name'";
    if (isset($FieldValues['user_name'])) {
        echo " value='" .
            htmlentities( $FieldValues['user_name'],ENT_QUOTES) . "'";
    }
    echo " />";
    if (isset($BadFields['user_name'])) {
        echo $BadFields['user_name'];
    }
    echo "&nbsp;*<br />\n";

    // Process zodiac sign
    echo "<label>Zodiac Sign:</label> <select name='user_sign'>\n";
    echo "   <option value='-'>-- Choose your sign --</option>\n";
    foreach ($Signs as $Sign) {
        echo "   <option value='$Sign'";
        if ((isset($FieldValues['user_sign'])) &&
            (strcasecmp($FieldValues['user_sign'], $Sign)==0)) {
            echo " selected='selected'";
            }
        echo ">$Sign</option>\n";
        }
    echo "</select>";
    if (isset($BadFields['user_sign'])) {
         echo $BadFields['user_sign'];
    }
    echo "&nbsp;*<br />\n";

    // Process profile
    echo "<div class='profile'><label>Profile:</label>";
    if (isset($BadFields['user_profile'])) {
        echo $BadFields['user_profile'];
    }
    echo "<br />\n";

    echo "<textarea rows='5' cols='40' name='user_profile' class='profile'>";
    if (isset($FieldValues['user_profile'])) {
        echo htmlentities($FieldValues['user_profile'],ENT_QUOTES);
    }
    echo "</textarea><br />\n";
    echo "</div><br />";

    if (isset($_SESSION['ProfileID'])) {
        echo "<input type='submit' name='submit' value='Update My Info' />\n";
    }
    else {

    // Set password
    echo "<label>Password:</label> <input type='password' size='16' name='new_password'";
    if (strlen($FieldValues['new_password'])>0) {
        echo " value='" .
            htmlentities($FieldValues['new_password'], ENT_QUOTES) . "'";
    }
    echo " />";
    if (isset($BadFields['new_password'])) {
        echo $BadFields['new_password'];
    }
    echo "&nbsp;*<br />\n";
    echo "<label>Confirm Password:</label> <input " .
        " type='password' size='16' name='confirm_password'";

    if (strlen($FieldValues['confirm_password'])>0) {
         echo " value='" .
              htmlentities(
              $FieldValues['confirm_password'],
              ENT_QUOTES) ."'";
    }
    echo " />";
    if (isset($BadFields['confirm_password'])) {
         echo $BadFields['confirm_password'];
    }
    echo "&nbsp;*<br /><br />\n";

    echo "<input type='submit' name='submit' value='Create Profile' />\n";
    }

    echo "</form>\n";
    echo "</div>";
}

// Display the password form
function DisplayPasswordForm($ProfileID, $BadFields, $FieldValues) {
    echo "<div><form action='CZSN_MyProfile.php' method='POST'>\n";
    echo "<label>Old Password:</label> <input type='password' size='16' name='old_password'";
    if (strlen($FieldValues['old_password'])>0) {
        echo " value='" .
            htmlentities($FieldValues['old_password'], ENT_QUOTES) . "'";
    }
    echo " />";
    if (isset($BadFields['old_password'])) {
        echo $BadFields['old_password'];
    }
    echo "<br />\n";

    echo "<label>New Password:</label> <input type='password' size='16' name='new_password'";
    if (strlen($FieldValues['new_password'])>0) {
        echo " value='" .
            htmlentities($FieldValues['new_password'], ENT_QUOTES) ."'";
    }
    echo " />";
    if (isset($BadFields['new_password'])) {
        echo $BadFields['new_password'];
    }
    echo "<br />\n";
    echo "<label>Confirm Password:</label> <input " .
        " type='password' size='16' " .
        " name='confirm_password'";
    if (strlen($FieldValues['confirm_password'])>0) {
        echo " value='" .
            htmlentities($FieldValues['confirm_password'], ENT_QUOTES) ."'";
    }
    echo " />";
    if (isset($BadFields['confirm_password'])) {
        echo $BadFields['confirm_password'];
    }
    echo "<br />\n";
    echo "<input type='submit' name='submit' " .
    " value='Change My Password' />\n";
    echo "</form>\n";
}

// Display error messages
function DisplayErrors($ErrorMsgs) {
    if (count($ErrorMsgs)>0) {
        echo "<span style='color: red'>\n";
        echo "<p>The following errors were found when processing your entries:</p>\n";
        echo "<ul>\n";
        foreach ($ErrorMsgs as $Msg) {
            echo "   <li>$Msg</li>\n";
        }
        echo "</ul>\n";
        echo "</span>\n";
    }
}

// Display success message
if (strlen($SuccessMsg)>0) {
    echo "<h4>$SuccessMsg</h4>\n";
}

if (isset($_SESSION['ProfileID'])) {
    echo "<p>Use this page to maintain your personal information. Remember " .
    " that items marked with an asterisk (*) are required.</p>\n";
}
else {
    echo "<p>Please enter your personal information below. When " .
    " finished, click the 'Create Profile' button to create " .
    " your profile. Fields marked with an asterisk (*) are " .
    " required.</p>\n";
}

// Display errors if the code has been processed
if ((isset($_POST['submit'])) &&
    ((strcmp($_POST['submit'], 'Update My Info')==0) ||
    (strcmp($_POST['submit'], 'Create Profile')==0))) {
    DisplayErrors($ErrorMsgs);
}
DisplayProfileForm($_SESSION['ProfileID'], $BadFields, $FieldValues);

// Display password change form
if (isset($_SESSION['ProfileID'])) {
    echo "<br /><hr />\n";
    if ((isset($_POST['submit'])) &&
        (strcmp($_POST['submit'], 'Change My Password')==0)) {
        DisplayErrors($ErrorMsgs);
    }
    DisplayPasswordForm($_SESSION['ProfileID'], $BadFields, $FieldValues);
    echo "<br /><hr />\n";
    echo "<p>Visit other <a href='CZSN_Home.php'>member pages</a>.</p>\n";
}
?>
</body>
</html>