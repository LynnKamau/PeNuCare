<?php 
$con = mysqli_connect("localhost","root","","penucare");
// Check connection
if (mysqli_connect_errno())
{
echo "Failed to connect to MySQL: " . mysqli_connect_error();
 }else{
    $sql ="SELECT * FROM prestb";
    $result = mysqli_query($con,"select diagnosis as diagnosis, count(diagnosis) as total_diagnosis
    from prestb
    group by diagnosis");
    $chart_data="";
    while ($row = mysqli_fetch_array($result)) { 

       $Diagnosis[]  = $row['diagnosis']  ;
       $Diagnosis_Count[] = $row['total_diagnosis'];
   }
}	
  
?>