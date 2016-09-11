<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href='http://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="stylesheet.css" />
    <title>Chinese Zodiac</title>
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
            if (isset($_GET['page'])) {
                switch ($_GET['page']) {
                    case 'site_layout':
                        include('Includes/inc_site_layout.php');
                        break;
                    case 'control_structures':
                        include('Includes/inc_control_structures.php');
                        break;
                    case 'string_functions':
                        include('Includes/inc_string_functions.php');
                        break;
                    case 'web_forms':
                        include('Includes/inc_web_forms.php');
                        break;
                    case 'midterm_assessment':
                        include('Includes/inc_midterm_assessment.php');
                        break;
                    case 'state_information':
                        include('Includes/inc_state_information.php');
                        break;
                    case 'user_templates':
                        include('Includes/inc_user_templates.php');
                        break;
                    case 'final_project':
                        include('CZSN_Home.php');
                        break;
                    default:
                        include('Includes/inc_home_page.php');
                        break;
                }
            }
            else {
                include('Includes/inc_home_page.php');
            }
            ?>
        </div>
    </div>
    <div id="footer"><?php include('Includes/inc_footer.php'); ?></p> 
    </div>
</body>
</html>
