
<?php
	session_start();// Start the session before you write your HTML page
?>
<?php
  include ("inventory.php");
	include ("header.php");
?>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>Bootstrap 101 Template</title>


  <!-- Bootstrap -->

    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</head>
<body>

  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="js/bootstrap.min.js"></script>


  <div class="container">


    <?php // Get the catalog items from the database
      ini_set('display_errors','On');
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
      $sql="SELECT * FROM Catalog";

      $result = $con->query($sql);
      if (!$result)
      {
        die('Error: ' . mysqli_error($con));
      }
      else {

        $count = 0;

        echo "<div class=\'row\">";
				echo "<table class = \"table borderless\">";

				echo "<thead>
					 <tr>
							<th>Item</th>
							<th>Price</th>
					 </tr>
				</thead>";
				echo "<tbody>";

        while($currentRow = mysqli_fetch_assoc($result)) {

            // print_r($currentRow);
              $imgSrc = $currentRow['id'];

							echo "<tr>";
              echo "<td>" . $currentRow['name'] . "</td>";
							echo "<td> $" . $currentRow['price'] . "</td>";
              echo "<td> <img src=" . $imgSrc . "alt=" . $currentRow['name'] . "/> </td>";
              echo "<td><a href=\"viewCart.php?add=" . $currentRow['id'] . "\">Add To Cart</a></td>";
							echo "</tr>";
        }

				echo "</tbody>";
				echo "</table>";
        echo "</div>";
				echo "<div>";

				echo "<a href=\"viewCart.php?show\">View Cart</a><br>";
				echo "<a href=\"viewCart.php?drop\">Clear Cart</a><br>";
				echo "<a href=\"viewCart.php?checkout\">Checkout</a><br>";
				echo "</div>";
      }

    ?>

  </div>

	<?php
	  include ("footer.php");
	?>
</body>
