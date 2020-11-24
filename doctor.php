<?php
//Initiate database connection
include_once('connection.php');
//Start session
session_start();
//Initialize varibales
$title = $fname = $lname = $email = $status = $speciality = $role = "";

  //database creation
$createDB = "CREATE TABLE IF NOT EXISTS doctor(
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	staffNo VARCHAR(255) NOT NULL,
	title VARCHAR(3) NOT NULL,
  fname VARCHAR(255) NOT NULL,
	lname VARCHAR(255) NOT NULL,
  email VARCHAR(50) NOT NULL,
	speciality VARCHAR(50) NOT NULL,
  status VARCHAR(50) NOT NULL,
	created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  role VARCHAR(50) NOT NULL);";
mysqli_query($conn,$createDB);


 function doctorList()
 {
   //database connection
   $servername="localhost";
   $dbusername="root";
   $dbpassword="";
   $dbname="vutsulutech";
 
   //create connection
   $conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);
 
   $sqlQuery = $conn->query("SELECT * FROM doctor ORDER BY id");
             
   while($row = $sqlQuery->fetch_array())
   {
     if($row['email'] != "")
     {
       echo "<tr>";
       echo "<td>".nl2br($row['title']."</td>"."<td>".$row['fname']."</td>"."<td>".$row['lname']."<td>".$row['speciality']."</td>"."<td>".$row['status']."</td>"."\n",false)."</td>";
       echo "<td><button class='btn btn-primary' data-toggle='modal' data-target='#updateUserModal'><a class='' style='color:white' style='size:20px'><i class='fas fa-edit'></i></a></button>
       <button class='btn btn-danger'><a class='' style='color:white' style='size:20px' href='delete.php?d_id=".$row['id']."'><i class='fas fa-trash'></i></a></button></td>";
       echo "</tr>";
     }
            
   }
 
  }

//extract user details from the database
//Initialize variables

$detailsDuery = $conn->query("SELECT * FROM doctor");    

while($row = $detailsDuery->fetch_array()) 
{
 if($row['email'] != "")
  {
    $title = $row['title'];
    $staffNo = $row['staffNo'];
    $fname = $row['fname'];
    $lname = $row['lname'];
    $email = $row['email'];
    $status  = $row['status'];
    $speciality = $row['speciality'];
    $role = $row['role'];
  }
}

