<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>
    </title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css" integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">
    <style>

  .tab {
  overflow: hidden;
  border: 1px solid #ccc;
  background-color: #f1f1f1;
}
  .navbar {
  width: 100%;
  background-color: #555;
  overflow: auto;
}

.navbar a {
  float:left;
  text-align:justify;
  padding: 12px;
  color: white;
  text-decoration: none;
  font-size: 17px;
}
  .tab button {
  background-color: inherit;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  transition: 0.3s;
}
  .tab button:hover {
  border-top: : solid blue;
  border-left: solid blue;
  border-right: solid blue;
  border-bottom: solid blue;
   background-color: #777799;
  }
  .tab button.active {
    background-color: #99999;
  }

  </style>
  </head>
  <body>
    <div>
    <center>  <h1> UTD Library Webpage </h1> </center>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <div class="navbar">
      <a class="active" href="#"><i class="fa fa-fw fa-home"></i> Home</a>
    </div>
    <div class = "tab">
      <button class="tablinks" onclick="Go to library.php"><a href='Library.php'>Search Books</a></button>
      <button class="tablinks" onclick="Go to library.php"><a href="Book_loans.php">Book_loans</a></button>
      <!--<button class="tablinks" onclick="Go to library.php"><a href="checkout.php">CheckOUT</a></button>-->
      <button class="tablinks" onclick="Go to library.php"><a href="Checkin.php">CheckIN</a></button>
      <button class="tablinks" onclick="Go to library.php"><a href="Borrower.php">Borrower</a></button>
      <button class="tablinks" onclick="Go to library.php"><a href="fines.php">Fines</a></button>
  </div>
  </div>
  </body>
</html>
