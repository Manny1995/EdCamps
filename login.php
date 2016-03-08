
<?php

  include ("header.php");
	session_start();// Start the session before you write your HTML page
  if (isset($_SESSION['user']))
  {
  		echo "Your previous session has been logged out. <br>";
  		unset($_SESSION['user']);
  }

  if (isset($_SESSION['phone']))
  {
      unset($_SESSION['phone']);
  }
?>

<body>
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="js/bootstrap.min.js"></script>

  <div class="container">

      <form class="form-signin" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

        <h2 class="form-signin-heading">Please sign in</h2>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" id="inputEmail" class="form-control" placeholder="Child's name" name="name" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" class="form-control" placeholder="Phone Number" name="phone" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      </form>

    </div>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $name = $_POST['name'];
      $phone = $_POST['phone'];

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

      $result = $con->query("SELECT * FROM Students WHERE name='$name' AND parentPhone='$phone'");
      if (!$result)
      {
         die('Error: ' . mysqli_error($con));
      }

       $row = mysqli_fetch_assoc($result);
       if ($row)
       {
         $_SESSION['user'] = $name;
         $_SESSION['phone'] = $phone;

         if ($_SESSION['inStore'] == true)
         {
           unset($_SESSION['inStore']);
           echo "sup";
           echo "<a href=\"viewCart.php?checkout\">Continue to Checkout</a>";
         }
         else {

           echo "user exists! Successfully logged in! <br>";

         }
       }

       else {
         echo "Invalid login <br>";
       }

    }

    function checkPhone($phone)
    {

    	if (preg_match('/^[2-9]\d{9}$/',$phone)){
    		echo "Phone ok <br>";
    		return true;
    	}
    	else {
    		echo "Invalid Phone <br>";
    		return false;
    	}
    }
    function checkEmail($email)
    {
    	if (preg_match('/^(?!.{30,})(\S+@\S+\.\S+)$/',$email))
      {
    		echo "email ok <br>";
    		return true;
    	}
    	else{
    		echo "Invalid email <br>";
    		return false;
    	}
    }

    ?>
    <?php
      include ("footer.php");
    ?>
</body>
