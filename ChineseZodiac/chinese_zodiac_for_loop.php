<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
    <link href='http://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="stylesheet.css" />
    <title>Know your zodiac sign: using IF-ELSE</title> 
    <!-- Project 2-4.-->
</head>
<?php
ini_set('display_errors', 'On');

$zodiac = array('Rat', 'Ox', 'Tiger', 'Rabbit', 'Dragon', 
    'Snake', 'Horse', 'Goat', 'Monkey', 'Rooster', 'Dog', 'Pig');
$num_signs = count($zodiac);

echo "<table border='1'>";
echo "<tr>";
for ($count = 0; $count < $num_signs; ++$count) {
    echo "<td>{$zodiac[$count]}</td>";
}  
echo "</tr>";

$start_year = 1912;
$end_year = 2014;

for ($year = $start_year; $year <= $end_year;) {
    echo "<tr>";

    for ($sign = 0; $sign < $num_signs; ++$sign) {
        echo "<td>{$year}</td>";
        ++$year;
    }
    echo "</tr>";
}
echo "</table>";
?>
</body>
</html>