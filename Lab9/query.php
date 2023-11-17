<?php
$servername = "127.0.0.1";
$username = "webUser";
$password = "SuperSecurePasswordHere";
$schema = "sakila";

// Create connection
$conn = new mysqli($servername, $username, $password, $schema);

// Check connection
if ($conn->connect_error) {
     echo$conn->connect_error;
     die("Connection failed: " . $conn->connect_error);
}
echo"<p>Connected</p>";

//formatting page
echo "<html style='text-align:center; left-margin:auto; right-margin:auto;' >";

//form
echo "<form method='POST'>";
     //input
     echo "
          <label for='lastName'>Enter last name: </label>
          <input id='lastName' type='text' name='lastName'>
          <label for='id'>Enter ID: </label>
          <input id='id' type='text' name='id'>
          <br><br>
          <input type='submit' value='Log in' name='log-in'>
     ";
echo "</form>";

//handling form
if($_POST['log-in']){
     $lastName= $_POST['lastName'];
     $id = $_POST['id'];
     
     //execute login query, check for match
     $sql = "SELECT customer_id, last_name FROM customer WHERE customer_id = $id AND last_name = '$lastName';";
     $result = $conn->query($sql);
     $row = $result->fetch_array(MYSQLI_BOTH);

     if($row[0] == $id && $row[1] == strtoupper($lastName)){
        echo "Logged in!<br>";

        //query actor list from all rentals based on customer ID
        $sql="SELECT a.actor_id, CONCAT(a.first_name, ' ', a.last_name) AS actor, 
        COUNT(a.first_name) AS count FROM film f
        JOIN film_actor fa ON fa.film_id = f.film_id
        JOIN actor a ON fa.actor_id = a.actor_id
        JOIN inventory i ON f.film_id = i.film_id
        JOIN rental r ON i.inventory_id = r.inventory_id
        JOIN customer c ON r.customer_id = c.customer_id
        WHERE c.customer_id = $id
        GROUP BY a.actor_id
        ORDER BY count DESC;";

        //actor id, actor, count
        $result = $conn->query($sql);
        $row = $result->fetch_array(MYSQLI_BOTH);
        echo "Favorite actor: $row[1] <br>";

        //query category list from all rentals
        $sql="SELECT cat.category_id, cat.name, COUNT(cat.category_id) AS count FROM film f
        JOIN film_category fc ON fc.film_id = f.film_id
        JOIN category cat ON fc.category_id = cat.category_id
        JOIN inventory i ON f.film_id = i.film_id
        JOIN rental r ON i.inventory_id = r.inventory_id
        JOIN customer c ON r.customer_id = c.customer_id
        WHERE c.customer_id = 1
        GROUP BY cat.category_id
        ORDER BY count DESC;";

        //actor_id, actor, count
        $result = $conn->query($sql);
        $row = $result->fetch_array(MYSQLI_BOTH);
        echo "Favorite category: $row[1] <br>";

     }else{
          echo "Invalid Login";
     }
     
}

?>