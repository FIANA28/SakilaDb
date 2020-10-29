<?php
session_start();

include "index.php";
include "connectdb.php";

$search = $_POST['search'];
$sql = "SELECT * FROM film WHERE title LIKE '%{$search}%'";

$result = $conn->query($sql);
//Object oriented style
if($result->num_rows > 0) {
   while ($row = $result->fetch_assoc() ){
       echo "<div class='card'>";
       echo "<div class='card-body'>";
       echo "<span style='color: green;'>Title: </span>". $row['title']."<br>". "<span style='color: green;'>Description: </span>". $row['description'] ."<br>". "<span style='color: green;'>Rating: </span>". $row['rating']."<br>". "<span style='color: green;'>Year: </span>". $row['release_year']."<br>";
       echo"</div>";
       echo"</div>";

    } 
}else {
    echo "0 records";
}
mysqli_close($conn); 

?>
<!-- print movies name, description and release year-->

<!-- connect inputs to db -->