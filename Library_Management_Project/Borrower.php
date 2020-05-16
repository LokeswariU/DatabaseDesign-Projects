<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php include "Header.php"; ?>
    <?php
    $conn = new mysqli("localhost:8889","root","root","library");
    $id_query = "SELECT Card_ID FROM borrower ORDER BY Card_ID DESC LIMIT 1;";
    $res = mysqli_query($conn,$id_query);
    while($row = mysqli_fetch_assoc($res))
    {
      $lastID = $row["Card_ID"]+1;
    }
    ?>
    <form  method="get">
    <label name = "cardid"> Your CardID is:</label>
    <?php echo ($lastID); ?>
    <br/>
    <label name = "sn">SSN</label>
    <input name = "ssn" type ="text" class = "form-control" required autocomplete="off" placeholder = "SSN...."/>
    <br/>
    <label name = "name">Bname</label>
    <input name = "bname" type ="text" class = "form-control" required autocomplete="off" placeholder = "Borrower Name...."/>
    <br/>
    <label name = "addr">Address</label>
    <input name = "address" type ="text" class = "form-control" required autocomplete="off" placeholder = "Borrower Address...."/>
    <br/>
    <label name = "Stat">State</label>
    <input name = "State" type ="text" class = "form-control" required autocomplete="off" placeholder = "Borrower State...."/>
    <br/>
    <label name = "Cit">City</label>
    <input name = "City" type ="text" class = "form-control" required autocomplete="off" placeholder = "Borrower City...."/>
    <br/>
    <label name = "num">Phone Number</label>
    <input name = "phone" type ="text" class = "form-control" placeholder = "Borrower Phone Number..."/>
    <br/>
    <input type = "submit" class = "btn btn-success btn-lg" name = "submit" value="Register"/>
    <br/>
    <br/>
    <?php

    if($_GET["submit"])
    {
      $ssn = $_GET["ssn"];
      $check = "SELECT ssn FROM borrower WHERE ssn LIKE '$ssn';";
      $ch = mysqli_query($conn,$check);
      if (!(mysqli_fetch_assoc($ch)))
      {
        $ssn = $_GET["ssn"];
        $name = $_GET["bname"];
        $address = $_GET["address"];
        $state = $_GET["State"];
        $city = $_GET["City"];
        $addr = $address.",".$state.",".$city;
        $phone = $_GET["phone"];
        $in_query = "INSERT INTO borrower VALUES('$lastID','$ssn','$name','$addr','$phone',NULL);";
        $res1 = mysqli_query($conn,$in_query);
        if ($res1)
        {
          echo ("Borrower Added Succesfully");
        }
        else
        {
          echo (" Enter Valid Details");
        }
      }
      else {
        echo (" Your SSN is already been registered as Borrower");
      }
      }
    ?>
  </form>

  </body>
</html>
