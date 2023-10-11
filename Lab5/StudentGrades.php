<?php
$students = fopen("Students.txt", "r");
$grades = fopen("Grades.txt", "r");
$studentID = $_POST['students'];

//Drop-down list
echo "<form method='POST'>";
     echo "<label for='students'>Choose a Student:</label>";
     echo "<select name='students' id='students' required='true'>";
          while(!feof($students)){
               $stuEx = explode(',', fgets($students));
               if($stuEx[0] != $studentID) {
                    echo "<option value=".$stuEx[0]." >".$stuEx[1].", ".$stuEx[2]."</option>";
               } else {
                    echo "<option selected=\"selected\" value=".$stuEx[0]." >".$stuEx[1].", ".$stuEx[2]."</option>";
               }
          }
     echo "</select>";
     echo "<input type='submit' value='Submit'>";
echo "</form>";

//Student grades
$studentID = $_POST['students'];
$temp = $studentID;
echo "<form method='POST'>";
echo "<input type='hidden' value='".$temp."' name='studentID' id='studentID' >";
$hasGrades = FALSE;
if(isset($studentID)){
     echo "<table cellpadding='5' cellspacing='3'>";
          //table
          echo"<colgroup>
                    <col style='background-color: beige'>
                    <col style='background-color: beige'>
               </colgroup>";
          echo "<tr>";
               echo "<th>Assignment";
               echo "<th>Grade";
          echo "</tr>";
     while(!feof($grades)){//Parsing through grades.txt
          $gradEx = explode(",", fgets($grades));
          if($gradEx[0] == $studentID){
               $hasGrades = TRUE;
               echo "<tr>";
                    echo "<td>".$gradEx[1];
                    //textbox with grade as value, assignment num as name
                    echo "<td><input type='text' value='".$gradEx[2]."' name='".$gradEx[1]."'>";
               echo "</tr>";
          }
     }

     if($hasGrades){
          echo "</table>";
          echo "<input type='submit'>";
     }else{//For students without grades
          for($i = 1; $i <= 10; $i++){
               echo "<tr>";
                    echo "<td>".$i;
                    echo "<td><input type='text' value='Z' name='".$i."'>";
               echo "</tr>";
          }
          echo "</table>";
          echo "<input type='submit'>";
     } 
}
echo "</form>";

//SECOND FORM HANDLING
$studentID = $_POST['studentID']; //verified
if(isset($studentID)){

     //Handling second form
     fclose($grades);
     $grades = fopen("Grades.txt", "r");
     $lines = array();

     //add unchanged values
     $index = 0;
     while(!feof($grades)){
          $line = fgets($grades);
          if(!($line == "\n")){
               $lineExplode = explode(',', $line);
               if($lineExplode[0] != $studentID){
                    $lines[$index++] = $line;
               }
          }   
     }

     //add new values
     for($assignment = 1; $assignment <= 10; $assignment++){
          $newGrade = $_POST[$assignment];
          $line = "\n"."$studentID,$assignment,$newGrade";
          $lines[$index++] = $line;
     }

     //Rewrite grades
     fclose($grades);
     $grades = fopen('Grades.txt', 'w');
     for($index = 0; $index < count($lines); $index++){
          fwrite($grades, $lines[$index]);
     }

     echo "Gradebook Updated!";
}

fclose($students);
fclose($grades);
?>