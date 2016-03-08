<html lang="en">

<?php
	session_start();// Start the session before you write your HTML page
?>
<?php
  include ("inventory.php");
	include ("header.php");
?>


<?php

	function redirect($url, $statusCode = 303)
	{
		 header('Location:' . $url, true, $statusCode);
		 die();
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

	function checkLabel($input)
	{
		if (empty($input))
		{
			return false;
		}

		return true;

	}

	function checkCreditCard($card)
	{
		if (preg_match('/^[0-9]{16}$/',$card))
		{
			return true;
		}

		return false;
	}


	$nameErr = $emailErr = $parentErr = $phoneErr = $websiteErr = $creditErr = $schoolErr = "";

	if ($_SERVER["REQUEST_METHOD"] == "POST") {


		$valid = true;

		if (!checkLabel($_POST["nameField"])) {
			$nameErr = "Name is required";
			$valid = false;

		}

		else {
			$childName = $_POST['nameField'];

		}

		if (!checkLabel($_POST["parentField"])) {
			$parentErr = "Parent name is required";
			$valid = false;

		}

		else {
  		$parentName = $_POST['parentField'];
		}

		if (!checkEmail($_POST["parentEmail"])) {
			$emailErr = "Invalid email input";
			$valid = false;

		}

		else {
			$email = $_POST['parentEmail'];
		}

		if (!checkPhone($_POST["phoneField"])) {
			$phoneErr = "Invalid Phone Input";
			$valid = false;

		}

		else {
			$phone = $_POST['phoneField'];
		}

		if (!checkCreditCard($_POST["paymentField"])) {
			$creditErr = "Credit Crd is invalid";
			$valid = false;

		}

		else {
			$creditCard = $_POST['paymentField'];
		}

		if (!checkLabel($_POST['schoolField']))
		{
			$schoolErr = "School Error";
			$valid = false;

		}
		else {
			$school = $_POST['schoolField'];

		}

		// $month = $_POST['monthBox'];
    // $day = $_POST['dayBox'];
    // $year = $_POST['yearBox'];

    $weeks = $_POST['weekBox'];
    $grade = $_POST['gradeBox'];
    $instructions = $_POST['specialInstructions'];

		if ($valid == true)
		{
			$personalInfo = array(
	      'name' => $childName,
	      'parentName' => $parentName,
	      'email' => $email,
	      'phone' => $phone,
	      'school' => $school,
	      'grade' => $grade,
	      'instructions' => $instructions
	    );

	    $paymentInfo = array(
	      'creditCard' => $creditCard,
	      'weeks' => $weeks,
	      'price' => '$100'
	    );


		  $dateString = $month + $day + $year;

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
		    $sql="INSERT INTO Students (name, parentName, parentEmail, parentPhone, grade, school, specialInstructions, creditCard, duration) VALUES ('$childName', '$parentName', '$email', '$phone', $grade, '$school', '$instructions', '$creditCard', $weeks)";
		    // $sql="INSERT INTO Students (name) VALUES ('$childName')";

		    // $sql = "INSERT INTO STUDENTS (name)  VALUES('manny')";
		    if ($con->query($sql) === TRUE) {

		      // echo "<table class = \"table table-bordered\">";
		      // echo "<caption>Personal Information</caption>";
					//
					//
		      // echo "<tbody>";
					//
		      // foreach ($personalInfo as $key => $value) {
		      //   echo "<tr>";
		      //   echo "<td> $key </td>";
		      //   echo "<td> $value </td>";
		      //   echo "</tr>";
		      // }
					//
					//
		      // echo "</tbody>";
		      // echo "</table>";
					//
					//
		      // echo "<table class = \"table table-bordered\">";
		      // echo "<caption> Payment Information </caption>";
					//
		      // echo "<tbody>";
					//
		      // foreach ($paymentInfo as $key => $value) {
		      //   echo "<tr>";
		      //   echo "<td> $key </td>";
		      //   echo "<td> $value </td>";
		      //   echo "</tr>";
		      // }
					//
					//
		      // echo "</tbody>";
		      // echo "</table>";

					// redirect("completeRegistration.php?checkout");
					$_SESSION['personalInfo'] = $personalInfo;
					$_SESSION['paymentInfo'] = $paymentInfo;

					echo "<script type='text/javascript'>window.top.location='completeRegistration.php';</script>"; exit;



		    } else {
		      echo "Error: " . $sql . "<br>" . $con->error;
		    }

		    $con->close();
				// die();


		}


	}

	else
	{


	}

?>


  <body>


		<div class="container">
        <div class="jumbotron">
          <h1>Sign up!</h1>

					<?php

  					if (isset($_SESSION['user']))
						{
							echo "<p><strike>$100</strike> $90 a week!</p>";
							echo "<p>Welcome back " . $_SESSION['user'] . ". Since you have aleady registered, you get a 10% discount for your next order!</p>";
						}

						else
						{
							echo "<p>\$100.00 a week!</p>";
							echo "<p>Be a part of the greatest summer camp ever!  Sign up below or login <a href=\"login.php\">here</a> to get your discount!</p>";
						}


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
						 $sql="SELECT * FROM Camps";
						 $result = $con->query($sql);
						 if (!$result)
						 {
							 die('Error: ' . mysqli_error($con));
						 }

						 $camps = array();


						 echo "<table class = \"table table-bordered\">";
						 echo "<caption>Locations</caption>";

							echo"<thead>";
							echo "<tr>";
							echo "<th>Location</th>";
							echo "<th>Start Date</th>";
							echo "<th>End Date</th>";
							echo "<th>Activities</th>";
							echo "</tr>";
							echo "</thead>";
						 echo "<tbody>";

						 while($row = mysqli_fetch_assoc($result))
						 {
							 array_push($camps, $row);

							 echo "<tr>";
							 echo "<td>" . $row['location'] . "</td>";
							 echo "<td>" . $row['startDate'] . "</td>";
							 echo "<td>" . $row['endDate']. "</td>";
							 echo "<td>" . $row['description'] . "</td>";
							 echo "</tr>";

						 }

						 echo "</tbody>";
						 echo "</table>";

						 mysql_close($con);


					 ?>


           </div>




          <div class="row" >
            <div class="col-sm-2">
            </div>
            <div class="col-sm-8" id="form_wrapper">

            <!-- <form action="completeRegistration.php"> -->
						<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <fieldset class="form-group">
                <label for="exampleInputEmail1">Child's full name</label>
								<span style="color:red;" class="error"><?php echo $nameErr;?></span>
                <input type="email" class="form-control" name="nameField" placeholder="John Doe">
            </fieldset>

            <fieldset class="form-group">
              <select class="form-control" id="month" name="monthBox">
                <option>January</option>
                <option>February</option>
                <option>March</option>
                <option>April</option>
                <option>May</option>
                <option>June</option>
                <option>July</option>
                <option>August</option>
                <option>September</option>
                <option>October</option>
                <option>November</option>
                <option>December</option>
              </select>


              <select class="form-control" id="day" name="dayBox">
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
                <option>6</option>
                <option>7</option>
                <option>8</option>
                <option>9</option>
                <option>10</option>
                <option>11</option>
                <option>12</option>
                <option>13</option>
                <option>14</option>
                <option>15</option>
                <option>16</option>
                <option>17</option>
                <option>18</option>
                <option>19</option>
                <option>20</option>
                <option>21</option>
                <option>22</option>
                <option>23</option>
                <option>24</option>
                <option>25</option>
                <option>26</option>
                <option>27</option>
                <option>28</option>
                <option>29</option>
                <option>30</option>
                <option>31</option>
              </select>

              <select class="form-control" name="yearBox">
                <option>1991</option>
                <option>1992</option>
                <option>1993</option>
                <option>1994</option>
                <option>1995</option>
                <option>1996</option>
                <option>1997</option>
                <option>1998</option>
                <option>1999</option>
                <option>2000</option>
              </select>

            </fieldset>

             <fieldset class="form-group">
                <label for="exampleInputEmail1">Parent's full name</label>
								<span style="color:red;" class="error"><?php echo $parentErr;?></span>
                <input type="email" class="form-control" name="parentField" placeholder="John Doe">
                <small class="text-muted">We'll never share your email with anyone else.</small>
            </fieldset>


            <fieldset class="form-group">
                <label for="exampleInputPassword1">Parent's Email</label>
								<span style="color:red;" class="error"><?php echo $emailErr;?></span>
                <input type="email" class="form-control" name="parentEmail" placeholder="johndoe@gmail.com">
            </fieldset>

            <fieldset class="form-group">
                <label for="exampleInputPassword1">Parent's Phone Number</label>
								<span style="color:red;" class="error"><?php echo $phoneErr;?></span>
                <input type="email" pattern="^\d{4}-\d{3}-\d{4}$" class="form-control" name="phoneField" placeholder="(1)408-887-4946" required="required">
            </fieldset>

            <fieldset class="form-group">
              <label for="exampleInputPassword1">Camp Duration (Weeks)</label>
              <select class="form-control" name="weekBox">
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
                <option>6</option>
                <option>7</option>
                <option>8</option>
              </select>
            </fieldset>

            <fieldset class="form-group">
                <label for="exampleSelect1">Grade Level</label>
                <select class="form-control" name="gradeBox">
                  <option>1</option>
                  <option>2</option>
                  <option>3</option>
                  <option>4</option>
                  <option>5</option>
                </select>
            </fieldset>


            <fieldset class="form-group">
                <label for="exampleInputEmail1">School Name</label>
								<span style="color:red;" class="error"><?php echo $schoolErr;?></span>
                <input type="child" class="form-control" name="schoolField" placeholder="Enter your child's name">
            </fieldset>


						<?php

							echo "<fieldset class=\"form-group\">";
							echo "<label> Camp Location</label>";
							echo "<select class=\"form-control\" name=\"campBox\">";

							global $camps;
							foreach($camps as $row)
							{
								echo "<option> " . $row['location'] . "</option>";
							}

							echo "</select>";
							echo "</fieldset>";

						?>



          <fieldset class="form-group">
              <label for="exampleInputEmail1">Fee</label>
              <input type="email" class="form-control" placeholder="0.00 ">
              <small class="text-muted">Calculation based on duration as well as number of children enrolled</small>
          </fieldset>

          <fieldset class="form-group">
            <label for="exampleInputEmail1">Payment Information</label>
						<span style="color:red;" class="error"><?php echo $creditErr;?></span>
            <input type="email" class="form-control" name="paymentField" placeholder="Enter credit card number">
            <small class="text-muted">We'll never share this information with anyone else.</small>
        	</fieldset>


					<div class="form-group">
  					<label for="comment">Comments: Allergies, medications, etc.</label>
  					<textarea class="form-control" rows="5" id="comment" name="specialInstructions" placeholder="Allergic to peanuts, poison ivy, chocolate, etc."></textarea>
					</div>

            <button type="submit" class="btn btn-primary" onClick="checkValues()">Submit</button>

            </div>

        </form>
      </div>
      </div>

    </div>

		<?php
		  // include ("footer.php");
		?>

  </body>
</html>
