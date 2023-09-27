<?php
$students = fopen("Students.txt", "r");
$grades = fopen("Grades.txt", "r");
$studentID;
//Handling form, printing grades
unset($studentID);
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
     while(!feof($grades)){
          $gradEx = explode(",", fgets($grades));
          if($gradEx[0] == $studentID){
               $hasGrades = TRUE;
               echo "<tr>";
                    echo "<td>".$gradEx[1];
                    echo "<td>".$gradEx[2];
               echo "</tr>";
          }
     }
     echo "</table>";

     if(!$hasGrades){
          echo "Student has no grades";
     }
     
}

fclose($students);
fclose($grades);
?>