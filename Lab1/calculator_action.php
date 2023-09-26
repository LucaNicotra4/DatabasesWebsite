<html>
<body>
Equation: <br>
<?php 
     $num1 = $_POST["num1"];
     $num2 = $_POST["num2"];
     $operator = $_POST["operator"];
     echo $num1;
     echo " ".$operator;
     echo " ".$num2;
     ?><br><?php

     if($operator == "+"){
          $sum = $num1 + $num2;
          echo "Answer: ".$sum;
     }else if($operator == "-"){
          $sum = $num1 - $num2;
          echo "Answer: ".$sum;
     }else if($operator == "x"){
          $product = $num1 * $num2; 
          echo "Answer: ".$product;
     }else if($operator == "/"){
          $divisor = $num1 / $num2; 
          echo "Answer: ".$divisor;
     }else{
          echo "Invalid operator";
     }
?>

</body>
</html>