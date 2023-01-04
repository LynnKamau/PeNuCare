<!DOCTYPE html>
<?php 
include('func.php');  
include('newfunc.php');
$con=mysqli_connect("localhost","root","","penucare");


  $pid = $_SESSION['pid'];
  $username = $_SESSION['username'];
  $email = $_SESSION['email'];
  $fname = $_SESSION['fname'];
  $gender = $_SESSION['gender'];
  $lname = $_SESSION['lname'];
  $contact = $_SESSION['contact'];



if(isset($_POST['rev-submit']))
{
  $pid = $_SESSION['pid'];
  $username = $_SESSION['username'];
  $email = $_SESSION['email'];
  $fname = $_SESSION['fname'];
  $lname = $_SESSION['lname'];
  $gender = $_SESSION['gender'];
  $contact = $_SESSION['contact'];
  $nurse=$_POST['nurse'];
  $email=$_SESSION['email'];
  # $fees=$_POST['fees'];
  $nurseFees=$_POST['nurseFees'];

  $revdate=$_POST['revdate'];
  $revtime=$_POST['revtime'];
  $cur_date = date("Y-m-d");
  date_default_timezone_set('Asia/Kolkata');
  $cur_time = date("H:i:s");
  $revtime1 = strtotime($revtime);
  $revdate1 = strtotime($revdate);
	
  if(date("Y-m-d",$revdate1)>=$cur_date){
    if((date("Y-m-d",$revdate1)==$cur_date and date("H:i:s",$revtime1)>$cur_time) or date("Y-m-d",$revdate1)>$cur_date) {
      $check_query = mysqli_query($con,"select revtime from revisittb where nurse='$nurse' and revdate='$revdate' and revtime='$revtime'");

        if(mysqli_num_rows($check_query)==0){
          $query=mysqli_query($con,"insert into revisittb(pid,fname,lname,gender,email,contact,nurse,nurseFees,revdate,revtime,userStatus,nurseStatus) values($pid,'$fname','$lname','$gender','$email','$contact','$nurse','$nurseFees','$revdate','$revtime','1','1')");

          if($query)
          {
            echo "<script>alert('Your Revisit successfully booked');</script>";
          }
          else{
            echo "<script>alert('Unable to process your request. Please try again!');</script>";
          }
      }
      else{
        echo "<script>alert('We are sorry to inform that the nurse is not available in this time or date. Please choose different time or date!');</script>";
      }
    }
    else{
      echo "<script>alert('Select a time or date in the future!');</script>";
    }
  }
  else{
      echo "<script>alert('Select a time or date in the future!');</script>";
  }
  
}

if(isset($_GET['cancel']))
  {
    $query=mysqli_query($con,"update revisittb set userStatus='0' where ID = '".$_GET['ID']."'");
    if($query)
    {
      echo "<script>alert('Your Revisit successfully cancelled');</script>";
    }
  }





function generate_bill(){
  $con=mysqli_connect("localhost","root","","penucare");
  $pid = $_SESSION['pid'];
  $output='';
  $query=mysqli_query($con,"select p.pid,p.ID,p.fname,p.lname,p.nurse,p.revdate,p.revtime,p.diagnosis,p.allergy,p.prescription,a.nurseFees from prestb p inner join revisittb a on p.ID=a.ID and p.pid = '$pid' and p.ID = '".$_GET['ID']."'");
  while($row = mysqli_fetch_array($query)){
    $output .= '
    <label> Patient ID : </label>'.$row["pid"].'<br/><br/>
    <label> Revisit ID : </label>'.$row["ID"].'<br/><br/>
    <label> Patient Name : </label>'.$row["fname"].' '.$row["lname"].'<br/><br/>
    <label> Nurse Name : </label>'.$row["nurse"].'<br/><br/>
    <label> Revisit Date : </label>'.$row["revdate"].'<br/><br/>
    <label> Revisit Time : </label>'.$row["revtime"].'<br/><br/>
    <label> Diagnosis : </label>'.$row["diagnosis"].'<br/><br/>
    <label> Allergies : </label>'.$row["allergy"].'<br/><br/>
    <label> Prescription : </label>'.$row["prescription"].'<br/><br/>
    <label> Fees Paid : </label>'.$row["nurseFees"].'<br/>
    
    ';

  }
  
  return $output;
}


