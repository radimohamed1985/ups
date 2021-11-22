<?php

// including the connection file to the data base 


                include "connect.php";   
                include "head.php";   


/*i try to fix the problem that i forget at the first time to make it cascade on delete and on updat 
at the many to many table of realtion that called transport */

                    $st = $con->prepare('ALTER TABLE transport    
                    drop CONSTRAINT transport_ibfk_1;');
                    $st->execute();

                    $st = $con->prepare('ALTER TABLE transport
                    ADD CONSTRAINT transport_ibfk_1
                        FOREIGN KEY (item_id)
                        REFERENCES shippeditem
                            (shipped_id)
                        ON DELETE CASCADE ON UPDATE CASCADE ;');
                        $st->execute();

                    $st = $con->prepare('ALTER TABLE transport
                    drop CONSTRAINT transport_ibfk_2;');
                    $st->execute();

                    $st = $con->prepare('ALTER TABLE transport
                    ADD CONSTRAINT transport_ibfk_2
                        FOREIGN KEY (transevents_id)
                        REFERENCES transevents
                            (schedulenumber)
                        ON DELETE CASCADE ON UPDATE CASCADE ;');
                        $st->execute();
// end  of make the constraint on transport cascade on delete and on update 

// the same fix is here to make shippeditem table cascade on delete and on update in realtion with retailcenter 

                        $st = $con->prepare('ALTER TABLE shippeditem    
                        drop CONSTRAINT shippeditem_ibfk_1;');
                        $st->execute();

                        $st = $con->prepare('ALTER TABLE shippeditem
                        ADD CONSTRAINT shippeditem_ibfk_1
                            FOREIGN KEY (retailcenter_id)
                            REFERENCES retailcenter
                                (retail_id)
                            ON DELETE CASCADE ON UPDATE CASCADE ;');
                            $st->execute();
// end of fixing this problem  



// echo "<pre>";
// print_r($res);
// echo"</pre>";

?>
<div class="container">

<!-- start the adding form  -->
<h3> add new item</h3>


<form action="<?php $_SERVER['PHP_SELF']; ?> " method="post" >
<!-- first proccess that employ will make is to choose his branche to confirm it into the shipping policy -->
<table>
<tr>
<td>select retail center </td>
<td><select name="retail" id="">

<?php foreach($res as $re ){ echo '<option value="'.$re['retail_id'].'">'.$re['address'].'</option>';} ?>
  </select></td>
  </tr>
<!-- its  the input about the shipped item id  -->
<tr>
<td>  destination :</td>
<td>   <input type="text" name= "destination"></td>
</tr>

<tr>
<td>deminsion   :</td>
<td>     <input type="text" name= "deminsion"></td>
</tr>

    <tr>
<td>    wieght        :</td>
<td> <input type="text" name= "wieght"></td>
</tr>
<tr>
<td>insurance : </td>
<td>  <input type="text" name= "insurance"></td>
</tr>
  
    <tr>
<td>  deliver date :</td>
<td> <input type="date" name= "date"></td>
</tr>  
<tr>
<td>deliver type :</td>
<td> <input type="text" name= "type"></td>
</tr>

<tr>
<td>deliver route : </td>
<td><input type="text" name= "route"></td>
</tr>
<tr>
<td rowspan="3"><center><input type="submit"></center></td>
</tr>
</form>
</table>
<!-- end of form  -->
<!-- start search form for exist shipped item wannt to know about it or update  -->
<form action="search.php" method="get">
<table>
<tr>
<td colpan="2">please enter the shipped item id </td>
</tr>
<tr>
<td><input type="search" name="search" id=""></td>
<td><input type="submit" value="search on data base">
</td>
</tr>
</table>
</form>
</div>

<?php
            if($_SERVER['REQUEST_METHOD']=='POST'){

            // all posted from adding form 

            $retail =$_POST['retail'];
            $deminsion =$_POST['deminsion'];
            $destination = $_POST['destination'];
            $wieght =$_POST['wieght'];
            $insurance =$_POST['insurance'];
            $ddate =$_POST['date'];
            $rroute =$_POST['route'];
            $ttype =$_POST['type'];

// now start my inserting into data base 
//  1st insert into the main table of the shipped item 

            $addnew = $con->prepare("INSERT INTO 
            shippeditem (retailcenter_id,destination,wieght,deminsion,insurance,deliverydate)
            VALUES (:zretail,:zdest,:zwieght,:zdeminsion,:zinsurance,:zdelivery)");
                    $addnew->execute(array(
                        'zretail'      => $retail,
                        'zdest'        => $destination,
                        'zdeminsion'   => $deminsion,
                        'zwieght'      =>  $wieght,
                        'zinsurance'  => $insurance,
                        'zdelivery'    =>$ddate
                ));
                $itemid = $con->lastInsertId(); /* query to know the new id from shipped item table and it will be the input in the third table  */

//  then add into the next table about trans events 
                    $addnew_trans = $con->prepare("INSERT INTO `transevents`( `type`, `deliveryroute`) 
                    VALUES ('$ttype','$rroute')");
                    $addnew_trans->execute();
                    $transid = $con->lastInsertId();/* query to know the new id from transevents  table and it will be the input in the third table  */


// echo $itemid;
// echo $transid;   it was just a test for the variable 

// now adding the id of the two table in the third table of relation many to many
                $addtransport = $con->prepare("insert into transport (item_id,transevents_id) 
                values ('$itemid','$transid')");
$addtransport->execute();


}

