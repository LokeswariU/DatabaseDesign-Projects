<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>

    <?php
    $conn = new mysqli("localhost:8889","root","root","library");
    if ($conn -> connect_error)
    {
      die("Connection failed: " . $conn -> connect_error);
      echo ("connection failed");
    }
    else{
      echo "connected";
    }
      mysqli_close($conn);
      ?>
  </body>
</html>
