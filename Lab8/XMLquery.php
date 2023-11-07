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

//Submit Query
$sql = "SELECT * FROM students s LEFT JOIN grades g ON s.id = g.id;";
$result = $conn->query($sql);
$fieldinfo = $result -> fetch_fields();
$row = $result->fetch_array(MYSQLI_BOTH);
$showTable = false;

//table
if($showTable){
echo "<body style='text-align: center;'>";
echo "<table cellspacing='3' cellpadding='3' style='margin-left:auto; margin-right:auto;'>";
     echo"<colgroup>
          <col span='".count($row)."' style='background-color: silver'>
     </colgroup>";
     echo "<tr>";//headers
          foreach($fieldinfo as $val){
               echo "<th>". $val->name; //print column name
          }
     echo "</tr>";
     while(isset($row)){ //data
          echo "<tr>";
          for($i = 0; $i < count($row); $i++){
               if($row[$i] != ''){
                    echo"<td>$row[$i]";
               }
          }
          echo "</tr>";
          $row = $result->fetch_array(MYSQLI_BOTH);
     }
echo "</table>";
}

//write XML
$xw = xmlwriter_open_memory();
xmlwriter_set_indent($xw, 1);
$res = xmlwriter_set_indent_string($xw, ' ');

xmlwriter_start_document($xw, '1.0', 'UTF-8');
     xmlwriter_write_pi($xw, "xml-stylesheet", "type=\"text/xsl\" href=\"style.xsl\"");

     xmlwriter_start_element($xw, "students");

          //elements
          while(isset($row)){
               xmlwriter_start_element($xw, "row");
               $count = 0;
               foreach($row as $data){
                    //sub-element
                    xmlwriter_start_element($xw, "data$count");
                         xmlwriter_text($xw, "$data");
                    xmlwriter_end_element($xw); // data
                    $count++;
               }

               xmlwriter_end_element($xw); // row
               $row = $result->fetch_array(MYSQLI_BOTH);
          }

     xmlwriter_end_element($xw); // students

     //PI
     $doc = xmlwriter_output_memory($xw);

     $tempFileName = tempnam(".", "grades");

     $xmlFileName = $tempFileName.".xml";

     $handle = fopen($xmlFileName, "w");

     fwrite($handle, $doc);

     fclose($handle);

     unlink($tempFileName);

     header("Location: ".basename($xmlFileName));

     flush();

     time_nanosleep (2 , 0);

     register_shutdown_function('unlink', $xmlFileName);

     // A processing instruction
     xmlwriter_start_pi($xw, 'php');
     xmlwriter_text($xw, '$foo=2;echo $foo;');
     xmlwriter_end_pi($xw);

xmlwriter_end_document($xw);

echo xmlwriter_output_memory($xw);

?>