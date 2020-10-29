<?php

include('dbfunktiot.php');
list($arvo1, $virhe1) = inputcheck($_POST['kentta1']);
list($arvo2, $virhe2)= inputcheck($_POST['kentta2']);

$query = "SELECT * FROM film WHERE genre = '$arvo1'";
$result = mysqli_query($link, $query);

echo "<form id=\"lomake\" action=\"index.php\">"
 while ($row = mysqli_fetch_array($result, 'MYSQL_ASSOC')) {
    echo "<input type=\"hidden\" name=\"tulokset[]\" value="\".$row['title']."\"><\input>\n";
}
    foreach($virheet as $virhe) {
    echo "<input type=\"hidden\" name=\"virheet[]\" value=\"$virhe\"><\input>\n"
}

// virheitta ilmoituksia
//  <input type=\"hidden\" name=\"kentta1\" value=\"$arvo1\"><\input>\n
//  <input type=\"hidden\" name=\"kentta2\" value=\"$arvo2\"><\input>\n
 echo "</form>"
 
//  example of using JS for sumbitting form
 <script>
queryselector('#lomake').sumbit();
<script>";
?>