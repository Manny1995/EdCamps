<?php
  session_start();// Start the session before you write your HTML page
  include("header.php");
?>


<?php

  function processInput()
  {

    $personalInfo = $_SESSION['personalInfo'];
    $paymentInfo = $_SESSION['paymentInfo'];


      echo "<table class = \"table table-bordered\">";
      echo "<caption>Personal Information</caption>";
      // echo "<thead>
      // 	 <tr>
      // 			<th>Item</th>
      // 			<th>Quantity</th>
      // 			<th>Subtotal</th>
      // 	 </tr>
      // </thead>
      echo "<tbody>";


      // print_r($currentRow);

      foreach ($personalInfo as $key => $value) {
        echo "<tr>";
        echo "<td> $key </td>";
        echo "<td> $value </td>";
        echo "</tr>";
      }


      echo "</tbody>";
      echo "</table>";


      echo "<table class = \"table table-bordered\">";
      echo "<caption> Payment Information </caption>";
      // echo "<thead>
      // 	 <tr>
      // 			<th>Item</th>
      // 			<th>Quantity</th>
      // 			<th>Subtotal</th>
      // 	 </tr>
      // </thead>
      echo "<tbody>";


      // print_r($currentRow);

      foreach ($paymentInfo as $key => $value) {
        echo "<tr>";
        echo "<td> $key </td>";
        echo "<td> $value </td>";
        echo "</tr>";
      }


      echo "</tbody>";
      echo "</table>";

      unset($_SESSION['personalInfo']);
      unset($_SESSION['paymentInfo']);

    }


    processInput();

 ?>


<!-- <?php
  error_reporting(E_ALL);
  $db_host = "localhost";
  $db_user = "root";
  $db_pass = "root";
  $db_name = "EdCamps";
  $con = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
  // Check connection
  if (mysqli_connect_errno())
  {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

 if (isset($_GET['login']))
 {
   handleLogin();
 }

 elseif (isset($_GET['nameField']))
 {
   processInput();
 }

  mysql_close($con);

?> -->
