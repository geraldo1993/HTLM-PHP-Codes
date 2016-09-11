<!DOCTYPE html>
<html>
  <head>
        <link href='http://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="stylesheet.css" />
    <title>Show source code</title> 
    <title>Similar names</title>
  </head>

<body>
    <h1>Similar names</h1>
        <?php
        $zodiac = array('Rat', 'Ox', 'Tiger', 'Rabbit', 'Dragon', 
    'Snake', 'Horse', 'Goat', 'Monkey', 'Rooster', 'Dog', 'Pig');
        $levenshtein_smallest = 99999;
        $similar_largest = 0;
        $inner_max = count($zodiac);
        $outer_max = $inner_max - 1;
        $levenshtein_word1 = "";
        $levenshtein_word2 = "";
        $similar_text_word1 = "";
        $similar_text_word2 = "";

        for ($i = 0; $i < $outer_max; ++$i) {
            for ($j = $i + 1; $j < $inner_max; ++$j) {
                $levenshtein_value = levenshtein($zodiac[$i], $zodiac[$j]);
                if ($levenshtein_value < $levenshtein_smallest) {
                    $levenshtein_smallest = $levenshtein_value;
                    $levenshtein_word1 = $zodiac[$i];
                    $levenshtein_word2 = $zodiac[$j];
                }

                $similar_text_value = similar_text($zodiac[$i], $zodiac[$j]);
                if ($similar_text_value > $similar_largest) {
                    $similar_largest = $similar_text_value;
                    $similar_text_word1 = $zodiac[$i];
                    $similar_text_word2 = $zodiac[$j];
                }
            }
        }
        echo "<p>The levenshtein() function determined that $levenshtein_word1 and $levenshtein_word2 are the most similar names.</p>";
        echo "<p>The similar_text() function determined that $similar_text_word1 and $similar_text_word2 are the most similar names.</p>";

        ?>
    
</body>

  </html>