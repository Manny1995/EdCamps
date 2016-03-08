<?php
  session_start();// Start the session before you write your HTML page
  include("header.php");
?>

<?php

function displayData()
{
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
  $sql="SELECT * FROM Comments";

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
          <th>Name</th>
          <th>Comment</th>
          <th>Post Date</th>
       </tr>
    </thead>";
    echo "<tbody>";

    while($currentRow = mysqli_fetch_assoc($result)) {

        // print_r($currentRow);

          echo "<tr>";
          echo "<td> " . $currentRow['name'] . "</td>";
          echo "<td>" . $currentRow['comment'] . "</td>";
          echo "<td> " . $currentRow['createdAt'] . "</td>";
          echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";
    echo "</div>";
    echo "<div>";
  }

}



?>


<?php

if (isset($_GET['done'])) {
  $name = $_POST['nameField'];
  $description = $_POST['descriptionField'];
  $date="";

  // if (isset($_SESSION['user']))
  // {
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
    $sql="INSERT INTO Comments (name, createdAt, comment) VALUES ('$name', '$date', '$description')";
    // $sql="INSERT INTO Students (name) VALUES ('$childName')";

    // $sql = "INSERT INTO STUDENTS (name)  VALUES('manny')";
    if ($con->query($sql) === TRUE) {

      // echo "<a href=\"forum.php\">Return to Forum</a>";
    }
    else {
      echo "Error: " . $sql . "<br>" . $con->error;
    }

    $con->close();
  //}
}

displayData();

?>

<!-- <form action="completeRegistration.php"> -->
<form method="post" action="forum.php?done">
  <fieldset class="form-group">
      <label for="exampleInputEmail1">Parent's name</label>
      <span style="color:red;" class="error"></span>
      <input type="email" class="form-control" name="nameField" placeholder="John Doe">
  </fieldset>

  <div class="form-group">
    <label for="comment">Feedback</label>
    <textarea class="form-control" rows="5" id="comment" name="descriptionField" placeholder="Write your experience here"></textarea>
  </div>

  <button type="submit" class="btn btn-primary" onClick="checkValues()">Submit</button>

</form>
