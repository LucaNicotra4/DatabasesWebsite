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

//XSLT Styling
echo"
<?xml version='1.0' encoding='UTF-8'?>

<xsl:stylesheet version='1.0' xmlns:xsl='http://www.w3.org/1999/XSL/Transform'> 
     <xsl:template match='/'>
     <html>
     <xsl:for-each select='row'>
     <table border='1'>
          <tr>
            <td><xsl:value-of select='data'/></td>
          </tr>
     </table>
     </xsl:for-each>
     </html>
     </xsl:template>
</xsl:stylesheet>";

xmlwriter_start_document($xw, '1.0', 'UTF-8');

     $count = 0;
     while(isset($row)){ //row by row

          //first element
          xmlwriter_start_element($xw, "row");
          
               //first element attribute
               xmlwriter_start_attribute($xw, 'att1');
                    xmlwriter_text($xw, 'valueofatt1');
               xmlwriter_end_attribute($xw);

               //sub-element
               for($i = 0; $i < count($row); $i++){
                    xmlwriter_start_element($xw, "data");
                         xmlwriter_text($xw, "$row[$i]");
                    xmlwriter_end_element($xw); // data1
               }
               
          xmlwriter_end_element($xw); // row1

          $row = $result->fetch_array(MYSQLI_BOTH);
          $count++;
     }

     // A processing instruction
     xmlwriter_start_pi($xw, 'php');
     xmlwriter_text($xw, '$foo=2;echo $foo;');
     xmlwriter_end_pi($xw);

xmlwriter_end_document($xw);

echo xmlwriter_output_memory($xw);

?>