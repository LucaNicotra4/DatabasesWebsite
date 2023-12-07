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

//first form
echo"
     <style>
          label {
               display: inline-block;
               width: 75px;
               text-align: right;
          }
     </style>

     <form method='POST'>
          <label for='1'>StudentID</label>
          <input id='1' type='number' name='StudentID'></input>
          <br>
          <label for='2'>Assignment</label>
          <input id='2' type='number' name='Assignment' maxlength='3'></input>
          <br>
          <label for='3'>Grade</label>
          <input id='3' type='text' name='Grade' maxlength='1'></input>
          <br>
          <input type='submit' value='Submit' name='Form1'>
          <br>
     </form>
     ";

//Handling form
if($_POST['Form1']){
     $stmt = $conn->prepare("UPDATE grades SET GRADE = ?
                              WHERE ASSIGNMENT = ? AND ID = ?");
     $stmt->bind_param("sii", $grade, $assignment, $studentID);

     $studentID = $_POST['StudentID'];
     $assignment = $_POST['Assignment'];
     $grade = $_POST['Grade'];
     $stmt->execute();
     
     echo"Student $studentID assignment $assignment grade set to $grade";

     $stmt->close();
     $conn->close();
}
     
?>