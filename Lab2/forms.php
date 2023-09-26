<?php
echo "Hello, ".$_POST['name']; ?><br><?php

echo "Your favorite food is: ".$_POST['fav_food']; ?><br><?php

echo "You have: ";
if(isset($_POST["bungee"])){
    echo "gone bungee jumping, ";
}
if(isset($_POST["europe"])){
    echo "visited Europe, ";
}
if(isset($_POST["college"])){
    echo "attended college, ";
}
?><br><br><?php

echo "Your go-to team is: ".$_POST['teams'];?><br><?php
?>