//User input
if($_SERVER["REQUEST_METHOD"] == "POST")
{
  $tempTitle = test_input($_POST['inputTitle']); 
  $tempStaffNo = test_input($_POST['inputStaffNo']); 
  $tempFname = test_input($_POST['inputName']);
  $tempLname = test_input($_POST['inputSurname']);
  $tempEmail = test_input($_POST['inputEmail']);
  $tempStatus = test_input($_POST['inputStatus']);
  $tempSpeciality = test_input($_POST['inputSpeciality']);
  $tempRole = test_input($_POST['inputRole']);

  //Update details
  if($title != $tempTitle){
    $updateQuery = "UPDATE doctor SET title = '$tempTitle' WHERE title = '$title'";
    mysqli_query($conn, $updateQuery);
  }

  if($staffNo != $tempStaffNo){
     $updateQuery = "UPDATE doctor SET staffNo = '$tempStaffNo' WHERE staffNo = '$staffNo'";
    mysqli_query($conn, $updateQuery);
  }

  if($fname != $tempFname){
    $updateQuery = "UPDATE doctor SET fname = '$tempFname' WHERE fname = '$fname'";
    mysqli_query($conn, $updateQuery);
  }

  if($lname != $tempLname){
    $updateQuery = "UPDATE doctor SET lname = '$tempLname' WHERE lname = '$lname'";
    mysqli_query($conn, $updateQuery);
  }

  if($email != $tempEmail){
    $updateQuery = "UPDATE doctor SET email = '$tempEmail' WHERE email = '$email'";
    mysqli_query($conn, $updateQuery);
  }

  if($status != $tempStatus){
    $updateQuery = "UPDATE doctor SET status = '$tempStatus' WHERE status = '$status'";
    mysqli_query($conn, $updateQuery);
  }

  if($speciality != $tempSpeciality){
    $updateQuery = "UPDATE doctor SET speciality = '$tempSpeciality' WHERE speciality = '$speciality'";
    mysqli_query($conn, $updateQuery);
  }

  if($role != $tempRole){
    $updateQuery = "UPDATE doctor SET role = '$tempRole' WHERE role = '$role'";
    mysqli_query($conn, $updateQuery);
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
	<button class="btn btn-link btn-sm text-black order-1 order-sm-0" href="users-access.php">
	  <i class="fas fa-home"></i> Home
	</button>
    <button class="btn btn-link btn-sm text-black order-1 order-sm-0" id="sidebarToggle" href="#">
      <i class="fas fa-bars"></i> 
    </button>
	
    <!-- Navbar Search -->
    <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
      <div class="input-group">
        <input type="text" class="form-control" placeholder="Search..." aria-label="Search" aria-describedby="basic-addon2">
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
        <a class="nav-link" href="admin-access.php">
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
          <h6 class="dropdown-header">Other Pages:</h6>
          <a class="dropdown-item" href="add-user.php">
            <i class ="fas fa-user"> Add user</i>
          </a>
          <a class="dropdown-item" href="blank.php">Blank Page</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="All_appointments.php">
          <i class="fas fa-fw fa-clock"></i>
          <span class= "text">Appointments</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="patients.php">
          <i class="fas fa-fw fa-user"></i>
          <span>Patients</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">
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
            <a href="#">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">Overview</li>
        </ol>

        <!-- DataTables -->
        <div class="card mb-3">
          <div class="card-header">
            <i class="fas fa-table"> Doctor's List</i>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>Title</th>
                    <th>First name</th>
                    <th>Last name</th>
                    <th>Speciality</th>
                    <th>Status</th>
                    <th>Action field</th>
                  </tr>
                </thead>
                <tbody>
				         <tr>
                    <?php
                        doctorList();
				          	?>
			        	  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="card-footer small text-muted">Updated yesterday <?php echo date('Y/m/d H:i:s'); ?></div>
        </div>

      </div>  
      <!-- /.container-fluid -->

      <!-- Sticky Footer -->
      <footer class="sticky-footer">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright © Vutsulu Tech 2019</span>
          </div>
        </div>
      </footer>

    </div>
    <!-- /.content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Update Modal-->
  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  <div class="modal fade" id="updateUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Update User</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <label for="title">Title</label>
          <input class="form-control" name = "inputTitle" value= "<?php echo $title;?>">
          <label for="name">Doctor's first name</label>
          <input class="form-control" name = "inputName" value= "<?php echo $fname;?>"><br>
          <label for="surname">Doctor's last name</label>
          <input class="form-control" name = "inputSurname" value= "<?php echo $lname;?>"><br>
          <label for="email">Doctor's email</label>
          <input class="form-control" name = "inputEmail" value= "<?php echo $email;?>"><br>
          <label for="staff">Staff Number</label>
          <input class="form-control" name = "inputStaffNo" value= "<?php echo $staffNo;?>">
          <label for="status">Status</label>
          <input class="form-control" name = "inputStatus" value= "<?php echo $status;?>">
          <label for="speciality">Speciality</label>
          <input class="form-control" name = "inputSpeciality" value= "<?php echo $speciality;?>">
          <label for="role">Role</label>
          <input class="form-control" name = "inputRole" value= "<?php echo $role;?>">
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" type="button" data-dismiss="modal">Cancel</button>
          <button class="btn btn-primary" name = "submit" type="submit"><i class="fas fa-spinner fa-spin"></i> Submit</button>
        </div>
        </div>
      </div>
    </div>
  </form>

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
