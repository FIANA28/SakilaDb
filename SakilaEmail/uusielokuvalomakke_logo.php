<?php

include "connectdb.php";
// define variables and set to empty values
//määritä muuttujat ja aseta tyhjät arvot
$titleErr = $descriptionErr = $language_idErr = $rental_durationErr = $rental_rateErr = $lengthErr = $replacement_costErr = $ratingErr = $special_featuresErr = "";
$title = $description = $language_id = $rental_duration = $rental_rate = $length = $replacement_cost = $rating = $special_features = $checkbox1 = "";


//error checking  / w3school polku
if ($_SERVER['REQUEST_METHOD'] == "POST"){
  if (empty($_POST["title"])) {
    $titleErr = "Title is required";
  } else {
    // varchar(128)
    $title = test_input($_POST["title"]);
     // check if title is well-formed
    //  if(strlen($title > 128)) {
    //     $titleErr = "Please enter not more than 128 characters";
    //  }
    }
  
  if (empty($_POST["description"])) {
    $descriptionErr = "Description is required";
  } else {
    $description = test_input($_POST["description"]);
  }

  if (empty($_POST["language_id"])) {
    $language_idErr = "Language is required";
  } else {
    $language_id = test_input($_POST["language_id"]);
  }

  if (empty($_POST["rental_duration"])) {
    $rental_durationErr = "Rental duration is required";
  } else {
    // tinyint(3)
    $rental_duration = test_input($_POST["rental_duration"]);
    }

  if (empty($_POST["rental_rate"])) {
        $rental_rateErr = "Rental rate is required";
      } else {
        $rental_rate = test_input($_POST["rental_rate"]);
        // decimal(4,2)
        if (!preg_match("/^(?:\d{0,4}\.\d{1,2})$|^\d{0,4}$/",$rental_rate)) {
            $rental_rateErr = "Only positive numbers are allowed. Please use given format";
          }
      }

      if (empty($_POST["length"])) {
        $lengthErr = "Length is required";
      } else {
        $length = test_input($_POST["length"]);
        // smallint(5) as value 
        if (!preg_match("/^.*?([0-9]+)$/",$length)) {
            $lengthErr = "Only whole numbers are allowed";
          }
      }
      if (empty($_POST["replacement_cost"])) {
        $replacement_costErr = "Cost is required";
      } else {
        $replacement_cost = test_input($_POST["replacement_cost"]);
        // decimal(5,2)
        if (!preg_match("/^(?:\d{0,5}\.\d{1,2})$|^\d{0,5}$/",$replacement_cost)) {
            $replacement_costErr = "Only positive numbers are allowed. Please use given format";
          }
      }
      if (empty($_POST["rating"])) {
        $ratingErr = "Rating is required";
      } else {
        $rating = test_input($_POST["rating"]);
      }

      if (empty($_POST['special_features'])) {
       $special_featuresErr = "Special features are required";
      } else { 
        $special_features = test_input($_POST["special_features"]);
      }
    }

    function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    return $data;
    }
?>
<?php

require 'PHPMailer.php';
require 'Exception.php';
require 'SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//adding picturefile
    // define('POST_TO',"omniakurssi@gmail.com");
    // define('POST_FROM',"omniakurssi@gmail.com");
    // define('POST_FROMNAME'," Ohjelmointikurssi");
// $emailFrom = "omniakurssi@gmail.com";
// $emailFromName = "Ohjelmointikurssi";

    // define('KUVAT', "/kuvat");
    // define('KUVA_PREFIX', "logo");
$to = "omniakurssi@gmail.com";

//function for uploading logokuva
  function tiedosto($last_id){
    $target_dir = "kuvat/";
    // $target_file = $target_dir . basename($_FILES["form_File"]["name"]);
    $target_file = $target_dir . $last_id . "_" . basename($_FILES["avatar"]["name"]);
  
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  // Check if image file is a actual image or fake image
  if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["avatar"]["tmp_name"]);
    if($check !== false) {
      echo "File is an image - " . $check["mime"] . ".";
      $uploadOk = 1;
    } else {
      echo "File is not an image.";
      $uploadOk = 0;
    }
      // Allow certain file formats
  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
  && $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
  }

  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
  // if everything is ok, try to upload file
  } else {
    if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {
      echo "The file ". htmlspecialchars( basename( $_FILES["avatar"]["name"])). " has been uploaded.";
      } else {
        echo "Sorry, there was an error uploading your file.";
      }
    }
  }
}

