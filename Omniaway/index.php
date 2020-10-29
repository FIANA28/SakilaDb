<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uusi Elokuva</title>
</head>
<body>
    <?php
    include('header.php');
    $title = (isset($_POST['title']) ? $_POST ['title'] : "");
    ?>

    <form method="post" action="lomakkekasittelja.php" target="kasittelija">
    <input type="text" name="title" value="<?php echo $title;?>"></input>
    </form>

    <iframe name="kasittelija" src="" title="Online Web Tutorials"></iframe>
 <?php
 inlcude ('footer.php');
 ?>
</body>
</html>