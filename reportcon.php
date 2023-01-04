<?php 
$con = mysqli_connect("localhost","root","","penucare");
// Check connection
if (mysqli_connect_errno())
{
echo "Failed to connect to MySQL: " . mysqli_connect_error();
 }else{
    $sql ="SELECT * FROM nursetb";
    $result = mysqli_query($con,"select ward as ward, sum(nurseFees) as total_NurseFees
    from nursetb
    group by ward");
    $chart_data="";
    while ($row = mysqli_fetch_array($result)) { 

       $Nurse_Ward[]  = $row['ward']  ;
       $Nurse_Fees[] = $row['total_NurseFees'];
   }
}	
  
?>

