<?php

     $num1 = $_POST["num1"];
     $num2 = $_POST["num2"];
     $operator = $_POST["operator"];
     if(isset($num1)){
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
     }else{
          
     }
     
?>

<!-- action="calculator_action.php" -->
<form method="POST"> 
          <h1>PHP Calculator</h1>
          <p id="test">Enter two numbers and select an operator</p>
          <div id="bodyWrap">
               <label for="num1">Num 1</label>
               <input id="num1" name="num1" type="text">
               <br><br>
               
               <div>Operator: </div>
               <input type="radio" id="+" name="operator" value="+">
               <label for="+">+</label><br>
               <input type="radio" id="-" name="operator" value="-">
               <label for="-">-</label><br>
               <input type="radio" id="x" name="operator" value="x">
               <label for="x">x</label><br>
               <input type="radio" id="/" name="operator" value="/">
               <label for="/">/</label>
               <br><br>

               <label for="num2">Num 2</label>
               <input id="num2" name="num2" type="text">
               <br><br>

               <input type="submit" name="submit">
          </div>
</form>