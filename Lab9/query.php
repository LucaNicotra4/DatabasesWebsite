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

        //row: actor id, actor, count
        $actors = array();
        $actorIDs = array();
        $result = $conn->query($sql);
        $row = $result->fetch_array(MYSQLI_BOTH);
        $actorIDs[0] = $row[0];
        $actors[0] = $row[1];
        $row = $result->fetch_array(MYSQLI_BOTH);
        $actorIDs[1] = $row[0];
        $actors[1] = $row[1];
        $row = $result->fetch_array(MYSQLI_BOTH);
        $actorIDs[2] = $row[0];
        $actors[2] = $row[1];
        $result->close();


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

        //category_id, name, count
        $categories = array();
        $result = $conn->query($sql);
        $row = $result->fetch_array(MYSQLI_BOTH);
        $categories[0] = $row[1];
        $row = $result->fetch_array(MYSQLI_BOTH);
        $categories[1] = $row[1];
        $row = $result->fetch_array(MYSQLI_BOTH);
        $categories[2] = $row[1];
        $result->close();

        //query ids of all rented movies
        $sql = "SELECT f.film_id FROM film f
        JOIN inventory i ON f.film_id = i.film_id
        JOIN rental r ON i.inventory_id = r.inventory_id
        JOIN customer c ON r.customer_id = c.customer_id
        WHERE c.customer_id = 1;";

        //film_id
        $films = array();
        $result = $conn->query($sql);
        $row = $result->fetch_array(MYSQLI_BOTH);
        $count = 0;
        while(isset($row)){
            $films[$count] = $row[0];
            $count++;
            $row = $result->fetch_array(MYSQLI_BOTH);
        }

        //printing by actor
        for($j = 0; $j < 3; $j++){
            //flim_id, title, description, rating
            $sql="SELECT f.film_id, f.title, f.description, f.rating FROM film f
            JOIN film_actor fa ON f.film_id = fa.film_id
            JOIN actor a ON fa.actor_id = a.actor_id
            WHERE a.actor_id = $actorIDs[$j];";

            $result = $conn->query($sql);
            echo "<h1>Films Starring ".$actors[$j].",</h1>";
            for($i = 0; $i < 3; $i++){
                $row = $result->fetch_array(MYSQLI_BOTH);
                //check to see if first recommendation has already been rented
                while(in_array($row[0], $films)){
                    $row = $result->fetch_array(MYSQLI_BOTH);
                }
                echo "<p>".$row[1].": ".$row[2].". RATING: ".$row[3]."</p>";
            }
            
        }


     }else{
          echo "Invalid Login";
     }
     
}

?>