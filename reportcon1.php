<?php 
$con = mysqli_connect("localhost","root","","penucare");
// Check connection
if (mysqli_connect_errno())
{
echo "Failed to connect to MySQL: " . mysqli_connect_error();
 }else{
    $sql ="SELECT * FROM revisittb";
    $result = mysqli_query($con,"select nurse as nurse, sum(nurseFees) as total_NurseFees
    from revisittb
    group by nurse");
    $chart_data="";
    while ($row = mysqli_fetch_array($result)) { 

       $Nurse_Name[]  = $row['nurse']  ;
       $Nurse_Fees[] = $row['total_NurseFees'];
   }
}	
  
?>