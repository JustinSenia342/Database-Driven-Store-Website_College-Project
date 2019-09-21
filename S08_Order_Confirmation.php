<?php

	//php created by Justin Senia

	//starts session to hold shopping cart items
	session_start();
		
	if (!isset($_SESSION['DBShoppingCart'])){
		$_SESSION['DBShoppingCart'] = array();
		$_SESSION['TotBooksInCart'] = 0;
		$_SESSION['TotPrice'] = 0.00;
		$_SESSION['UserID'] = "";
		$_SESSION['UserInfo'];
		$_SESSION['SearchFor'] = "";
		$_SESSION['SearchOn'] = "";
		$_SESSION['Category'] = "";
		$_SESSION['ISBN'] = "";
		$_SESSION['CCTemp'] = "";
		$_SESSION['CCTempNum'] = "";
	}

	// variable flag to determine if credit card information is Ok or not
	$isValidCCNum = true;
	
	if (isset($_POST['sendOrder']))
	{
		
		if (empty($_SESSION['UserID']))
		{
			header("Location: http://db2.emich.edu/~201709_cosc471_group01/S07_Require_Registration_Alert.php");
		}
		else
		{
			//the code below is used to get the most recent order number
			$CurrentHighestOrderNum = 0;
			
			// This is where I learned how connect with a database via PHP
			//https://coolestguidesontheplanet.com/how-to-connect-to-a-mysql-database-with-php/
			//Step1
			$db = mysqli_connect('localhost','201709_471_g01','8SUH3swJoLLEHzxPNEih','201709_471_g01')
			or die('Error connecting to MySQL server.');
		
			$currentDate = date("Y-m-d");
			$tPrice = $_SESSION['TotPrice'];
			$oAddress = $_SESSION['UserInfo']['CustAddress'];

			//the code below is to open a db connection so order data can be pushed to the database
			//Joseph Galbreath created/edited the following, justin senia later added to it and
			//edited it as well for this particular page
			
			//case where new temp credit card is used for order
			if ($_POST['creditCardRadio'] == NewCC)
			{
				
				if (empty($_POST['CCNumNew']))
				{
					$isValidCCNum = false;
				}
				else
				{
					$storeQuery = "INSERT INTO 201709_471_g01.storeOrder (OrderDate, OrderTotal, OrderAddress) VALUES ('$currentDate', '$tPrice', '$oAddress')";
					mysqli_query($db, $storeQuery);
					
					$OrderIDGetQuery = "SELECT MAX(OrderID) FROM 201709_471_g01.storeOrder";
					mysqli_query($db, $OrderIDGetQuery) or die('Error querying database.');
					
					$result = mysqli_query($db, $OrderIDGetQuery);
					$userData = mysqli_fetch_array($result);
					
					$oID 	= $userData[0];
					
					for ($x = 0; $x < count($_SESSION['DBShoppingCart']); $x++)
					{
						$ISBN 	= $_SESSION['DBShoppingCart'][$x][0];
						$iNum 	= $x + 1;
						$iQuant = $_SESSION['DBShoppingCart'][$x][5];
						$iPrice = $_SESSION['DBShoppingCart'][$x][4] * $_SESSION['DBShoppingCart'][$x][5];
						
						$orderItemQuery = "INSERT INTO 201709_471_g01.OrderItem  (OrderID, ISBN, ItemNum, ItemQuantity, ItemPrice) VALUES ('$oID', '$ISBN', '$iNum', '$iQuant', '$iPrice')";
			
						mysqli_query($db, $orderItemQuery);

					}
					
					$_SESSION['CCTemp'] = $_POST['CCType'];
					$_SESSION['CCTempNum'] = $_POST['CCNumNew'];
				}
				
			}
			//case where old credit card info is used for order
			else
			{

				$storeQuery = "INSERT INTO 201709_471_g01.storeOrder (OrderDate, OrderTotal, OrderAddress) VALUES ('$currentDate', '$tPrice', '$oAddress')";
				mysqli_query($db, $storeQuery);
					
				$OrderIDGetQuery = "SELECT MAX(OrderID) FROM 201709_471_g01.storeOrder";
				mysqli_query($db, $OrderIDGetQuery) or die('Error querying database.');
				
				$result = mysqli_query($db, $OrderIDGetQuery);
				$userData = mysqli_fetch_array($result);
				
				$oID 	= $userData[0];
					
					for ($x = 0; $x < count($_SESSION['DBShoppingCart']); $x++)
					{
						
						$ISBN 	= $_SESSION['DBShoppingCart'][$x][0];
						$iNum 	= $x + 1;
						$iQuant = $_SESSION['DBShoppingCart'][$x][5];
						$iPrice = $_SESSION['DBShoppingCart'][$x][4] * $_SESSION['DBShoppingCart'][$x][5];
						
						$orderItemQuery = "INSERT INTO 201709_471_g01.OrderItem  (OrderID, ISBN, ItemNum, ItemQuantity, ItemPrice) VALUES ('$oID', '$ISBN', '$iNum', '$iQuant', '$iPrice')";
			
						mysqli_query($db, $orderItemQuery);

					}
					
			}
			
			if (!empty($userData))
			{
				mysqli_close($db);
				header("Location: http://db2.emich.edu/~201709_cosc471_group01/S10_Proof_Of_Purchase.php");
			}
		}
	}
	
