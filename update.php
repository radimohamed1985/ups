<?php
// including connecting file to data base 
include "connect.php";
include "head.php";

// start my query if statment and get all posted data 
if($_SERVER['REQUEST_METHOD']=="POST"){
    $id = $_POST['id'];
    $deminsion =$_POST['deminsion'];
    $destination = $_POST['destination'];
    $wieght =$_POST['wieght'];
    $insurance =$_POST['insurance'];
    $ddate =$_POST['date'];
    $rroute =$_POST['route'];
    $ttype =$_POST['type'];

  
  // // now start my updating into data base 
  // //  1st update  the main table of the shipped item 
  
    $addnew = $con->prepare("UPDATE shippeditem 
    SET
    destination =?,
    wieght =?,
    deminsion=?,
    insurance =?,
    deliverydate = ? where shipped_id = ?");
            $addnew->execute(array(
                 $destination,
                 $wieght,
                 $deminsion,
                 $insurance,
                $ddate,$id
        ));
  
  // //  then update the next table about trans events 
            $addnew_trans = $con->prepare("UPDATE `transevents` INNER JOIN `transport` on transport.item_id = $id AND transport.transevents_id=transevents.schedulenumber
             SET `type`=?, `deliveryroute`=?"); 
            $addnew_trans->execute(array($ttype,$rroute));
  
 
    }