<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css" integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">

  </head>
  <body>
    <?php include "Header.php"; ?>
    <?php
    $conn = new mysqli("localhost:8889","root","root","library");
    $search = $_POST["name"];
    if(isset($_POST["submit"]))
    {
      if(!empty($_POST["name"]))
      {
        $query = explode(" ",$_POST["name"]);
        foreach($query as $text)
        {
          $tcond .= "book.Title LIKE '%".mysqli_real_escape_string($conn,$text)."%' OR ";
          $icond .= "book.ISBN LIKE '%".mysqli_real_escape_string($conn,$text)."%' OR ";
          $ncond .= "ar.Name LIKE '%".mysqli_real_escape_string($conn,$text)."%' OR ";
        }
      }
    }
    $tcond = substr($tcond ,0,-4);
    $icond = substr($icond ,0,-4);
    $ncond = substr($ncond ,0,-4);

    $myquery = "SELECT book.ISBN,book.Title,book.availability,GROUP_CONCAT(ar.Name SEPARATOR ',') FROM book INNER JOIN ar ON book.ISBN = ar.ISBN WHERE book.Title LIKE '%$search%' OR book.ISBN LIKE '%$search%' OR ar.Name LIKE '%$search%' OR $tcond OR $icond OR $ncond GROUP BY book.ISBN;";

    $result = mysqli_query($conn,$myquery);
    if (mysqli_num_rows($result) > 0)
    {
      echo("</br></br>"."<table border = 2px><tr><th>ISBN</th><th>Title</th><th>Author_Name</th><th>Availability</th><th>Check_OUT</th></tr>");
      while($row = mysqli_fetch_assoc($result))
      {
        echo ("<tr><td>".$row["ISBN"]."</td><td>".$row["Title"]."</td><td>".$row["GROUP_CONCAT(ar.Name SEPARATOR ',')"]."</td><td>".$row["availability"]."</td><td>"."<button name = 'check_out' class='btn btn-success' onclick='Go to library.php'><a href='checkout.php?id=".$row["ISBN"].'&name='.$row["Name"]."'>CHECK OUT</a></button>
"."</td></tr>");

        }
      echo ("</table>");
      }
    else
      {
        echo ("</br>"."No Books found with ".$_POST["name"]." keyword");
      }
    ?>
  </body>
</html>
