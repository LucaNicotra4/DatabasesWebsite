<?php
$type = $_SERVER['HTTP_USER_AGENT'];
echo "<br />And now for the if<br>";
if (strpos($type, 'Firefox')) {
    echo 'You are using Firefox.';
}else{
    echo 'You are not using Firefox, Good Job';
}
?>