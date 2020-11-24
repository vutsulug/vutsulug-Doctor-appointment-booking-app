<?php
//Initiate database connection
include_once('connection.php');


  function deleteRecord()
  {
    //database connection
   $servername="localhost";
   $dbusername="root";
   $dbpassword="";
   $dbname="vutsulutech";
   //create connection
   $conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);

   //get user id to delete a record
    if(isset($_GET['u_id']))
    {
      $id = $_GET['u_id'];
      $deleteQuery = "DELETE FROM users WHERE id = '$id'";
      $results = mysqli_query($conn, $deleteQuery);
      header('Location:patients.php');
    }


 
  }

  function deleteRecord2()
  {
    //database connection
    $servername="localhost";
    $dbusername="root";
    $dbpassword="";
    $dbname="vutsulutech";
    //create connection
    $conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);
    //get name to delete doctor record
    if(isset($_GET['d_id']))
    {
        $id = $_GET['d_id'];
        $deleteQuery = "DELETE FROM doctor WHERE id = '$id'";
        $results = mysqli_query($conn, $deleteQuery);
        header('Location:doctor.php');
    }
  }

  function deleteRecord3()
  {
    //database connection
    $servername="localhost";
    $dbusername="root";
    $dbpassword="";
    $dbname="vutsulutech";
    //create connection
    $conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);
    //get name to delete doctor record
    if(isset($_GET['ap_id']))
    {
        $id = $_GET['ap_id'];
        $deleteQuery = "DELETE FROM appointment WHERE appointment_id = '$id'";
        $results = mysqli_query($conn, $deleteQuery);
        header('Location:All_appointments.php');
    }
  }

  //Cancel appointment
  function cancelAppointment()
  {
    //database connection
    $servername="localhost";
    $dbusername="root";
    $dbpassword="";
    $dbname="vutsulutech";
    //create connection
    $conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);
    //get name to delete doctor record
    if(isset($_GET['cancel_id']))
    {
        $id = $_GET['cancel_id'];
        $deleteQuery = "UPDATE appointment SET status = 'Cancelled' WHERE appointment_id = '$id'";
        $results = mysqli_query($conn, $deleteQuery);
        header('Location:appointment.php');
    }
  }
  
  //Approve or Decline appointment
  function confirmAppointment()
  {
    //database connection
    $servername="localhost";
    $dbusername="root";
    $dbpassword="";
    $dbname="vutsulutech";
    //create connection
    $conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);
    //get name to delete doctor record
    if(isset($_GET['confirm_id']))
    {
        $id = $_GET['confirm_id'];
        $deleteQuery = "UPDATE appointment SET status = 'Confirmed' WHERE appointment_id = '$id'";
        $results = mysqli_query($conn, $deleteQuery);
        header('Location:booked-appointment.php');
    }
  }

  deleteRecord();
  deleteRecord2();
  deleteRecord3();
  cancelAppointment();
  confirmAppointment();

?>