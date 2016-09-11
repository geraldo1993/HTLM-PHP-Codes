<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<html>
	<head>
		<title>
			<h1> Validate Credit Card</h1><hr />
		</title>
	</head>
	<body>
		<?php
			 $CreditCard=array("",
			 "8910-1234-5678-6543",
			"0000-9123-4567-0123");
			
			foreach($CreditCard as $CardNumber){
		    if(empty($CardNumber))
		    echo"<p> This Credit Card is invalid because it contains an empty string.</p>";
		    else{
		         echo"<p> Credit Card Number".$CreditCardNumber."is valid Credit Card Number.</p>";
		         }
		         }		
			
			
			
			
					?>
	</body>
</html>
