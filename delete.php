<?php
// including connecting file to data base 
include "connect.php";
// get the id  to delete item from shippeditem and relation table 
$id = isset($_GET['id']) && is_numeric($_GET['id']) ?intval($_GET['id']):0;
$schedule = isset($_GET['schedul']) && is_numeric($_GET['schedul']) ?intval($_GET['schedul']):0;/*my parameter to send to the transevents table */
// start  delete query  (delete from 2 tables only and i got these mestake )

    // $addnew = $con->prepare("DELETE FROM  shippeditem  where shipped_id = ?; 
    //                              DELETE FROM transevents where schedulenumber = ?"); 
                                 
                                 $addnew = $con->prepare(" DELETE FROM  shippeditem WHERE shipped_id =?;
                                 DELETE FROM transevents  WHERE schedulenumber =?;
                                 DELETE FROM transport  WHERE transport.item_id =?");      
                                 
                                 /* its the query to delete from alll 3 table */
            $addnew->execute(array($id,$schedule,$id ));

            header("refresh:1;index.php");
  

 /*
 for  me 
just for really delete from all tables 


 DELETE FROM  shippeditem WHERE shipped_id =5;
DELETE FROM transevents  WHERE schedulenumber =5;
DELETE FROM transport  WHERE transport.item_id =5;


*/
 