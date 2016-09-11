<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <link href='http://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="stylesheet.css" />
    <title>View Zodiac Feedback</title>
</head>
<!-- Project 8-3.-->
<body>
<?php
    // Import DB connection string
    require_once("DB/inc_ChineseZodiacDB.php");
    $query = "SELECT message_timestamp, sender, message " .
        "FROM zodiac_feedback " .
        "WHERE public_message='Y';";
    $result = mysqli_query($mysqli, $query)
            or die(mysqli_error($mysqli));

    /* display results*/
    echo "<table>";
    echo "<tr><th>Timestamp</th><th>Sender</th><th>Message</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>$row[message_timestamp]</td>";
        echo "<td>$row[sender]</td>";
        echo "<td>$row[message]</td>";
        echo "</tr>";
    }
    echo "</table>";
    /* free result set */
    $result->free();


    /* close connection */
    $mysqli->close();
?>
</body>
</html>