?>

<!-- HTML Made by Justin Senia-->
<html>

	<head>

		<script>
			//Made by Justin Senia: modifies history to prevent refresh/redirect errors
			window.onload = function() 
			{
				history.replaceState("", "", "S08_Order_Confirmation.php");
			}
		</script>
		
		<title> Order Confirmation - 3-B </title>

	</head>

	<body>
	
		<?php
			if ($isValidCCNum == false)
			{
				echo '<script>alert("INVALID CC NUMBER");</script>';
			}
		?>
	
		<table cellpadding="5" align="center" style="border:2px solid blue;border-spacing:0;border-collapse:collapse;padding:0;">
			<tr>
				<td>
					<table>
						<tr>
							<td align="center" colspan="2" style='font-size:22;font-weight:bold;'>Confirm Order</td>
						</tr>
						<tr>
							<td style='font-weight:bold;'>Shipping address:</td>
						</tr>
						<tr>
							<td>
							
								<?php
									echo $_SESSION['UserInfo']['FName']. " " .$_SESSION['UserInfo']['LName'];
								?>
								
							</td>
							<td rowspan="4">
								<form id="purchase"  action="S08_Order_Confirmation.php" method="post">
									<input type="hidden" name="sendOrder" id="sendOrder" value="transmitOrder">
									<input type="radio" name="creditCardRadio" value="OldCC" checked> Use Credit Card On File <br>
									
									<?php
										echo $_SESSION['UserInfo']['CCName'] . " - " . $_SESSION['UserInfo']['CCNumber'] . "<br>";
									?>
									
									<input type="radio" name="creditCardRadio" value="NewCC"> New Credit Card <br>
									<select name="CCType">
									<option value="VISA" selected>VISA</option>
									<option value="MASTERCARD">MASTERCARD</option>
									<option value="AMEXPRESS">AMERICAN EXPRESS</option>
									</select>
									<input type="text" name="CCNumNew" id="CCNumNew" size="20" placeholder="Enter Credit Card Number">
									</input>
							</td>
						</tr>
						
						<?php
							echo "<tr><td>". $_SESSION['UserInfo']['CustAddress'] ."</td></tr>";
							echo "<tr><td>". $_SESSION['UserInfo']['City'] ."</td></tr>";
							echo "<tr><td>". $_SESSION['UserInfo']['State'] . "   " . $_SESSION['UserInfo']['Zip'] ."</td></tr>";
						?>

					</table>
				</td>
			</tr>
			<tr>
				<td>
					<table style='display:block;border:1px solid black;'>
						<thead style='display:block;'>
							<tr style='display:block;width:100%;background-color:blue;color:white;'>
								<th style='display:inline-block;width:60%;'>Book Description</th>
								<th style='display:inline-block;width:15%;'>Qty</th>
								<th style='display:inline-block;width:15%'>Price</th>
							</tr>
						</thead>
						<tbody style='display:block;height:150px;width=100%;overflow-y:scroll;'>
						
							<?php
								//Justin Senia wrote the following php code
								for ($x = 0; $x < count($_SESSION['DBShoppingCart']); $x++)
								{
									echo	"<tr style='display:block;border-top:1px solid;border-collapse:collapse;'>";
									echo 	"<td style='display:inline-block;width:62.2%;height:60px;border-left:1px solid;'>";
									echo	$_SESSION['DBShoppingCart'][$x][1] . "<br>";
									echo	"<b>By</b>";
									echo	$_SESSION['DBShoppingCart'][$x][2] . "<br>";
									echo	"<b>Publisher:</b>"; 
									echo	$_SESSION['DBShoppingCart'][$x][3];
									echo	"</td>";
									echo	"<td align='center' style='display:inline-block;width:16.9%;height:50px;align:center;border-left:1px solid;border-collapse:collapse;'>";
									echo	"<div style='position:relative;top:32%;'>";
									echo	$_SESSION['DBShoppingCart'][$x][5];
									echo	"</div>";
									echo	"</td>"; 
									echo	"<td align='center' style='display:inline-block;width:17.1%;height:50px;align:center;border-left:1px solid;border-right:1px solid;border-collapse:collapse;'>";
									echo	"<div style='position:relative;top:32%;'>";
									echo	$_SESSION['DBShoppingCart'][$x][4] * $_SESSION['DBShoppingCart'][$x][5];
									echo	"</div>";
									echo	"</td>"; 
									echo	"</tr>";
								}
							?>	
							
						</tbody>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<table>
						<tr>
							<td style='display:block;width:100%;background-color:blue;color:white;'>
								<div style='display:inline-block;height:70px;'>
									SHIPPING NOTE:<br>
									&emsp;<br>
									&emsp;
								</div>
								<div style='display:inline-block;'>
									The books will be<br>
									delivered within 5<br>
									business days.
								</div>
								<div style='display:inline;'>
									&ensp;
								</div>
							</td>
							<td>
								<td>
									<table>
										<tr>
											<td align="right">
												Subtotal: &ensp; $ &nbsp;
											</td>
											<td>
											
												<?php
													echo $_SESSION['TotPrice'];
												?>	
												
											</td>
										</tr>
										<tr>
											<td align="right">
												Shipping_Handling: &ensp; $ &nbsp;
											</td>
											<td style='border-bottom:1px solid;'>
												4.00
											</td>
										</tr>
										<tr>
											<td align="right">
												Total: &ensp; $ &nbsp;
											</td>
											<td>
												
												<?php
													echo $_SESSION['TotPrice'] + 4.00;
												?>
												
											</td>
										</tr>
									</table>
								</td>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			
			<tr>
				<td>
					<table style='display:block;width:100%'>
						<tr>
							<td>
								<a href="S05_Shopping_Cart.php"><button type="button" style='height:50px;width:150px;'>Cancel</button></a>
							</td>
							<td>
								&ensp; &nbsp;
							</td>
							<td>
								<a href="S09_Update_Customer_Profile.php"><button type="button" style='height:50px;width:150px;'>Update Customer<br>Profile</button></a>
							</td>
							<td>
								&ensp; &nbsp;
							</td>
							<td>
								<input type="hidden" name="chkOutReceipt" id="chkOutReceipt" value="goToReceipt">
								<input type="submit" style='height:50px;width:150px;' name="makeOrder" id="MakeOrder" value="BUY IT!">
								</form>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>

	</body>

</html>