<?php
// session_start();
$con=mysqli_connect("localhost","root","","penucare");
// if(isset($_POST['submit'])){
//  $username=$_POST['username'];
//  $password=$_POST['password'];
//  $query="select * from logintb where username='$username' and password='$password';";
//  $result=mysqli_query($con,$query);
//  if(mysqli_num_rows($result)==1)
//  {
//   $_SESSION['username']=$username;
//   $_SESSION['pid']=
//   header("Location:guardianpanel.php");
//  }
//  else
//   header("Location:error.php");
// }
if(isset($_POST['update_data']))
{
 $contact=$_POST['contact'];
 $status=$_POST['status'];
 $query="update revisittb set payment='$status' where contact='$contact';";
 $result=mysqli_query($con,$query);
 if($result)
  header("Location:updated.php");
}

// function display_docs()
// {
//  global $con;
//  $query="select * from nursetb";
//  $result=mysqli_query($con,$query);
//  while($row=mysqli_fetch_array($result))
//  {
//   $username=$row['username'];
//   $price=$row['nurseFees'];
//   echo '<option value="' .$username. '" data-value="'.$price.'">'.$username.'</option>';
//  }
// }


function display_wards() {
  global $con;
  $query="select distinct(ward) from nursetb";
  $result=mysqli_query($con,$query);
  while($row=mysqli_fetch_array($result))
  {
    $ward=$row['ward'];
    echo '<option data-value="'.$ward.'">'.$ward.'</option>';
  }
}

function display_docs()
{
 global $con;
 $query = "select * from nursetb";
 $result = mysqli_query($con,$query);
 while( $row = mysqli_fetch_array($result) )
 {
  $username = $row['username'];
  $price = $row['nurseFees'];
  $ward = $row['ward'];
  echo '<option value="' .$username. '" data-value="'.$price.'" data-ward="'.$ward.'">'.$username.'</option>';
 }
}

// function display_wards() {
//   global $con;
//   $query = "select distinct(ward) from nursetb";
//   $result = mysqli_query($con,$query);
//   while($row = mysqli_fetch_array($result))
//   {
//     $ward = $row['ward'];
//     $username = $row['username'];
//     echo '<option value = "' .$ward. '">'.$ward.'</option>';
//   }
// }


if(isset($_POST['doc_sub']))
{
 $username=$_POST['username'];
 $query="insert into nursetb(username)values('$username')";
 $result=mysqli_query($con,$query);
 if($result)
  header("Location:adddoc.php");
}

?>