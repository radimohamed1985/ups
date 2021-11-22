<?php

// its connection file to data base 
$dsn = "mysql:host =localhost;dbname=ups";
$user ='root';

$con =new pdo($dsn,$user);

try{
    $con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e){
    $e->getMessage();
}
// here the main query that i depend on all of pages 
$st =$con->prepare("SELECT *  FROM (shippeditem,retailcenter) INNER JOIN `transport` on shippeditem.shipped_id = transport.item_id  ");
$st->execute();
$res = $st->fetchAll();

// query for retail center only

$st =$con->prepare("SELECT *  FROM retailcenter");
$st->execute();
$res = $st->fetchAll();
