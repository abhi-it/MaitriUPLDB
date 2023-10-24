<?php 
  $db = "artesrph_gokulmission"; //database name
  $dbuser = "artesrph_nafees"; //database username
  $dbpassword = "d.]xO[VQ1P*m"; //database password
  $dbhost = "127.0.0.1"; //database host
  $conn = new mysqli($dbhost, $dbuser, $dbpassword, $db);
 $res = $conn->query("SELECT applicationNumber,mobile,email FROM avedans LIMIT 100,200");
 $result = array();
 while($row = $res->fetch_assoc())
 {
    $result[] = $row;
 }
 header('Content-Type: application/json');
echo json_encode($result)
?>