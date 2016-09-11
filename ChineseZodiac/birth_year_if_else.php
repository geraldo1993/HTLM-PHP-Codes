<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
    <link href='http://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="stylesheet.css" />
    <title>Know your zodiac sign: using IF-ELSE</title> 
    <!-- Project 5-2.-->
</head>
<body>
    <div id="header">
        <?php 
        include 'Includes/inc_header.php';
        ?>
    </div>
    <div id="nav_text">
        <?php 
        include 'Includes/inc_text_links.php';
        ?>
    </div>

    <div id="midblock">
        <div id="nav_buttons">
            <?php 
            include 'Includes/inc_button_nav.php';
            ?>
        </div>
        <div id="dynamic_content">
            <?php 
            // make sure the server knows our time zone
            date_default_timezone_set('Pacific/Auckland');

            // initial variables
            $zodiac = array('Rat', 'Ox', 'Tiger', 'Rabbit', 'Dragon', 
                'Snake', 'Horse', 'Ram', 'Monkey', 'Rooster', 'Dog', 'Pig');
            define(CYCLE, 12); // years
            $current_year = date("Y");
            $start_year = 1900; // users are unlikely to be older anyway
            $display_form = true;
            $birth_year = '';
            ?>

            <h2>Using IF-ELSE</h2>
            <?php
            if (isset($_POST['birth_year'])) {
                $birth_year = $_POST['birth_year'];

                if (preg_match("/^[0-9]{4}$/", $birth_year)) {
                    if ($birth_year >= $start_year && $birth_year <= $current_year) {
                        $display_form = false;
                        $sign = $zodiac[($birth_year - $start_year) % CYCLE];
                        echo "<img src='Images/" . strtolower($sign) . ".jpg'>";
                        echo "<p class='response'>You were born under the sign of {$sign}.</p>";
                    }
                }
                else {
                    $display_form = true;
                }
            }
            ?>
            <?php 
            if ($display_form) { 
                if (isset($_POST['birth_year'])) {
                    echo "<p class='error_text'>Please submit a valid year. The year must be between $start_year and $current_year.</p>";
                }
                else {
                    // make layout more symmetric
                    echo "<br />";
                }
                ?>
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST"> Birth information:<br />   
                <input type="text" name="birth_year" class="text_field" value=<?php echo $start_year; ?> />
                <br />
                <button class="nav_button" type="submit">Submit</button>
            </form>
            <?php }
            ?>
        </div>
    </div>
    <div id="footer"> <?php include('Includes/inc_footer.php'); ?>
    </div>
</body>
</html>