function posti($emailTo,$msg,$subject){
if (file_exists('/Users/annajussi/Sites/PHP/SakilaDb/tunnukset.php')) include ('/Users/annajussi/Sites/PHP/SakilaDb/tunnukset.php');  

$emailFrom = "omniakurssi@gmail.com";
$emailFromName = "Ohjelmointikurssi";
$emailToName = "";
$mail = new PHPMailer;
$mail->isSMTP(); 
$mail->CharSet = 'UTF-8';
$mail->SMTPDebug = 0; // 0 = off (for production use) - 1 = client messages - 2 = client and server messages
$mail->Host = "smtp.gmail.com"; // use $mail->Host = gethostbyname('smtp.gmail.com'); // if your network does not support SMTP over IPv6
$mail->Port = 587; // TLS only
$mail->SMTPSecure = 'tls'; // ssl is depracated
$mail->SMTPAuth = true;
$mail->Username = $smtpUsername; // "omniakurssi@gmail.com";
$mail->Password = $smtpPassword; // "kurssi123";
$mail->setFrom($emailFrom, $emailFromName);
$mail->addAddress($emailTo, $emailToName);
$mail->Subject = $subject;
$mail->msgHTML($msg); //$mail->msgHTML(file_get_contents('contents.html'), __DIR__); //Read an HTML message body from an external file, convert referenced images to embedded,
$mail->AltBody = 'HTML messaging not supported';

if(!@$mail->send()){
$tulos = false;
}else{
 $tulos = true;
}
return $tulos;
}
?>

<?php

// Insert Data Into sakila db using PHP
//Lisää tiedot sakilan tietokanta ään PHP: llä
if(isset($_POST['submit'])) {

  // inserting data from checkbox
    $checkbox1=(isset($_POST['special_features']) ? $_POST['special_features'] : array()); 

    $chk = implode(",", $checkbox1);

    $sql = "INSERT INTO film (title,`description`,language_id,rental_duration,rental_rate,`length`,replacement_cost,rating,special_features)
    VALUES ('$title', '$description', '$language_id', '$rental_duration', '$rental_rate', '$length', '$replacement_cost', '$rating', '$chk')";
    
    // if (mysqli_query($conn, $sql)) {
    //     echo '<div class="alert alert-success" role="alert">';
    //     echo "New record created successfully!";
    //     echo '</div>';
    // } else {
    //     echo '<div class="alert alert-danger" role="alert">';
    //     // echo "Error: " . $sql . " " . mysqli_error($conn);
    //     echo "Please fill in all required fields";
    //     echo '</div>';
    // }
    
            // sending lomakke to omniakurssi@gmail.com with PHPMailer
            $result = mysqli_query($conn, $sql);

            if($result == TRUE) {    
              $msg = "Elokuvan $title lisätty.";
              // posti($to,$msg,"Elokuva lisätty tietokantaan.");
              echo "<span class='success'><br><b>Elokuva lisätty tietokantaan</span><br>";    
          } else {
              echo "Elokuvan lisäys ei onnistunut";
          } 

            //uploading elokuvan logo
            $last_id = $conn->insert_id;
            tiedosto($last_id);
            echo "<span class='success'><br><b>Logokuva lisätty tietokantaan</span>";

      mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>Uusi Elokuva</title>
    <style>
    .container {
        margin-top: 100px;
    }
    .error {
        color: #FF0000;
        font-size: 0.8em;
        }
    .form_control_change {
        display: inline-block;
        width: 75px;
    }
    .look {
        color: green; 
        font-weight: bold;
    }

    #footer {
        margin-top: 100px;
    }
    </style>
</head>
<body>
    <!-- Navbar start -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Sakila</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#">Etusivu <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Linkki</a>
      </li>
      <li class="nav-item dropdown dropright">
        <a class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Elokuvia genreittäin
        </a>  
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <!-- adding connection of genre to db -->
        <?php
        $genret = array('Action', 'Animation', 'Classics', 'Documentary', 'Drama', 'Documentary', 'Drama', 'Family', 'Foreign', 'Games', 'Horror', 'Music', 'New', 'SCI-Fi', 'Sports', 'Travel');
        foreach($genret as $genre) {
        echo '<a class="dropdown-item" href="moviebygenre.php?genre='.$genre.'">'.$genre.'</a>';
        }
        ?>
        </div>
      </li>
    </ul>
  </div>
