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
    <?php include "Header.php";
    ?>
    <form method = "post"><center>
    <label name = "searches"> Check-in by providing ISBN or Card_ID or your Name </label>
    <input name = "search" type ="text" class = "form-control" placeholder = "Search Keyword...."/>
    <br/>
    <input type = "submit" class = "btn btn-success btn-lg" name = "submit" value="Check IN"/>
    <br/>
    <?php
    if($_POST["submit"])
    {
      $search = $_POST["search"];
      $conn = new mysqli("localhost:8889","root","root","library");
      $disp = "SELECT book_loans.Loan_ID,book_loans.ISBN,book_loans.Card_ID,book_loans.date_out,book_loans.due_date FROM book_loans INNER JOIN borrower ON book_loans.Card_ID = borrower.Card_ID WHERE (book_loans.date_in IS NULL AND borrower.Card_ID LIKE '%$search%') OR (book_loans.date_in IS NULL AND book_loans.ISBN LIKE '%$search%') OR (book_loans.date_in IS NULL AND borrower.Bname LIKE '%$search%');";
      $dis = mysqli_query($conn,$disp);
      echo(mysqli_num_rows($dis));
      if (mysqli_num_rows($dis) > 0)
      {
        echo("</br></br>"."<table border = 2px><tr><th>Loan_ID</th><th>ISBN</th><th>Card_ID</th><th>Date_Out</th><th>Due_Date</th><th>Check_IN</th></tr>");
        while($row = mysqli_fetch_assoc($dis))
        {
          $id = $row["Loan_ID"];
          echo ("<tr><td>".$row["Loan_ID"]."</td><td>".$row["ISBN"]."</td><td>".$row["Card_ID"]."</td><td>".$row["date_out"]."</td><td>".$row["due_date"]."</td><td>"."<button name = 'check_in' class='btn btn-success' value = '$id' onclick='myalert($id)'>CHECK IN</button>"."</td></tr>");
          }
        echo ("</table>");
        }
      else
        {
          echo ("</br>"."No Books found with ".$_POST["search"]." keyword");
        }}
    ?>
    <script>
    function myalert(id)
    {
      var x =id;
      alert("Checked IN book of "+"Loan ID: "+x);
      }
     <?php
     if(isset($_POST['check_in'])){
       $cid = $_POST['check_in'];
        $ccid = $row["Loan_ID"];
        $d_in = (date('Y/m/d'));
        $conn = new mysqli("localhost:8889","root","root","library");
        $update_q = "UPDATE book_loans SET date_in = '$d_in' WHERE Loan_ID = '$cid';";
        $update = mysqli_query($conn,$update_q);
      } ?>
    </script>
    <br/>
  </center>
   </form>
  </body>
</html>