if(isset($_GET["generate_bill"])){
  require_once("TCPDF/tcpdf.php");
  $obj_pdf = new TCPDF('P',PDF_UNIT,PDF_PAGE_FORMAT,true,'UTF-8',false);
  $obj_pdf -> SetCreator(PDF_CREATOR);
  $obj_pdf -> SetTitle("Generate Bill");
  $obj_pdf -> SetHeaderData('','',PDF_HEADER_TITLE,PDF_HEADER_STRING);
  $obj_pdf -> SetHeaderFont(Array(PDF_FONT_NAME_MAIN,'',PDF_FONT_SIZE_MAIN));
  $obj_pdf -> SetFooterFont(Array(PDF_FONT_NAME_MAIN,'',PDF_FONT_SIZE_MAIN));
  $obj_pdf -> SetDefaultMonospacedFont('helvetica');
  $obj_pdf -> SetFooterMargin(PDF_MARGIN_FOOTER);
  $obj_pdf -> SetMargins(PDF_MARGIN_LEFT,'5',PDF_MARGIN_RIGHT);
  $obj_pdf -> SetPrintHeader(false);
  $obj_pdf -> SetPrintFooter(false);
  $obj_pdf -> SetAutoPageBreak(TRUE, 10);
  $obj_pdf -> SetFont('helvetica','',12);
  $obj_pdf -> AddPage();

  $content = '';

  $content .= '
      <br/>
      <h2 align ="center"> PeNuCare PLATFORM</h2></br>
      <h3 align ="center"> Bill</h3>
      

  ';
 
  $content .= generate_bill();
  $obj_pdf -> writeHTML($content);
  ob_end_clean();
  $obj_pdf -> Output("bill.pdf",'I');

}

function get_wards(){
  $con=mysqli_connect("localhost","root","","penucare");
  $query=mysqli_query($con,"select username,ward from nursetb");
  $docarray = array();
    while($row =mysqli_fetch_assoc($query))
    {
        $docarray[] = $row;
    }
    return json_encode($docarray);
}

