<!DOCTYPE html>
<?php
include('func1.php');
$pid='';
$ID='';
$revdate='';
$revtime='';
$fname = '';
$lname= '';
$doctor = $_SESSION['dname'];
if(isset($_GET['pid']) && isset($_GET['ID']) && ($_GET['revdate']) && isset($_GET['revtime']) && isset($_GET['fname']) && isset($_GET['lname'])) {
$pid = $_GET['pid'];
  $ID = $_GET['ID'];
  $fname = $_GET['fname'];
  $lname = $_GET['lname'];
  $revdate = $_GET['revdate'];
  $revtime = $_GET['revtime'];
}



if(isset($_POST['prescribe']) && isset($_POST['pid']) && isset($_POST['ID']) && isset($_POST['revdate']) && isset($_POST['revtime']) && isset($_POST['lname']) && isset($_POST['fname'])){
  $revdate = $_POST['revdate'];
  $revtime = $_POST['revtime'];
  $diagnosis = $_POST['diagnosis'];
  $allergy = $_POST['allergy'];
  $fname = $_POST['fname'];
  $lname = $_POST['lname'];
  $pid = $_POST['pid'];
  $ID = $_POST['ID'];
  $prescription = $_POST['prescription'];
  
  $query=mysqli_query($con,"insert into prestb(nurse,pid,ID,fname,lname,revdate,revtime,diagnosis,allergy,prescription) values ('$doctor','$pid','$ID','$fname','$lname','$revdate','$revtime','$diagnosis','$allergy','$prescription')");
    if($query)
    {
      echo "<script>alert('Prescribed successfully!');</script>";
    }
    else{
      echo "<script>alert('Unable to process your request. Try again!');</script>";
    }
  // else{
  //   echo "<script>alert('GET is not working!');</script>";
  // }initial
  // enga error?
}

?>

<html lang="en">
  <head>


    <!-- Required meta tags -->
    <meta charset="utf-8">
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png" />
    <meta name="viewport" content="width=device-width, -scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">
    <!-- Bootstrap CSS -->
    
        <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    
    <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans&display=swap" rel="stylesheet">
      <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
  <a class="navbar-brand" href="#"><i class="fa fa-user-plus" aria-hidden="true"></i> PeNuCare PLATFORM </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <style >
    .bg-primary {
    background: -webkit-linear-gradient(left, #3931af, #00c6ff);
}
.list-group-item.active {
    z-index: 2;
    color: #fff;
    background-color: #342ac1;
    border-color: #007bff;
}
.text-primary {
    color: #342ac1!important;
}

.btn-primary{
  background-color: #3c50c1;
  border-color: #3c50c1;
}
  </style>

<div class="collapse navbar-collapse" id="navbarSupportedContent">
     <ul class="navbar-nav mr-auto">
       <li class="nav-item">
        <a class="nav-link" href="nurseadminlogout.php"><i class="fa fa-sign-out" aria-hidden="true"></i>Logout</a>
        
      </li>
       <li class="nav-item">
       <a class="nav-link" href="nursepanel.php"><i class="fa fa-sign-out" aria-hidden="true"></i>Back</a>
      </li>
    </ul>
  </div>
</nav>

</head>
  <style type="text/css">
    button:hover{cursor:pointer;}
    #inputbtn:hover{cursor:pointer;}
  </style>

<body style="padding-top:50px;">
   <div class="container-fluid" style="margin-top:50px;">
    <h3 style = "margin-left: 40%;  padding-bottom: 20px; font-family: cursive;"> Welcome &nbsp<?php echo $doctor ?>
   </h3>

   <div class="tab-pane" id="list-pres" role="tabpanel" aria-labelledby="list-pres-list">
        <form class="form-group" name="prescribeform" method="post" action="prescribe.php">
        
          <div class="row">
                  <div class="col-md-4"><label>Diagnosis:</label></div>
                  <div class="col-md-8">
                   <select name="diagnosis" class="form-control" id="ward" required="required">
                      <option value="head" name="spec" disabled selected>Select Diagnosis</option>
                      <option value="Cough" name="spec">Cough</option>
                      <option value="Flu" name="spec">Flu</option>
                      <option value="Infection" name="spec">Infection</option>
                      <option value="Injury" name="spec">Injury</option>
                      <option value="Fever" name="spec">Fever</option>
                      <option value="Diarrhoea" name="spec">Diarrhoea</option>
                      <option value="Malaria" name="spec">Malaria</option>
                    </select>
                  
                  <div class="col-md-4"><label>Allergies:</label></div>
                  <div class="col-md-8">
                  <!-- <input type="text"  class="form-control" name="allergy" required> -->
                  <textarea id="allergy" cols="86" rows ="5" name="allergy" required></textarea>
                  </div><br><br><br>
                  <div class="col-md-4"><label>Prescription:</label></div>
                  <div class="col-md-8">
                  <!-- <input type="text" class="form-control"  name="prescription"  required> -->
                  <textarea id="prescription" cols="86" rows ="10" name="prescription" required></textarea>
                  </div><br><br><br>
                  <input type="hidden" name="fname" value="<?php echo $fname ?>" />
                  <input type="hidden" name="lname" value="<?php echo $lname ?>" />
                  <input type="hidden" name="revdate" value="<?php echo $revdate ?>" />
                  <input type="hidden" name="revtime" value="<?php echo $revtime ?>" />
                  <input type="hidden" name="pid" value="<?php echo $pid ?>" />
                  <input type="hidden" name="ID" value="<?php echo $ID ?>" />
                  <br><br><br><br>
          <input type="submit" name="prescribe" value="Prescribe" class="btn btn-primary" style="margin-left: 40pc;">
          
        </form>
        <br>
        
      </div>
      </div>
      

  
