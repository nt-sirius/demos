<?php
//count number 1 to 100
for( $number=1; $number<=100; $number++)
{
    if($number % 15 == 0)  {
        echo "foobar, ";
    } elseif ($number % 5 == 0) {
        echo "bar, ";
    } elseif ($number % 3 == 0) {
        echo "foo, ";
    } else {       
        echo $number . ", ";
    }    
}
?>
