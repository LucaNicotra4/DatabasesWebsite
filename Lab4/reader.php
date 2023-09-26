<?php
$students = fopen("Students.txt", "r");
$grades = fopen("Grades.txt", "r");

//Starting table
echo "<table cellpadding='10'cellspacing='3' >";

     //Table styling
     echo"<colgroup>
     <col style='background-color: beige'>
     <col style='background-color: beige'>
     <col style='background-color: beige'>
     <col style='background-color: beige'>
     </colgroup>";
     echo "<tr>";
          echo "<th>"."Student ID";
          echo "<th>"."Last Name";
          echo "<th>"."First Name";
          echo "<th>"."Grades";
     echo "</tr>";

     //Student Data
     $gradEx = explode(',', fgets($grades));
     while(!feof($students)){
          $stuEx = explode(',', fgets($students));
          echo "<tr>";
               echo "<td>".$stuEx[0];
               echo "<td>".$stuEx[1];
               echo "<td>".$stuEx[2];
               echo "<td>";
               //Printing grades
               while($gradEx[0] == $stuEx[0]){//Check for matching student IDs
                    echo $gradEx[1]." = ".$gradEx[2].", ";
                    $gradEx = explode(',', fgets($grades));
               }
          echo "</tr>";
     }

echo "</table>";

fclose($students);
fclose($grades);
?>