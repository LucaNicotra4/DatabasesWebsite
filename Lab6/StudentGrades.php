<?php
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

//execute query
// if ($result = $conn->query("SELECT ID, last_name, first_name FROM students")) {

//      //process results
//      while ($row = $result->fetch_array(MYSQLI_BOTH)) {
//           $studentID = $row[0];
//           $lastName = $row['last_name'];
//           $firstName = $row['first_name'];
//           echo"<p>$studentID - $lastName, $firstName</p>";
//      }

//      //close result set
//      $result->close();
// }

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

//Handling Form
$studentID = $_POST['students'];
$hasGrades = false;
$result = $conn->query("SELECT ID, ASSIGNMENT, GRADE FROM grades WHERE ID=$studentID");
//Creating table
echo "<table cellspacing='3' cellpadding='3'>";
     echo"<colgroup>
               <col style='background-color: silver'>
               <col style='background-color: silver'>
          </colgroup>";
     echo "<tr>";
          echo "<th>Assignment";
          echo "<th>Grade";
     echo "</tr>";
     while($row = $result->fetch_array(MYSQLI_BOTH)){
          echo "<tr>";
               echo "<td>".$row[1];
               echo "<td>".$row[2];
          echo "</tr>";
          $hasGrades = true;
     }
     if(!$hasGrades) echo "No available grades";
echo "</table>";

//close connection
$conn->close();
$conn = null;
?>