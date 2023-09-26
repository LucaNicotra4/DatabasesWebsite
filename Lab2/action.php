<?php
echo "Hi ".htmlspecialchars($_POST['name']);
echo " you are ".(int)$_POST['age']." years old.";
?>