</nav>
<!-- Navbar End -->
    <div class="container">
        <h2 style="color: white; background-color: green; padding:5px 10px; margin: 0 auto;">Uusi Elokuva</h2><br>
        <form style="border: 1px solid green; padding:40px 20px 40px 40px;" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" enctype="multipart/form-data">
            <div class="form-group row">
                <label class="col-sm-3 col-form-label look">Nimi </label>
                <span class="error"><?php echo $titleErr;?></span>
                <div class="col-sm-8">
                    <input class="form-control" type="text" name="title"  maxlength="128" value="<?php echo $title;?>" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label look">Kuvaus </label>
                <span class="error"><?php echo $descriptionErr;?></span>
                <div class="col-sm-8">
                    <textarea class="form-control" type="text" rows="4" name="description" value="<?php echo $description;?>" required></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label look">Julkaisuvuosi </label>
                <span class="error"><?php echo $release_yearErr;?></span>
                <div class="col-sm-8">
                    <input class="form-cotrol text-right form_control_change" type="year" name="release_year" value="2020"><br>
                </div>
            </div>
            <div class="form-group row">
            <label class="col-sm-3 col-form-label look" for="kieli">Kieli (select)</label>
            <span class="error"><?php echo $language_idErr;?></span>
                <div class="col-sm-8">
                    <select id="kieli" class="custom-select" name="language_id" required>
                    <option type="text" value="" disabled selected>Choose option</option>
                    <option type="text" value="1">English</option>
                    <option type="text" value="2">Italian</option>
                    <option type="text" value="3">Japanese</option>
                    <option type="text" value="4">Mandarin</option>
                    <option type="text" value="5">French</option>
                    <option type="text" value="6">German</option>
                    </select>
                    <!-- <input type="text" placeholder="Add language"> -->
                </div>
                <div class="col-sm-8">
                </div>
            </div>       
            <div class="form-group row">
            <label class="col-sm-3 col-form-label look ">Vuokra-aika</label>
            <span class="error"><?php echo $rental_durationErr;?></span>
                <div class="input-group col-sm-8">
                    <input class="form-control" type="number" name="rental_duration" min="0" max="100" value="<?php echo $rental_duration;?>" required>
                    <div class="input-group-append">
                        <span class="input-group-text"> pv</span>
                    </div>
                </div> 
            </div>
            <div class="form-group row">
            <label class="col-sm-3 col-form-label look ">Vuokrahinta</label>
            <span class="error"><?php echo $rental_rateErr;?></span>
                <div class="input-group col-sm-8">
                    <input class="form-control" type="text" name="rental_rate" value="<?php echo $rental_rate;?>" required aria-label="Amount (to the nearest euro)">
                    <div class="input-group-append">
                        <span class="input-group-text">€</span>
                        <span class="input-group-text">0.00</span>
                    </div>
                </div>
            </div>
            <div class="form-group row">
            <label class="col-sm-3 col-form-label look ">Pituus</label><br>
            <span class="error"><?php echo $lengthErr;?></span>
                <div class="input-group col-sm-8">
                    <input class="form-control" type="text" name="length" value="<?php echo $length;?>" required><br>
                    <div class="input-group-append">
                        <span class="input-group-text">min</span>
                    </div>
                </div>
            </div>
            <div class="form-group row">
            <label class="col-sm-3 col-form-label look" >Korvaushinta</label><br>
            <span class="error"><?php echo $replacement_costErr;?></span>
                <div class="input-group col-sm-8">
                    <input class="form-control" type="text" name="replacement_cost" value="<?php echo $replacement_cost;?>" required><br>
                    <div class="input-group-append">
                        <span class="input-group-text">€</span>
                        <span class="input-group-text">0.00</span>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label look">Ikäraja</label><br>
                <span class="error"><?php echo $ratingErr;?></span>
                <div class="col-sm-8">
                    <div class="form-check custom-control-inline">
                        <input class="form-check-input" type="radio" name="rating" value="G" required>
                        <label class="form-check-label">G</label>
                    </div>
                    <div class="form-check custom-control-inline">
                        <input class="form-check-input" type="radio" name="rating" value="PG">
                        <label class="form-check-label">PG</label>
                    </div>
                    <div class="form-check custom-control-inline">
                        <input class="form-check-input" type="radio" name="rating" value="PG-13">
                        <label class="form-check-label">PG-13</label>
                    </div>
                    <div class="form-check custom-control-inline">
                        <input class="form-check-input" type="radio" name="rating" value="R">
                        <label class="form-check-label">R</label>
                    </div>
                    <div class="form-check custom-control-inline">
                        <input class="form-check-input" type="radio" name="rating" value="NC-17">
                        <label class="form-check-label">NC-17</label>
                    </div>
                </div>

            </div>
            <div class="form-group row">
            <label class="col-sm-3 col-form-label look">Special features</label><br>
            <span class="error"><?php echo $special_featuresErr;?></span>
                <div class="col-sm-8">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="special_features[]" value="Trailers" checked>
                        <label class="form-check-label">Trailers</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="special_features[]" value="Commentaries" checked>
                        <label class="form-check-label">Commentaries</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="special_features[]" value="Deleted Scenes" checked>
                        <label class="form-check-label">Deleted Scenes</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="special_features[]" value="Behind the Scenes" checked>
                        <label class="form-check-label">Behind the Scenes</label>
                    </div>
                </div>
            </div><br>
            <div>
                <label for="avatar" class="look">Valitse profiilikuva:</label>
                <input type="file" id="avatar" name="avatar">
            </div><br>
            <button type="submit" name="submit" class="btn btn-success">Lähetä</button>
        </form>
    </div>
        <!--Footer Start-->
        <div class="footer-copyright text-center" id="footer">
            <p>&copy;Developed by Anna</p>
        </div>
        <!-- Footer End -->
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>


