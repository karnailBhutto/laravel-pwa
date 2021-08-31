<?php 

$db_host="localhost";
$db_user="root";
$db_password="MySqlDB2019";
$db_name = "sfa_kh";

$con=mysqli_connect ($db_host, $db_user, $db_password) or die ("tidak bisa connect");
mysqli_select_db ($con,$db_name) or die ("salah db");

$json = file_get_contents('php://input'); // Don't forget the encoding
$data = json_decode($json); //print_r($data); echo ($data);

$name = $data->outlet_sname;
$id = $data->outletid;

//echo $name;

$sql="UPDATE outlets
SET outlet_sname = '$name' WHERE id = $id";    //echo $sql; exit();
mysqli_query($con,$sql) or die("GAGAL");

echo "ok";

?>