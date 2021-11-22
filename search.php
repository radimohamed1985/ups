<?php

include "connect.php"; /** include the connection file  */
include "head.php";

if($_SERVER['REQUEST_METHOD']=='GET'){/** start if statment and find the search result and connect to database  */
$searchid = $_GET['search'];
$search = $con->prepare("select * from (shippeditem,transevents,retailcenter,transport) where shipped_id = $searchid");
$search->execute();
$rez =$search->fetch();
$count = $search->rowCount();




if($count > 0){/** if the id found on database show update form  */
   ?>
   <div class="container">

   <!-- start the update  form  -->
<h3> update item</h3>

<form action="update.php" method="post">
<!-- find the id as key to update data  -->
 shipped item id  :<input type="text" value="<?php echo $searchid ?>" name="id">
<br>
<!-- all retail center data as address  -->
retail center  : <input type="text" name= "retail" value="<?php echo $rez['address']; ?>">

  <br>
<!-- data to update into shippeditem table and transevents table  -->

    destination : <input type="text" name= "destination" value="<?php echo $rez['destination']; ?>">
<br>
    deminsion   : <input type="text" name= "deminsion" value="<?php echo $rez['deminsion']; ?>">
<br>
  wieght     : <input type="text" name= "wieght" value="<?php echo $rez['wieght']; ?>">
<br>
    insurance : <input type="text"  name= "insurance" value="<?php echo $rez['insurance']; ?>">
<br>
    deliver date : <input type="date" name= "date" value="<?php echo $rez['deliverydate']; ?>">
<br>
deliver type : <input type="text" name= "type" value="<?php echo $rez['type']; ?>">
<br>
deliver route : <input type="text" name= "route" value="<?php echo $rez['deliveryroute'];?>">
<br>
<input type="submit">
<a href="delete.php?id=<?php echo $rez['shipped_id'] ;?>&schedul=<?php echo $rez['transevents_id'] ;?>">delete</a>
</form>
</div>
<!-- end of form  -->
<?php

}



}