<?php
//Establishing connection with server
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
echo"<body style='text-align:center'>";
echo"<h1>Query for Student Database</h1>";

//Text input form
echo"
     <form method='POST'>
          <input type='text' name='query' placeholder='Enter SQL Here'
               style='width: 25%;
               padding: 10px 10px;
               margin: 5px 0;
               border-width: 3px;'>
          <br>
          <input type='submit' value='Enter' name='Submit1'>
     </form>
";

//Handling form
if(isset($_POST['query'])){
     $query = $_POST['query'];
     //echo "<p style='font-size: 25px'>Query: $query</p> <br>";

     //Send Query
     $result = $conn->query($query);
     error_log("Type = ".gettype($result));

     $affectedRows = mysqli_affected_rows($conn);
     echo "<p style='font-size: 20px;'>Affected rows: " . $affectedRows . "</p>";
     if(is_object($result)){
          $row = $result->fetch_array(MYSQLI_BOTH);
          //$affectedRows = $conn -> affected_rows;
          $fieldinfo = $result -> fetch_fields();

          //Starting table
          echo "<table cellpadding='3' cellspacing='3' style='margin-left: auto; margin-right:auto;'>";
               echo"<colgroup>
                         <col span='".(count($row) / 2)."' style='background-color: silver'>
                    </colgroup>";
               echo "<tr>";
                    foreach($fieldinfo as $val){
                         echo "<th>". $val->name; //print column name
                    }
               echo "</tr>";
               while(isset($row)){ //Loop through rows of results
                    echo "<tr>";
                    for($index = 0; $index < count($row) / 2; $index++){
                         // if($row[$index] != ""){
                              echo "<td>$row[$index]</td>";
                         // }
                    }
                    echo "</tr>";
                    $row = $result->fetch_array(MYSQLI_BOTH);
               }
          echo "</table>";
     }else{
     }
     $result -> close();
} else {
     echo "<p>Nope.</p>";
}
?>