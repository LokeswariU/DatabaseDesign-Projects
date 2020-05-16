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
    $conn = new mysqli("localhost:8889","root","root","library");
    $check_q = "SELECT max(Loan_ID) FROM book_loans;";
    $loan_id = mysqli_query($conn,$check_q);
    while($row = mysqli_fetch_assoc($loan_id))
    {
      if($row["max(Loan_ID)"] == NULL)
      {
        echo($row["max(Loan_ID)"]);
        $L_ID = 1;
      }
      else{
        $L_ID = $row["max(Loan_ID)"]+1;
      }
    }
    $d_out = (date('Y/m/d'));
    $d_due =  date('Y-m-d', strtotime($d_out. ' + 14 days'));
    ?>
  <form method = "post">
    <center>
    <label name = "name"> The ISBN number of the booked selected : </label>
    <?php    $id = $_GET['id'];
    $Aname = $_GET['name'];
    echo($id);
    ?>
  </br>
    <label name = "name"> The Author Name of the booked selected : </label>
    <?php echo($Aname); ?>
    </br>
    <label name = "name">Your Loan ID number is: </label>
    <?php echo ($L_ID); ?>
     </br>
       <label name = "name"> Enter the Borrower Details to Check Out</label>
       <input name = "card" type ="text" class = "form-control" placeholder = "Card ID..."/>
       <br/>
       <input type = "submit" class = "btn btn-success btn-lg" name = "submit" value="Check OUT"/>
       <br/>
     </center>
     <?php
     $card = $_POST["card"];
     $num_query = "SELECT num FROM borrower WHERE Card_ID ='$card';";
     $get_num = mysqli_query($conn,$num_query);
     $num = 0;
     if ($nrow = mysqli_fetch_assoc($get_num))
     {
       if($nrow["num"] == NULL)
       {
         $num = 1;
       }
       else{
         $num = $nrow["num"] +1;
       }
     }

     if ($_POST["submit"])
       {
         if($nrow["num"] < 3)
         {
         $check_q = "SELECT availability FROM book WHERE ISBN = $id and availability = 'YES' ;";
         $check = mysqli_query($conn,$check_q);
         if($row = mysqli_fetch_assoc($check))
         {
           if($row["availability"]=="YES")
            {
             $ins_query = "INSERT INTO book_loans VALUES('$L_ID','$id','$card','$d_out','$d_due',NULL,'$Aname');";
             $loan = mysqli_query($conn,$ins_query);
             if($loan)
             {
               $update_q = "UPDATE book SET availability ='NO' WHERE ISBN = '$id';";
               $no_books = "UPDATE borrower SET num = '$num' WHERE Card_ID = '$card';";
               $num_books =mysqli_query($conn,$no_books);
               $avail = mysqli_query($conn,$update_q);
               if($avail)
               {
                echo("Check OUT successful");
              }}
            else {
               echo("Enter a Valid Card ID");
             }}}
          else{
             echo("The Book is already checked OUT");
           }}
         else{
           echo("This Card_ID: ".$card ." Borrower exceeds three Book Loans");
       }}
      ?>
     </form>
  </body>
</html>
