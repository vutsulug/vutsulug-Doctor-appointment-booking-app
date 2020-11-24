<?php
//Initiate database connection
include_once('connection.php');
include_once('db_create.php');
//Start session
session_start();

//Store session
 $user_check = $_SESSION['login_user'];
 
 //SQL Query to fetch completed information
 $ses_sql = mysqli_query($conn,"SELECT email FROM users WHERE email = '$user_check'");
 $row = mysqli_fetch_array($ses_sql, MYSQLI_ASSOC);
 $login_session = $row['email'];

//extract user details from the database
//Initialize variables
$fname = $lname = $email = $docError = $success = "";
$query = $conn->query("SELECT * FROM users WHERE email = '$login_session'");           
while($row = $query->fetch_array()) 
{
 if($row['email'] != "")
  {
    $patientFname = $row['fname'];
    $patientLname = $row['lname'];
    $patientEmail = $row['email'];
  }
}

//Make an appointment
if($_SERVER["REQUEST_METHOD"] == "POST")
{
  //User input
  $tempDoctorFname = test_input($_POST['inputName']);
  $tempDoctorLname = test_input($_POST['inputSurname']);
  $tempEmail = test_input($_POST['inputEmail']);
  $tempAppDate = test_input($_POST['inputAppDate']);
  $appointment_id = "";
  //201955126
  $status = "unconfirmed";

  //extract user details from the database
  //Initialize variables
  $fname = $lname = $email = $staffNo = "";
  $query = $conn->query("SELECT * FROM doctor");           
  while($row = $query->fetch_array()) 
  {
    if($row['email'] != "")
      {
        $doctorFname = $row['fname'];
        $doctorLname = $row['lname'];
        $doctorEmail = $row['email'];
        $doctorStaffNo = $row['staffNo'];
      }

  }
    //Validate doctor exist
    $query = "SELECT id FROM doctor WHERE fname = '$tempDoctorFname' AND lname = '$tempDoctorLname'";
    $rslt = mysqli_query($conn,$query);

  //Validate user input
  if(mysqli_num_rows($rslt) > 0)
  {
    //Insure no duplicate appointment
    $sql = "SELECT id FROM doctor d, appointment a WHERE a.appointment_date = '$tempAppDate'";
    $result = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) > 0)
    {
      //Display error
      $docError = "Doctor's appointment already booked, try another slot!"; 

    }else{

      //Insert data
      $sqlQuery = "INSERT INTO appointment(appointment_id, staffNo, doctor_fname, doctor_lname, patient_fname, patient_lname, appointment_date, status)
      VALUES('',$doctorStaffNo,'$tempDoctorFname','$tempDoctorLname','$patientFname','$patientLname','$tempAppDate','$status')";
      //connect query to database
      mysqli_query($conn, $sqlQuery); 
      $success = "Appointment booked.";
    }
  }
  else{
    $docError = "Incorrect doctor details!";
  }


}

//booked appointment
function bookedAppointment($patientFname, $patientLname)
{
  //database connection
  $servername="localhost";
  $dbusername="root";
  $dbpassword="";
  $dbname="vutsulutech";

  //create connection
  $conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);

  $sqlQuery = $conn->query("SELECT * FROM appointment WHERE patient_fname = '$patientFname' AND patient_lname = '$patientLname' ORDER BY appointment_id");
            
  while($row = $sqlQuery->fetch_array())
  {
    if($row['appointment_id'] != "")
    {
      //Change color
      $status = $row['status'];
      if($status == 'unconfirmed')
      {
        "<span ></span>";
      }

      echo "<tr>";
      echo "<td>".nl2br($row['appointment_id']."</td>"."<td>".$row['doctor_fname']."</td>"."<td>".$row['doctor_lname']."<td>".$row['patient_fname']."</td>"."<td>".$row['patient_lname']."</td>"."<td>".$row['appointment_date']."</td>"."<td>".$status."</td>"."\n",false)."</td>";
      echo "<td><button class='btn btn-warning btn-sm order-1 order-sm-0'><a class='' style='color:white' href='delete.php?cancel_id=".$row['appointment_id']."'>Cancel</a></button></td>";
      echo "</tr>";
    }
           
  }

}

//check for incorrect user input
function test_input($data)
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
} 
  
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Vutsulu Technologies - Dashboard</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Page level plugin CSS-->
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">

  <!-- My Custom styles for this template-->
  <link href="css/mystyle.css" rel="stylesheet">  
</head>

