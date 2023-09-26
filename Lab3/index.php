<?php 
     $myFile = "graffitidb.txt";

     $hr = '<hr>';
     $enteredText = $_POST['enteredtext'];

     //writing to file
     $data = $enteredText.$hr;
     $fh = fopen($myFile, 'a');
     fwrite($fh, $data);
     fclose($fh);

     //printing file data to screen
     $fh = fopen($myFile, 'r');
     $theData = fread($fh, filesize($myFile));
     fclose($fh);
     echo $theData;
?>