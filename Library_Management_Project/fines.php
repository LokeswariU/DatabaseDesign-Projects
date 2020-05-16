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
    <form method="post">
      <center>
        <br/>
      <input type = "submit" class = "btn btn-success btn" name = "refresh" value="Update Fine"/>
      <br/>
      <br/>
      <label name = "cd">Enter the Card ID to find your Loan amount</label>
      <input name = "card" type ="text" class = "form-control" placeholder = "CARD ID...."/>
      <br/>
      <input type = "submit" class = "btn btn-success btn" name = "submit" value="View Fine"/>
      <br/>
      <br/>
    <?php
    if($_POST["refresh"])
    {
      $conn = new mysqli("localhost:8889","root","root","library");
      $new = "SELECT Loan_ID,date_in,due_date FROM book_loans;";
      $newquery = mysqli_query($conn,$new);
      if(mysqli_num_rows($newquery)>0)
      {
        while($row = mysqli_fetch_assoc($newquery))
        {
          $lid = $row["Loan_ID"];
          $din = $row["date_in"];
          $due = $row["due_date"];
          if(is_null($din))
          {
          $diff = strtotime(date('Y/m/d')) - strtotime($due);
          $diff =  round($diff / 86400);
          if($diff < 0)
          {
            $diff = 0;
          }
          else{
            $diff = $diff *(0.25);
          }}
          else if($din < $due)
          {
           $diff = NULL;
          }
          else
          {
            $diff = strtotime($din) -strtotime($due);
            $diff =  abs(round($diff / 86400));
            $diff = $diff *(0.25);
            }
          $paid = 0;
          $check = "SELECT Loan_ID,Paid from fines WHERE Loan_ID = '$lid' and Paid = '0';";
          $ch_q = mysqli_query($conn,$check);
          $crow = mysqli_fetch_assoc($ch_q);
          if(is_null($crow))
          {
            $query = "INSERT INTO fines VALUES('$lid','$diff','$paid');";
            $disp = mysqli_query($conn,$query);
            if(mysqli_num_rows($disp)>0)
            {
              echo("Fines updated");
            }}
          else{
            $up_query = "UPDATE fines SET Fine_AMT = '$diff' WHERE Loan_ID = '$lid';";
            $upd_q = mysqli_query($conn,$up_query);
          }}
      }
      $Tsum = "SELECT sum(fines.Fine_AMT),book_loans.Card_ID FROM book_loans INNER JOIN fines ON book_loans.Loan_ID = fines.Loan_ID  WHERE fines.Paid = '0' GROUP BY book_loans.Card_ID;";
      $tsumq = mysqli_query($conn,$Tsum);
      if (mysqli_num_rows($tsumq) > 0)
      {
        echo("</br></br>"."<table border = 2px><tr><th>Card_ID</th><th>SUM</th></tr>");
        while($row = mysqli_fetch_assoc($tsumq))
        {
          echo ("<tr><td>".$row["Card_ID"]."</td><td>".$row["sum(fines.Fine_AMT)"]."</td></tr>");
        }
        echo ("</table>");
      }
    }
    if($_POST["submit"])
    {
      $conn = new mysqli("localhost:8889","root","root","library");
      $card = $_POST['card'];
      $sum = "SELECT sum(fines.Fine_AMT),book_loans.Card_ID FROM book_loans INNER JOIN fines ON book_loans.Loan_ID = fines.Loan_ID WHERE Card_ID = '$card' and fines.Paid = '0' GROUP BY book_loans.Card_ID;";
      $sumq = mysqli_query($conn,$sum);
      $srow = mysqli_fetch_assoc($sumq);
      $getq = "SELECT fines.Loan_ID,book_loans.ISBN,fines.Fine_AMT,fines.Paid FROM book_loans INNER JOIN fines ON book_loans.Loan_ID = fines.Loan_ID WHERE book_loans.Card_ID LIKE '$card';";
      $getquery = mysqli_query($conn,$getq);
      $row = mysqli_fetch_assoc($getquery);
      if($row["Paid"] == '0'){
        echo("The total amount of fine to be paid by " .$card. " is: ".$srow['sum(fines.Fine_AMT)']);
        if (mysqli_num_rows($getquery) > 0)
        {
          echo("</br></br>"."<table border = 2px><tr><th>Loan_ID</th><th>ISBN</th><th>Fine_Amount</th><th>Paid</th><th>PAYMENT</th></tr>");
          $getquery = mysqli_query($conn,$getq);
          while($row = mysqli_fetch_assoc($getquery))
          {
            if($row["Paid"]=='0'){
            $pid = $row["Loan_ID"];
            echo ("<tr><td>".$row["Loan_ID"]."</td><td>".$row["ISBN"]."</td><td>$".$row["Fine_AMT"]."</td><td>".$row["Paid"]."</td><td>"."<button name = 'mypay' class='btn btn-success' value = '$pid' onclick = 'mypay($pid)'>PAY</button>"."</td></tr>");
          }}
          echo ("</table>");
        }}
      else {
        echo("You have no dues");
      }}
     ?>
      <?php
      if(isset($_POST['mypay'])){
        $pid = $_POST['mypay'];
        $conn = new mysqli("localhost:8889","root","root","library");
        $loan = "SELECT date_in FROM book_loans WHERE Loan_ID = '$pid';";
        $loanq = mysqli_query($conn,$loan);
        $lrow = mysqli_fetch_assoc($loanq);
        if(is_null($lrow["date_in"]))
        {
          echo("Check In the borrowed booked before payment");
        }
        else{
          $update = "UPDATE fines SET Paid = '1' WHERE Loan_ID = '$pid';";
          $upq = mysqli_query($conn,$update);
          $urow = mysqli_fetch_assoc($upq);
          echo("Fine Paid");
        }}
        ?>

   </center>
  </form>
  </body>
</html>
