<head>

  <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="js/bootstrap.min.js"></script>

</head>

<?php
session_start();	// Start the session before you write your HTML page
?>
<?php
    include ("inventory.php");
    include ("header.php");
 ?>

 <?php
 	// get the current quantities from inventory.
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

      global $widgets;
      global $prices;
      $widgets = array();

    while($row = mysqli_fetch_assoc($result)) {
      // $widgets[$row['id']] = $row['Quantity'];
      $widgets[$row['id']] = $row['name'];
      $prices[$row['id']] = $row['price'];

    }
    mysql_close($con);
 ?>

 <?php
    function addToCart()
    {

      global $widgets;
      $addItemId = $_GET['add'];

    	if (isset($_SESSION['cart'])){
    		$mycart = $_SESSION['cart'];

    		// if the item already exists, increment the count
    		if (isset($mycart[$addItemId])){
    			$mycart[$addItemId]+= 1;
    		}
    		// if the item does not exist, add it to the cart
    		else{
    			$mycart[$addItemId] = 1;
    		}
    	}
    	else{
    		// cart does not exist, create one
    		$mycart = array();
    		$mycart[$addItemId] = 1;
    	}
      $_SESSION['cart'] = $mycart;
    	echo "$widgets[$addItemId] added to cart <br/>";
      echo "<td><a href=\"catalog.php" . "\" class=\"btn btn-primary\">Return to Cart</a></td>";
    }

    // This function displays the contents of the shopping cart
    function show_cart() {
    	global $widgets;
        if (isset($_SESSION['cart'])){
    		echo "Your Shopping Cart has the following items so far:<br/>";
    		$mycart = $_SESSION['cart'];
    		foreach ($mycart as $key => $value){
    		if ($value >0)
    		    // get the full widget name from the widgets array;
    			$fullname = $widgets[$key];
    			print("$fullname = $value"."<a href="."viewCart.php?drop=$key".
    			">    Remove</a><br/>");
    		}
    	}
    	else {
    		echo "No items in the cart";
    	}

      echo "<a href=\"catalog.php\">Return to the Catalog</a><br/>";
      $_SESSION['cart'] = $mycart;
    }

    // This function removes an item from the shopping cart
    function drop() {

    	 if (isset($_GET['drop'])){
    	 	$dropItemId = $_GET['drop'];
    		if (isset($_SESSION['cart'])){
    			$mycart = $_SESSION['cart'];

                $dropCount = $mycart[$dropItemId];
                $dropCount--;
                if ($dropCount == 0)
                {
                    unset ($mycart[$dropItemId]);
                }

                else
                {
                   $mycart[$dropItemId] = $dropCount;
                }

    			$_SESSION['cart'] = $mycart;
    		}

        echo "Successully dropped $mycart[$dropItemId]";
    	  echo "<td><a href=\"catalog.php" . "\" class=\"btn btn-primary\">Return to Store</a></td>";

    	}
    }

    function clearCart(){
    	if (isset($_GET['clear']))
      {
    	 	if (isset($_SESSION['cart']))
        {
    			unset($_SESSION['cart']);
    	  }
    		echo "Shopping Cart Cleared ";
        echo "<td><a href=\"catalog.php" . "\" class=\"btn btn-primary\">Return to Store</a></td>";
    	}
    }


    function checkout()
    {
      show_cart();
      echo "Are you sure you want all this?";
      echo "<a href=\"viewCart.php?confirm\">Confirm Purchase<\a>";
    }

    function confirm()
    {
      $mycart = $_SESSION['cart'];
      $isValid = true;

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
        return;
      }

      foreach ($mycart as $key => $value)
      {
        $sql = "SELECT * FROM Catalog WHERE id='$key'";
        $result = $con->query($sql);
        if ($result)
        {
          $row = mysqli_fetch_assoc($result);
          if (($row['quantity'] - $value) < 0)
          {
            echo "Error buying " . $row['id'] . " Not enough inventory<br>";
            $isValid = false;
          }

        }
        else
        {
          echo "Error: " . $sql . "<br>" . $con->error;
        }
      }

      if ($isValid == true)
      {
        foreach ($mycart as $key => $value)
        {
          $sql = "SELECT * FROM Catalog WHERE id='$key'";
          $result = $con->query($sql);
          if ($result)
          {
            $row = mysqli_fetch_assoc($result);
            $newValue = $row['quantity'] - $value;
            $sql="UPDATE Catalog SET quantity='$newValue' WHERE id='$key'";
            $con->query($sql);
          }
        }
      }

      $con->close();
      echo "Finished everything!";
    }

    function destroy()
    {

    }
  ?>


 <?php
 	// if user has chosen "add"
 	if ( isset($_GET['add'])) {
 		addToCart();
 		unset($_GET['add']);
 	}
 	// if user has chosen "show cart"
 	elseif (isset($_GET['show'])){
 		show_cart();
 		unset($_GET['show']);
 	}
 	// if user has chosen "clear cart"
 	elseif (isset($_GET['clear'])){
 		clearCart();
 		unset($_GET['clear']);
 	}
 	// if user has chosen "remove item from cart"
 	elseif (isset($_GET['drop'])){
 		drop();
 		unset($_GET['drop']);
 	}// if user has chosen "remove item from cart"
 	elseif (isset($_GET['checkout'])){
 		if (isset($_SESSION['user'])) {
 			checkout();
 			unset($_GET['checkout']);
 		} else {
      // $_SESSION['inStore'] = true;
 			echo "You need to <a href=\"registration.php\">register</a> or <a href=\"login.php\">login</a> in!<br>";
 		}
 	}
 	elseif (isset($_GET['confirm'])) {
 		confirm();
 		unset($_GET['confirm']);
 	}
 ?>

<?php
  include ("footer.php");
?>
