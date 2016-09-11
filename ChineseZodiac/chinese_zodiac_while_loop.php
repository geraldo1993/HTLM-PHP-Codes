<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
    <link href='http://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="stylesheet.css" />
    <title>Know your zodiac sign: using IF-ELSE</title> 
    <!-- Project 2-5.-->
</head>
<body>
<?php
ini_set('display_errors', 'On');

$zodiac = array('Rat', 'Ox', 'Tiger', 'Rabbit', 'Dragon', 'Snake', 'Horse', 'Goat', 'Monkey', 'Rooster', 'Dog', 'Pig');

$count = 0;

echo "<table border='1'>";
echo "<tr>";
while ($count < 12) {
    echo "<td>{$zodiac[$count]}</td>";
    ++$count;
}  
echo "</tr>";

$start_year = 1912;
$year = $start_year;

while ($year < 2014) {
    echo "<tr>";
    $sign = 0;

    while ($sign < 12) {
        echo "<td>{$year}</td>";
        ++$year;
        ++$sign;
    }
    echo "</tr>";
}
echo "</table>";
?>
</body>
</html>