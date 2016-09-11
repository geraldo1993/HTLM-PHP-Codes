<!DOCTYPE html>
<html>
  <head>
    <link type='text/css' rel='stylesheet' href='style.css'/>
    <title>Similar names</title>
  </head>
    <body>
    <h1>Embedded words</h1>
        <?php 
            $phrases = array("Your Chinese zodiac sign tells a lot about your personality.", "Embed PHP scripts within an XHTML document.");
            $zodiac = array('Rat', 'Ox', 'Tiger', 'Rabbit', 'Dragon', 'Snake', 'Horse', 'Goat', 'Monkey', 'Rooster', 'Dog', 'Pig');

            function buildLetterCounts($text) {
                $text = strtoupper($text);
                $letter_counts = count_chars($text);
                return $letter_counts;
            }

            function AContainsB($A, $B) {
                $return_value = true;
                $first_letter_index = ord('A');
                $last_letter_index = ord('Z');

                for ($letter_index = $first_letter_index; $letter_index < $last_letter_index; ++$letter_index) { 
                    if ($A[$letter_index] < $B[$letter_index]) { 
                        $return_value = false;
                        break;
                    }
                }
                return $return_value;
            }

            foreach ($phrases as $phrase) {
                $phrase_array = buildLetterCounts($phrase);
                $good_words = array();
                $bad_words = array();

                foreach ($zodiac as $word) {
                    $word_array = buildLetterCounts($word);
                    if (AContainsB($phrase_array, $word_array)) {
                        $good_words[] = $word;
                    }
                    else {
                        $bad_words[] = $word;
                    }
                }
                echo "<p>The following words can be made from the letters in the phrase &quot;$phrase&quot;:\n";
                foreach ($good_words as $word) {
                    echo "$word" . "\n";
                }
                echo "</p>";
                echo "<p>The following words can not be made from the letters in the phrase &quot;$phrase:&quot;\n";
                foreach ($bad_words as $word) {
                    echo "$word" . "\n";
                }
                echo "</p><hr />";
            }


         ?>
    </body>

  </html>