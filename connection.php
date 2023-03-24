<?php
$dsn="mysql:host=localhost; dbname=gis_system";
$user="root";
$password="";
$options=[];

try {
    $connection=new PDO($dsn,$user,$password,$options);
    // echo "Connection Successfull";
}
catch (PDOException){
    echo "Connection Unsuccessfull";
}
?>