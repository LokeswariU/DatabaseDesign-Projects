<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css" integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">

<style>
.header{
  border: 2px solid grey;
  border-radius: 10px;
  margin-top: 20px
}
</style>
  </head>
  <body>
    <?php include "Header.php"; ?>

    <?php
    if ($_POST["submit"])
    {
      if ($_POST["name"])
      {
        $display= "<br/><br/>List of books displayed based on your search keyword : ".$_POST["name"];
        $result = '<div class = "alert alert-success">Book Searched</div>';
      }
      else {
        $error = "<br/> Please enter the keyword for search";
      }  }
      ?>
    <form  action = "Book_loans.php" method="post">
      <div id="wrapper"><center>
    <?php echo $result; ?>
    <label name = "name"> Search for books using ISBN or Title or Author </label>
    <input name = "name" type ="text" class = "form-control" placeholder = "Search Keyword...."/>
    <br/>
    <input type = "submit" class = "btn btn-success btn-lg" name = "submit" value="Search for books"/>
    <br/>
    <?php echo $display;
      echo $error;?>
      <?php
      $conn = new mysqli("localhost:8889","root","root","library");
      if ($conn -> connect_error)
      {
        die("Connection failed: " . $conn -> connect_error);
        echo ("connection failed");
      }
      else{
        $search = $_POST["name"];
        $table = "SELECT * FROM book INNER JOIN ar ON book.ISBN = ar.ISBN;";
        $result = mysqli_query($conn,$table);
        if (mysqli_num_rows($result) > 0)
        {
          echo("</br></br>"."<table border = 2px><tr><th>ISBN</th><th>Title</th><th>Author_Name</th><th>Availability</th></tr>");
          while($row = mysqli_fetch_assoc($result))
          {
            echo ("<tr><td>".$row["ISBN"]."</td><td>".$row["Title"]."</td><td>".$row["Name"]."</td><td>".$row["availability"]."</td></tr>");
          }
          echo ("</table>");
          }
        else {
            echo ("</br>"."No Books found with ".$_POST["name"]." keyword");
          }
        }
         ?>
    </form>
      <!-- Latest compiled and minified JavaScript -->
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
</center>
    </div>
  </body>
</html>
