<?php 
$dsn="mysql:host=localhost;dbname=gis_system";
$user="root";
$password="";
$options=[];

try{
    $connection=new PDO($dsn,$user,$password,$options);
    // echo "Success";
}
catch(PDOExcepion)
{
    echo "connection error";
}

?>