?>
<html lang="en">
  <head>


    <!-- Required meta tags -->
    <meta charset="utf-8">
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
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
        <a class="nav-link" href="guardianlogout.php"><i class="fa fa-sign-out" aria-hidden="true"></i>Logout</a>
      </li>
       <li class="nav-item">
        <a class="nav-link" href="#"></a>
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
    <h3 style = "margin-left: 40%;  padding-bottom: 20px; font-family: cursive;"> Welcome &nbsp<?php echo $username ?> 
   </h3>
    <div class="row">
  <div class="col-md-4" style="max-width:25%; margin-top: 3%">
    <div class="list-group" id="list-tab" role="tablist">
      <a class="list-group-item list-group-item-action active" id="list-dash-list" data-toggle="list" href="#list-dash" role="tab" aria-controls="home">Dashboard</a>
      <a class="list-group-item list-group-item-action" id="list-home-list" data-toggle="list" href="#list-home" role="tab" aria-controls="home">Book Revisit</a>
      <a class="list-group-item list-group-item-action" href="#rev-hist" id="list-pat-list" role="tab" data-toggle="list" aria-controls="home">Revisit History</a>
      <a class="list-group-item list-group-item-action" href="#list-pres" id="list-pres-list" role="tab" data-toggle="list" aria-controls="home">Prescriptions</a>
      
    </div><br>
  </div>
  <div class="col-md-8" style="margin-top: 3%;">
    <div class="tab-content" id="nav-tabContent" style="width: 950px;">


      <div class="tab-pane fade  show active" id="list-dash" role="tabpanel" aria-labelledby="list-dash-list">
        <div class="container-fluid container-fullw bg-white" >
              <div class="row">
               <div class="col-sm-4" style="left: 5%">
                  <div class="panel panel-white no-radius text-center">
                    <div class="panel-body">
                      <span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i class="fa fa-terminal fa-stack-1x fa-inverse"></i> </span>
                      <h4 class="StepTitle" style="margin-top: 5%;"> Book My Revisit</h4>
                      <script>
                        function clickDiv(id) {
                          document.querySelector(id).click();
                        }
                      </script>                      
                      <p class="links cl-effect-1">
                        <a href="#list-home" onclick="clickDiv('#list-home-list')">
                          Book Revisit
                        </a>
                      </p>
                    </div>
                  </div>
                </div>

                <div class="col-sm-4" style="left: 10%">
                  <div class="panel panel-white no-radius text-center">
                    <div class="panel-body" >
                      <span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i class="fa fa-paperclip fa-stack-1x fa-inverse"></i> </span>
                      <h4 class="StepTitle" style="margin-top: 5%;">My Revisits</h2>
                    
                      <p class="cl-effect-1">
                        <a href="#rev-hist" onclick="clickDiv('#list-pat-list')">
                          View Revisit History
                        </a>
                      </p>
                    </div>
                  </div>
                </div>
                </div>

                <div class="col-sm-4" style="left: 20%;margin-top:5%">
                  <div class="panel panel-white no-radius text-center">
                    <div class="panel-body" >
                      <span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i class="fa fa-list-ul fa-stack-1x fa-inverse"></i> </span>
                      <h4 class="StepTitle" style="margin-top: 5%;">Prescriptions</h2>
                    
                      <p class="cl-effect-1">
                        <a href="#list-pres" onclick="clickDiv('#list-pres-list')">
                          View Prescription List
                        </a>
                      </p>
                    </div>
                  </div>
                </div>
                
         
            </div>
          </div>





      <div class="tab-pane fade" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
        <div class="container-fluid">
          <div class="card">
            <div class="card-body">
              <center><h4>Create an Revisit</h4></center><br>
              <form class="form-group" method="post" action="guardianpanel.php">
                <div class="row">
                  
                  <!-- <?php

                        $con=mysqli_connect("localhost","root","","penucare");
                        $query=mysqli_query($con,"select username,ward from nursetb");
                        $docarray = array();
                          while($row =mysqli_fetch_assoc($query))
                          {
                              $docarray[] = $row;
                          }
                          echo json_encode($docarray);

                  ?> -->
        

                    <div class="col-md-4">
                          <label for="ward">Ward:</label>
                        </div>
                        <div class="col-md-8">
                          <select name="ward" class="form-control" id="ward">
                              <option value="" disabled selected>Select Ward</option>
                              <?php 
                              display_wards();
                              ?>
                          </select>
                        </div>

                        <br><br>

                        <script>
                      document.getElementById('ward').onchange = function foo() {
                        let ward = this.value;   
                        console.log(ward)
                        let docs = [...document.getElementById('nurse').options];
                        
                        docs.forEach((el, ind, arr)=>{
                          arr[ind].setAttribute("style","");
                          if (el.getAttribute("data-ward") != ward ) {
                            arr[ind].setAttribute("style","display: none");
                          }
                        });
                      };

                  </script>

              <div class="col-md-4"><label for="nurse">Nurses:</label></div>
                <div class="col-md-8">
                    <select name="nurse" class="form-control" id="nurse" required="required">
                      <option value="" disabled selected>Select Nurse</option>
                
                      <?php display_docs(); ?>
                    </select>
                  </div><br/><br/> 


                        <script>
              document.getElementById('nurse').onchange = function updateFees(e) {
                var selection = document.querySelector(`[value=${this.value}]`).getAttribute('data-value');
                document.getElementById('nurseFees').value = selection;
              };
            </script>

                  
                  

                  
                        <!-- <div class="col-md-4"><label for="nurse">Nurses:</label></div>
                                <div class="col-md-8">
                                    <select name="nurse" class="form-control" id="nurse1" required="required">
                                      <option value="" disabled selected>Select Nurse</option>
                                      
                                    </select>
                                </div>
                                <br><br> -->

                                <!-- <script>
                                  document.getElementById("ward").onchange = function updatewards(event) {
                                      var selected = document.querySelector(`[data-value=${this.value}]`).getAttribute("value");
                                      console.log(selected);

                                      var options = document.getElementById("nurse1").querySelectorAll("option");

                                      for (i = 0; i < options.length; i++) {
                                        var currentOption = options[i];
                                        var category = options[i].getAttribute("data-ward");

                                        if (category == selected) {
                                          currentOption.style.display = "block";
                                        } else {
                                          currentOption.style.display = "none";
                                        }
                                      }
                                    }
                                </script> -->

                        
                    <!-- <script>
                    let data = 
                
              document.getElementById('ward').onchange = function updatewards(e) {
                let values = data.filter(obj => obj.ward == this.value).map(o => o.username);   
                document.getElementById('nurse1').value = document.querySelector(`[value=${values}]`).getAttribute('data-value');
              };
            </script> -->


                  
                  <div class="col-md-4"><label for="consultancyfees">
                                Consultancy Fees:
                              </label></div>
                              <div class="col-md-8">
                              <!-- <div id="nurseFees">Select a nurse</div> -->
                              <input class="form-control" type="text" name="nurseFees" id="nurseFees" readonly="readonly"/>
                  </div><br><br>

                  <div class="col-md-4"><label>Revisit Date</label></div>
                  <div class="col-md-8"><input type="date" class="form-control datepicker" name="revdate"></div><br><br>

                  <div class="col-md-4"><label>Revisit Time</label></div>
                  <div class="col-md-8">
                    <!-- <input type="time" class="form-control" name="revtime"> -->
                    <select name="revtime" class="form-control" id="revtime" required="required">
                      <option value="" disabled selected>Select Time</option>
                      <option value="08:00:00">8:00 AM</option>
                      <option value="10:00:00">10:00 AM</option>
                      <option value="12:00:00">12:00 PM</option>
                      <option value="14:00:00">2:00 PM</option>
                      <option value="16:00:00">4:00 PM</option>
                    </select>

                  </div><br><br>

                  <div class="col-md-4">
                    <input type="submit" name="rev-submit" value="Create new entry" class="btn btn-primary" id="inputbtn">
                  </div>
                  <div class="col-md-8"></div>                  
                </div>
              </form>
            </div>
          </div>
        </div><br>
      </div>
      
