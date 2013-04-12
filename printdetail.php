<?php require_once('Connections/godaddy.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
?>
<!doctype html>
<html>
<head>
	<title>Print Invoice for <?php echo $_SESSION['cust_FirstName'] . " " . $_SESSION['cust_LastName']; ?></title>
    <script>
function printpage()
{
window.print();
}
</script>
</head>
<body onLoad="printpage()">
<h1 align="center">Puzzuoli's Mr Muffler Service Invoice</h1>
<h2>Customer: <strong><?php echo $_SESSION['cust_FirstName'] . " " . $_SESSION['cust_LastName']; ?></strong></h2>

<table width="500" border="1" cellpadding="3" cellspacing="0">
  <tr>
    <td width="94"><span class="detail">Service</span> <span class="detail">ID</span></td>
    <td width="165">
      <?php echo $_SESSION['svc_SerivceID']; ?>
	</td>
    <td width="67" class="detail" colspan="2">Customer Username</td>
    <td width="251">
      <?php echo $_SESSION['svc_username']; ?>
     </td>
  </tr>
  <tr>
    <td><span class="detail">Customer Issue </span></td>
    <td colspan="4"><?php echo $_SESSION['svc_ServiceReq']; ?></td>
  </tr>
  <tr>
    <td><span class="detail">Customer Name </span></td>
    <td colspan="4"><?php echo $_SESSION['cust_FirstName'] . " " . $_SESSION['cust_LastName']; ?></td>
  </tr>
   <tr>
    <td><span class="detail">Customer Vehicle</span></td>
    <td colspan="4"><?php echo $_SESSION['svc_vehicleYear'] . " " . $_SESSION['svc_vehicleMake']  
	. " " . $_SESSION['svc_vehicleModel']; ?></td>
  </tr>
  <tr>
    <td><span class="detail">Customer Address </span></td>
    <td colspan="4"><?php echo $_SESSION['cust_Street'] . "<br>" . $_SESSION['cust_City'] . ", ". $_SESSION['cust_State'] . " " . $_SESSION['cust_Zip'];?></td>
  </tr>
  <tr>
    <td><span class="detail">Customer Contact Info </span></td>
    <td colspan="4"><strong>Phone:</strong> <?php echo $_SESSION['cust_Phone'];?> <br> <strong>Email:</strong> <?php echo $_SESSION['cust_Email'];?></td>
  </tr>
  <tr>
    <td><span class="detail">Parts Ordered: </span></td>
    <td colspan="4">
    	<?php
			mysql_select_db("IS696");
			/*Set an initial counter to total the price all the parts*/
			$sum_parts = 0;
			/*For each of the parameters (parts) sent in the URL */
			foreach($_GET as $key => $value){
				$query_part = ("SELECT * FROM Part WHERE PartName = '{$value}';");
				$query_execute = mysql_query($query_part, $godaddy) or die(mysql_error());
				$rows = mysql_fetch_assoc($query_execute);
				$totalRows = mysql_num_rows($query_execute);
				if($totalRows > 0){
					/*Print out details of each part and add price to the total*/
					echo $rows['PartName'] . " (" . $rows['PartID'] . "): $" . $rows['Price'] . "<br>";	
					$sum_parts = ($sum_parts + floatval($rows['Price']));
					$formatted_sum = number_format($sum_parts, 2, ".", ",");
				}
			}
			echo "<strong>Parts Subtotal: $" . $formatted_sum . "</strong><br>";
		?>
    </td>
  </tr>
  <tr>
  	<td>Labor:</td>
    <td colspan="4">
    	<?php
			$laborHours = floatval($_REQUEST['Labor']);
			$laborPrice = $laborHours * 75;
			echo "$" . number_format($laborPrice, 2, ".", ",") . " (" . $laborHours . " hours x $75/hr.)";
		?>
    </td>
  </tr>
  <tr>
    <td>Sales Tax:</td>
    <td colspan="4">
		<?php 
			$tax = ($sum_parts + $laborPrice) * ".06";
			$total = $tax + $laborPrice + $sum_parts;
			echo "$" . number_format($tax, 2, ".", ",");
		?>
    </td>
  </tr>
  <tr>
    <td>Grand Total:</td>
    <td colspan="4"><?php 
		echo "<strong><h3>$" . number_format($total, 2, ".", ","); "</h3></strong>"?>
    </td>
  </tr>
</table>
<script>
function calcLabor(){
	var labor = document.getElementById("labor-price").value;	
}
</script>
</body>
</html>

