 <?php
//define variables and set to empty values
$email = $password = $userRole = "";
//Error variable
$inputErr = "";
//Initiate database connection
include_once('connection.php');
//Start the session
session_start();

//
if($_SERVER["REQUEST_METHOD"] == "POST")
{	
	//Stored user input
	$tempEmail = test_input($_POST["inputEmail"]);
	$tempPassword = test_input($_POST["inputPassword"]);
	$sql = "SELECT * FROM users WHERE email = '$tempEmail' AND password = '$tempPassword'";
	$queryResult = mysqli_query($conn,$sql);
	
	//Check number of rows in the databse
  if(mysqli_num_rows($queryResult) == 1)
  {
    $_SESSION['login_user'] = $tempEmail; 

    //Extract user's information number from the database 
    $sqlQuery = $conn->query("SELECT * FROM users");
      
    while($row = $sqlQuery->fetch_array())
    {
      $userRole = $row['role'];
      $email = $row['email'];
      $password = $row['password'];
      $staffNo = $row['staffNo'];

      if($email == $tempEmail AND $password == $tempPassword AND $userRole == "admin")
      {
        header("Location: admin-access.php");
      }
      
      if($email == $tempEmail AND $password == $tempPassword AND $userRole == "user")
      {
        header("Location: users-access.php");
      }

    }
    
	}else{
		$inputErr = "Invalid email or password";
  }
  
  //Doctor login
	$sql = "SELECT * FROM doctor WHERE email = '$tempEmail' AND staffNo = '$tempPassword'";
	$queryResult = mysqli_query($conn,$sql);
	
	//Check number of rows in the databse
  if(mysqli_num_rows($queryResult) == 1)
  {
    //Extract user's staff number from the database 
    $sqlQuery = $conn->query("SELECT * FROM doctor");
      
    while($row = $sqlQuery->fetch_array())
    {
      $email = $row['email'];
      $staffNo = $row['staffNo'];
    
     if($email == $tempEmail) // AND $staffNo == $tempPassword
     {
      header("Location: doctor-access.php");
     }

    }
    
	}else{
		$inputErr = "Invalid email or password";
  }

  //endif
}

//check for incorrect user input
function test_input($data)
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
  return $data;
  
} 

//Check connection
if(!$conn)
{
	die("Connection failed: ".mysqli_connect_error());
}

mysqli_close($conn);

?>
<!DOCTYPE html>
<!-- saved from url=(0060)http://localhost/Project/Current-project/bootstrap/login.php -->
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Login</title>

  <!-- Custom fonts for this template-->
  <link href="css/sb-admin.min.css" rel="stylesheet" type="text/css">
  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">
  <!-- Front awesome-->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css" integrity="sha384-KA6wR/X5RY4zFAHpv/CnoG2UW1uogYfdnP67Uv7eULvTveboZJg0qUpmJZb5VqzN" crossorigin="anonymous">    
    <!-- My Custom styles for this template-->
    <link href="css/mystyle.css" rel="stylesheet">

</head>

<body class="bg-dark">
  <div class="container">
    <div class="card card-login mx-auto mt-5">
      <div class="card-header">Login</div>
      <div class="card-body">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		      <!--"http://localhost/Project/Current-project/bootstrap/login.php"-->
          <div class="form-group">
            <div class="form-label-group">
              <input type="email" name="inputEmail" id="inputEmail" class="form-control" placeholder="Email address" required="required" autofocus="autofocus">
              <label for="inputEmail">Email address</label>
            </div>
          </div>
          <div class="form-group">
            <div class="form-label-group input">
            <input type="password" name="inputPassword" id="inputPassword" class="form-control form-control-lg" placeholder="Password" required="required">  
              <label for="inputPassword">Password</label>
              <div class="input-group-prepend">
                <div class="input-group-text">
                  <a href="#" class="text-dark" id="icon-click">
                   <span class="fas fa-eye" id="icon"></span>
                  </a>
                </div>
              </div>
			           <span style="color:red"><?php echo $inputErr?></span>
            </div>
          </div>
          <div class="form-group">
            <div class="checkbox">
              <label>
                <input name="remember" type="checkbox" value="remember-me">
                Remember Password
              </label>
            </div>
          </div>
		      <button class="btn btn-primary btn-block" name = "submit" type="submit">Login</button>
        </form>
        <div class="text-center">
          <a class="d-block small mt-3" href="http://localhost/Project/Current-project/bootstrap/register.php">Register an Account</a>
          <a class="d-block small" href="http://localhost/Project/Current-project/bootstrap/forgot-password.php">Forgot Password?</a>
        </div>
      </div>
    </div>
  </div>
  
  <!-- JQuery-->
  <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
  <script type="text/javascript">
    $(document).ready(function(){

      $("#icon-click").click(function(){
        $("#icon").toggleClass('fa-eye-slash');

        var input = $("#inputPassword");
        if(input.attr("type") === "password")
        {
          input.attr("type", "text");
        }else{
          input.attr("type", "password");
        }

      });

    });
  </script>
  <!-- Bootstrap core JavaScript-->
  <script src="./login_files/jquery.min.js.download"></script>
  <script src="./login_files/bootstrap.bundle.min.js.download"></script>

  <!-- Core plugin JavaScript-->
  <script src="./login_files/jquery.easing.min.js.download"></script>

</body>
</html>