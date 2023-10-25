<?php  //this is new
$servername = "127.0.0.1";
$username = "webUser";
$password = "SuperSecurePasswordHere";
$schema = "csci3100";

// Create connection
$conn = new mysqli($servername, $username, $password, $schema);

// Check connection
if ($conn->connect_error) {
     echo$conn->connect_error;
     die("Connection failed: " . $conn->connect_error);
}

echo"<p>Connected successfully</p>";
echo"<html style='text-align:center'>";
echo"<h1>GradeBook</h1>";

//Selecting Student Form
$studentID = $_POST['students'];
$result = $conn->query("SELECT ID, last_name, first_name FROM students");
echo "<form method='POST'>";
     echo "<label for='students'>Choose a Student:</label>";
     echo "<select name='students' id='students' required='true'>";
          while($row = $result->fetch_array(MYSQLI_BOTH)){
               if($row[0] != $studentID) { //if not currently selected
                    echo "<option value=".$row[0]." >".$row[1].", ".$row[2]."</option>";
               } else {
                    echo "<option selected=\"selected\" value=".$row[0]." >".$row[1].", ".$row[2]."</option>";
               }
          }   
     echo "</select>";
     echo "<input type='submit' value='Submit'>";
echo "</form>";
$result->close();

//Handling Form and Creating Table
if(isset($studentID)){
     $studentID = $_POST['students'];
     $hasGrades = false;
     $result = $conn->query("SELECT ID, ASSIGNMENT, GRADE FROM grades WHERE ID=$studentID");
     //Creating table
     echo "<form method='POST'>";
          echo "<table cellspacing='3' cellpadding='3' style='margin-left: auto; margin-right: auto;>";
               //styling
               echo"<colgroup>
                         <col style='background-color: silver'>
                         <col style='background-color: silver'>
                         <col style='background-color: silver'>
                    </colgroup>";
               //table
               echo "<tr>";
                    echo "<th>Assignment";
                    echo "<th>Grade";
               echo "</tr>";
               //loop through rows
               for($count = 1; $count <= 10; $count++){
                    $row = $result->fetch_array(MYSQLI_BOTH);
                    $grade = $row[2];
                    echo "<tr>";
                         echo "<td>".$count;//assignment number
                         echo "<td><select name='grade$count'>";//grade(assignmentNum)
                              if($grade == 'A'){
                                   echo "
                                   <option value='NA'>N/A</option>
                                   <option value='A' selected>A</option>
                                   <option value='B'>B</option>
                                   <option value='C'>C</option>
                                   <option value='D'>D</option>
                                   <option value='F'>F</option>
                                   </select>";
                              }else if($grade == 'B'){
                                   echo "
                                   <option value='NA'>N/A</option>
                                   <option value='A'>A</option>
                                   <option value='B' selected>B</option>
                                   <option value='C'>C</option>
                                   <option value='D'>D</option>
                                   <option value='F'>F</option>
                                   </select>";
                              }else if($grade == 'C'){
                                   echo "
                                   <option value='NA'>N/A</option>
                                   <option value='A'>A</option>
                                   <option value='B'>B</option>
                                   <option value='C' selected>C</option>
                                   <option value='D'>D</option>
                                   <option value='F'>F</option>
                                   </select>";
                              }else if($grade == 'D'){
                                   echo "
                                   <option value='NA'>N/A</option>
                                   <option value='A'>A</option>
                                   <option value='B'>B</option>
                                   <option value='C'>C</option>
                                   <option value='D' selected>D</option>
                                   <option value='F'>F</option>
                                   </select>";
                              }else if($grade == 'F'){
                                   echo "
                                   <option value='NA'>N/A</option>
                                   <option value='A'>A</option>
                                   <option value='B'>B</option>
                                   <option value='C'>C</option>
                                   <option value='D'>D</option>
                                   <option value='F' selected>F</option>
                                   </select>";
                              }else{
                                   echo "
                                   <option value='NA' selected>N/A</option>
                                   <option value='A'>A</option>
                                   <option value='B'>B</option>
                                   <option value='C'>C</option>
                                   <option value='D'>D</option>
                                   <option value='F'>F</option>
                                   </select>";
                              }
                    echo "</tr>";
                    $hasGrades = true;
               }
          echo "</table>";
          if(!$hasGrades) echo "No available grades";
          echo "<input type='hidden' value='$studentID' name='studentID'>";
          echo "<input type='submit' name='submit2' value='update'>";
     echo "</form>";
}

//NEED TO UPDATE FOR STUDENTS WITH NO CURRENT GRADES
//handling grade changes
if(isset($_POST['submit2'])){
     $studentID = $_POST["studentID"];
     echo "Student ID: $studentID <br>";
     $error = false;

     for($count = 1; $count <= 10; $count++){
          $grade = $_POST["grade$count"];

          //Write SQL to update database with
          if($grade != "NA"){
               // $sql = "UPDATE grades
               // SET grade = '$grade'
               // WHERE grades.assignment = $count AND grades.ID = $studentID;";
               $sql = "INSERT INTO grades (id, assignment, grade)
               VALUES ($studentID, $count, '$grade')
               ON DUPLICATE KEY UPDATE grade = '$grade'";
          }

          error_log($sql);
          if ($conn->query($sql) === TRUE) {
               
          }else{
               echo "Error: " . $conn->error . "<br>";
               $error = true;
          }
     }

     if(!$error) echo "Gradebook Updated!";
}

//close connection
$conn->close();
$conn = null;
?>