
  
<?php
// connect to db
include "connectdb.php";
include "index.php";
$genre=trim($_GET['genre']);

$sql = "SELECT category.name, film.title FROM category JOIN film_category ON film_category.category_id = category.category_id JOIN film ON film_category.film_id = film.film_id WHERE category.name = '$genre'";
$result = $conn->query($sql);

if($result->num_rows > 0) {
   while ($row = $result->fetch_assoc() ){
       echo "<div class='card'>";
       echo "<div class='card-body'>";
       echo "<span style='color: green;'>" .$row['name']."<br>".$row['title']. "<br>";
       echo"</div>";
       echo"</div>";
    } 
}else {
    echo "0 records";
}
mysqli_close($conn); 

?>
