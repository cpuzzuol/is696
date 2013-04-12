<?php require_once('Connections/godaddy.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
} 
?>
<?php include 'header.php' ?>
<?php include 'sidebar.php' ?>
<h3><p>Welcome to Puzzuoli's Mr. Muffler Online Reservations</p></h3>

<?php if(!isset($_SESSION['MM_Username'])): ?>
<div><p>To get started <a href="customerLogin.php">login</a> or create a<a href="newcustomer.php"> new account</a></p></div>
<?php endif; ?>
<p><a href="createreservation.php"><img src="images/schedule_an_appointment.jpg.png" width="251" height="66" class="accordion-toggle"></a></p> 
<span class="span9"><p><em>Don't trust your vehicle to just any auto repair center! Since 1981, Puzzuoli's Mr. Muffler has been a trusted member of the Dearborn, Mich. community. At Puzzuoli's, you will receive the courtesy and respect you deserve all while receiving a fair price on your auto repairs. We never try to upsell our customers and are committed to focusing on fulfilling our customers' needs.</em></p>
</span>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<?php include 'footer.php' ?>