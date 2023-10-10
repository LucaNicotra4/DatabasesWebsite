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
                    echo "<td><input type='text' value='".$gradEx[2]."' name='".$gradeEx[1]."'>";
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
$studentID = $_POST['studentID'];
if(isset($studentID)){
     //Handling second form
     fclose($grades);
     $studentID = $_POST['studentID'];
     $grades = fopen("Grades.txt", "r");
     $temp = array();

     //Parse through grades file
     echo "Length: ".count($temp);
     for($count = 0; !feof($grades); $count++){ 
          $line = explode(',', fgets($grades));
          if(!($studentID == $line[0])){
               $tempLine = $line[0].",".$line[1].",".$line[2];
               $temp[$count] = $tempLine;
          }
     }
     $temp[count($temp)] = "\n";
     echo "Lenght post grades: ".count($temp);
     //Add altered grades
     for($count = 1; $count <= 10; $count++){
          $new = $_POST[$count]; //get grade per assignment number
          echo "Grade for assigment ".$count.": ".$new;
          $temp[count($temp)] = $studentID.",".$count.",".$new."\n"; //add to end of temp
     }
     echo "Lenght post alter: ".count($temp);
     //Save to grades
     unset($line);
     fclose($grades);
     $grades = fopen("grades.txt", "w");
     foreach($temp as $line){
          //echo "line: ".$line;
          fwrite($grades, $line);
     }
}

fclose($students);
fclose($grades);
?>