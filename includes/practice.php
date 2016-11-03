<?php

//fizz buzz
for ($i=1; $i<=100; $i++){
	echo "i = " . $i . " ";
	if (($i % 5 == 0) && ($i % 3 == 0)) {echo "fizz buz";}
		else if ($i % 5 == 0){echo "buzz";}
		else if ($i % 3 == 0){echo "fizz";}
		echo "<br />";
	}

$answer = 1;	
for ($i=1; $i<6; $i++){
	$answer *= $i;
}
echo "factorial of 5 is " . $answer . "<br>";


?>