<div class="tab-pane fade" id="rev-hist" role="tabpanel" aria-labelledby="list-pat-list">
        
              <table class="table table-hover">
                <thead>
                  <tr>
                    
                    <th scope="col">Nurse Name</th>
                    <th scope="col">Revisit Fees:</th>
                    <th scope="col">Revisit Date</th>
                    <th scope="col">Revisit Time</th>
                    <th scope="col">Current Status</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 

                    $con=mysqli_connect("localhost","root","","penucare");
                    global $con;

                    $query = "select ID,nurse,nurseFees,revdate,revtime,userStatus,nurseStatus from revisittb where fname ='$fname' and lname='$lname';";
                    $result = mysqli_query($con,$query);
                    while ($row = mysqli_fetch_array($result)){
              
                      #$fname = $row['fname'];
                      #$lname = $row['lname'];
                      #$email = $row['email'];
                      #$contact = $row['contact'];
                  ?>
                      <tr>
                        <td><?php echo $row['nurse'];?></td>
                        <td><?php echo $row['nurseFees'];?></td>
                        <td><?php echo $row['revdate'];?></td>
                        <td><?php echo $row['revtime'];?></td>
                        
                          <td>
                    <?php if(($row['userStatus']==1) && ($row['nurseStatus']==1))  
                    {
                      echo "Active";
                    }
                    if(($row['userStatus']==0) && ($row['nurseStatus']==1))  
                    {
                      echo "Cancelled by You";
                    }

                    if(($row['userStatus']==1) && ($row['nurseStatus']==0))  
                    {
                      echo "Cancelled by nurse";
                    }
                        ?></td>

                        <td>
                        <?php if(($row['userStatus']==1) && ($row['nurseStatus']==1))  
                        { ?>

													
	                        <a href="guardianpanel.php?ID=<?php echo $row['ID']?>&cancel=update" 
                              onClick="return confirm('Are you sure you want to cancel this Revisit ?')"
                              title="Cancel Revisit" tooltip-placement="top" tooltip="Remove"><button class="btn btn-danger">Cancel</button></a>
	                        <?php } else {

                                echo "Cancelled";
                                } ?>
                        
                        </td>
                      </tr>
                    <?php } ?>
                </tbody>
              </table>
        <br>
      </div>



      <div class="tab-pane fade" id="list-pres" role="tabpanel" aria-labelledby="list-pres-list">
        
              <table class="table table-hover">
                <thead>
                  <tr>
                    
                    <th scope="col">nurse Name</th>
                    <th scope="col">Revisit ID</th>
                    <th scope="col">Revisit Date</th>
                    <th scope="col">Revisit Time</th>
                    <th scope="col">Diagnosis</th>
                    <th scope="col">Allergies</th>
                    <th scope="col">Prescriptions</th>
                    <th scope="col">Bill Payment</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 

                    $con=mysqli_connect("localhost","root","","penucare");
                    global $con;

                    $query = "Select nurse,ID,revdate,revtime,diagnosis,allergy,prescription from prestb where pid='$pid';";
                    
                    $result = mysqli_query($con,$query);
                    if(!$result){
                      echo mysqli_error($con);
                    }
                    

                    while ($row = mysqli_fetch_array($result)){
                  ?>
                      <tr>
                        <td><?php echo $row['nurse'];?></td>
                        <td><?php echo $row['ID'];?></td>
                        <td><?php echo $row['revdate'];?></td>
                        <td><?php echo $row['revtime'];?></td>
                        <td><?php echo $row['diagnosis'];?></td>
                        <td><?php echo $row['allergy'];?></td>
                        <td><?php echo $row['prescription'];?></td>
                        <td>
                          <form method="get">
                          <!-- <a href="guardianpanel.php?ID=" 
                              onClick=""
                              title="Pay Bill" tooltip-placement="top" tooltip="Remove"><button class="btn btn-success">Pay</button>
                              </a></td> -->

                              <a href="guardianpanel.php?ID=<?php echo $row['ID']?>">
                              <input type ="hidden" name="ID" value="<?php echo $row['ID']?>"/>
                              <input type = "submit" onclick="alert('Bill Paid Successfully');" name ="generate_bill" class = "btn btn-success" value="Pay Bill"/>
                              </a>
                              </td>
                              </form>

                    
                      </tr>
                    <?php }
                    ?>
                </tbody>
              </table>
        <br>
      </div>




      <div class="tab-pane fade" id="list-messages" role="tabpanel" aria-labelledby="list-messages-list">...</div>
      <div class="tab-pane fade" id="list-settings" role="tabpanel" aria-labelledby="list-settings-list">
        <form class="form-group" method="post" action="func.php">
          <label>nurses name: </label>
          <input type="text" name="name" placeholder="Enter nurses name" class="form-control">
          <br>
          <input type="submit" name="doc_sub" value="Add nurse" class="btn btn-primary">
        </form>
      </div>
       <div class="tab-pane fade" id="list-attend" role="tabpanel" aria-labelledby="list-attend-list">...</div>
    </div>
  </div>
</div>
   </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.10.1/sweetalert2.all.min.js">
   </script>



  </body>
</html>
