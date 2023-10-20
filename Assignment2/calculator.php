<?php

$answer = $_POST['answer'];
$fillFirst = $_POST['fillFirst'];
$fillSecond = $_POST['fillSecond'];
echo "Answer: $answer <br>";
echo "First: $fillFirst <br>";
echo "Second: $fillSecond <br>";

     //Main input form
     echo "<html style='text-align:center'>";
     echo "
          <form method=\"POST\"> 
               <h1>PHP Calculator 2</h1>
               <p id=\"test\">Enter two numbers and select an operator</p>
               <div id=\"bodyWrap\">
                    <label for=\"num1\">Num 1</label>";
                    if($fillFirst){
                         echo "<input id=\"num1\" name=\"num1\" type=\"text\" value=$answer>";
                    }else{
                         echo "<input id=\"num1\" name=\"num1\" type=\"text\">";
                    }
     echo"
                    <br><br>

                    <div>Operator: </div>
                    <input type=\"radio\" id=\"+\" name=\"operator\" value=\"+\">
                    <label for=\"+\">+</label><br>
                    <input type=\"radio\" id=\"-\" name=\"operator\" value=\"-\">
                    <label for=\"-\">-</label><br>
                    <input type=\"radio\" id=\"x\" name=\"operator\" value=\"x\">
                    <label for=\"x\">x</label><br>
                    <input type=\"radio\" id=\"/\" name=\"operator\" value=\"/\">
                    <label for=\"/\">/</label>
                    <br><br>

                    <label for=\"num2\">Num 2</label>";
                    if($fillSecond){
                         echo "<input id=\"num2\" name=\"num2\" type=\"text\" value=$answer>";
                    }else{
                         echo "<input id=\"num2\" name=\"num2\" type=\"text\">";
                    }
     echo "
                    <br><br>
                    
                    <input type='hidden' name='answer' value=$answer>
                    <input type='hidden' name='answer' value=$fillFirst>
                    <input type='hidden' name='answer' value=$fillSecond>
                    <input type=\"submit\" name=\"submit1\">
               </div>
          </form>
     ";

     //Handling first form
     if($_POST['submit1']){
          $num1= $_POST["num1"];
          $num2= $_POST["num2"];
          $operator = $_POST["operator"];
          $answer = $_POST["answer"];
          echo $num1;
          echo " ".$operator;
          echo " ".$num2;
          ?><br><?php
          if($operator == "+"){
               $answer = $num1 + $num2;
               echo "Answer: ".$answer;
          }else if($operator == "-"){
               $answer = $num1 - $num2;
               echo "Answer: ".$answer;
          }else if($operator == "x"){
               $answer = $num1 * $num2; 
               echo "Answer: ".$answer;
          }else if($operator == "/"){
               $answer = $num1 / $num2; 
               echo "Answer: ".$answer;
          }else{
               echo "Invalid operator";
          }
     }

     //Second form (first button)
     if(isset($answer)) {
          echo "
               <form method='POST'>
                    <input type='hidden' name='answer' value=$answer>
                    <input type='hidden' name='fillFirst' value=$answer>
                    <input type='submit' name='submit2' value='Add $answer to Box 1'>
               </form>
          ";
     }

     //Third form (second button)
     if(isset($answer)) {
          echo "
          <form method='POST'>
               <input type='hidden' name='answer' value=$answer>
               <input type='hidden' name='fillSecond' value=$answer>
               <input type='submit' name='submit3' value='Add $answer to Box 2'>
          </form>
          ";
     }

?>