<body id="page-top">
  <nav class="navbar navbar-expand navbar-dark bg-dark static-top">
  <button class="btn btn-link btn-sm text-black order-1 order-sm-0">
      <a class="fas fa-home" href="users-access.php"></a> Home
    </button>
	
    <button class="btn btn-link btn-sm text-blue order-1 order-sm-0" id="sidebarToggle" href="#">
      <i class="fas fa-bars"></i>
    </button>

    <!-- Navbar Search -->
    <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
      <div class="input-group">
        <input type="text" class="form-control" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
        <div class="input-group-append">
          <button class="btn btn-primary" type="button">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>

    <!-- Navbar -->
    <ul class="navbar-nav ml-auto ml-md-0">
      <li class="nav-item dropdown no-arrow mx-1">
        <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-bell fa-fw"></i>
          <span class="badge badge-danger"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="alertsDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li>
      <li class="nav-item dropdown no-arrow mx-1">
        <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-envelope fa-fw"></i>
          <span class="badge badge-danger"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="messagesDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li>
      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-user-circle fa-fw"></i>
        </a>	
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
          <a class="dropdown-item" href="logout.php">
          <i class="fas fa-fw fa-sign-out-alt"></i> Logout
          </a>	
        </div>
      </li>
    </ul>

  </nav>

  <div id="wrapper">
    <!-- Sidebar -->
    <ul class="sidebar navbar-nav">
      <li class="nav-item active">
        <a class="nav-link">
          <span><?php echo $user_check;?><span>
          <i class="fas fa-circle" style="color:green"></i>
          <span style="color:green">Online<span>
        </a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="users-access.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span>
        </a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-fw fa-folder"></i>
          <span>Pages</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          <h6 class="dropdown-header">Login Screens:</h6>
          <a class="dropdown-item" href="login.php">Login</a>
          <a class="dropdown-item" href="register.php">Register</a>
          <a class="dropdown-item" href="forgot-password.php">Forgot Password</a>
          <div class="dropdown-divider"></div>
          <h6 class="dropdown-header">Other Pages:</h6>
          <a class="dropdown-item" href="404.php">404 Page</a>
          <a class="dropdown-item" href="blank.php">Blank Page</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="appointment.php">
          <i class="fas fa-fw fa-clock"></i>
          <span class= "text">Book Appointment</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="users-profile.php">
          <i class="fas fa-fw fa-user"></i>
          <span>My Account</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="doctor_availability.php">
          <i class="fas fa-fw fa-first-aid"></i>
          <span>Doctors</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">
          <i class="fas fa-fw fa-hammer"></i>
          <span>Tools</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">
          <i class="fas fa-fw fa-tools"></i>
          <span>Settings</span></a>
      </li>
    </ul>

    <div id="content-wrapper">

      <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="users-access.php">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">Appointment</li>
        </ol>
        
  <!-- Book appointment Modal-->
    <button class="btn btn-confirm" href="#" data-toggle="modal" data-target="#bookModal">Book an Appointment</button>

  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <div class="modal fade" id="bookModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Book Appointment?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <label for="name">Doctor's first name</label>
            <input class="form-control" name = "inputName" value= ""><br>
            <label for="surname">Doctor's last name</label>
            <input class="form-control" name = "inputSurname" value= ""><br>
            <label for="email">Doctor's email</label>
            <input class="form-control" name = "inputEmail" value= ""><br>
            <label for="password">Appointment Date</label>
            <input class="form-control" name = "inputAppDate" value= "">
            <span align="right" style="color:green" ><?php echo $success;?></span>
            <span align="right" style="color:red"><?php echo $docError;?></span>
          </div>
          <div class="modal-footer">
            <button class="btn btn-primary" type="button" data-dismiss="modal">Cancel</button>
            <button class="btn btn-primary" name = "submit" type="submit"><i class="fas fa-spinner fa-spin"></i> Submit</button>
          </div>
          </div>
        </div>
      </div>
    </form>
    
    <!-- DataTables Example -->
        <div class="card mb-3">
          <div class="card-header">
            <i class="fas fa-data"> Booked appointments</i>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>Appointment Id</th>
                    <th>Doctor's First Name</th>
                    <th>Doctor's Last Name</th>
                    <th>Patient's First Name</th>
                    <th>Patient's Last Name</th>
                    <th>Appointment Date</th>
                    <th>Status</th>
                    <th>Cancel appointment</th>
                  </tr>
                </thead>
                <tbody>
				            	<?php
                        bookedAppointment($patientFname, $patientLname);
                        
					            ?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="card-footer small text-muted">Updated at <?php echo date('Y/m/d H:i:s'); ?></div>
        </div>

      </div> 

      </div> 

    </div>
  </div>

  

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>


  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Page level plugin JavaScript-->
  <script src="vendor/chart.js/Chart.min.js"></script>
  <script src="vendor/datatables/jquery.dataTables.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin.min.js"></script>

  <!-- Demo scripts for this page-->
  <script src="js/demo/datatables-demo.js"></script>
  <script src="js/demo/chart-area-demo.js"></script>

</body>

</html>
