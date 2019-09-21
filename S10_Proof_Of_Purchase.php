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
		
	//checks to see if data was just submitted from the S08_Order_Confirmation page
	
	
	//echo "<input type='text' id='retypenew_pin' name='retypenew_pin' value='" . $_SESSION['UserInfo']['CustPIN'] . "'>";
	
?>

<!-- HTML Made by Justin Senia -->
<html>

	<head>

		<script>
			//Made by Justin Senia: modifies history to prevent refresh/redirect errors
			window.onload = function() 
			{
				history.replaceState("", "", "S10_Proof_Of_Purchase.php");
			}
		</script>

		<title> Proof Of Purchase - 3-B </title>

	</head>

	<body>
		<table cellpadding="5" align="center" style="border:2px solid blue;border-spacing:0;border-collapse:collapse;padding:0;">
			<tr>
				<td>
					<table width="100%">
						<tr>
							<td align="center" colspan="4" width="100%" style='font-size:22;font-weight:bold;'>
								Proof of Purchase
							</td>
						</tr>
						<tr>
							<td style='font-weight:bold;'>
								Shipping address:
							</td>
							<td width="10%">
							</td>
							<td style='font-weight:bold;'>
								UserID: &nbsp;
							</td>
							<td>
								<?php
								$username = $_SESSION['UserInfo']['CustomerUsername'];
								echo $username;
								?>
								
							</td>
						</tr>
						<tr>
							<td>
							<?php
								$FName = $_SESSION['UserInfo']['FName'];
								$LName = $_SESSION['UserInfo']['LName'];
								echo $FName." ".$LName;
							?>
								
							</td>
							<td width="10%">
							</td>
							<td style='font-weight:bold;'> 
								Date: &nbsp;
							</td>
							<td> 
							<?php
							// Where I learned how to get date
							// https://www.w3schools.com/php/php_date.asp
								echo date("m/d/Y");
							?>
							</td>
						</tr>
						<tr>
							<td>

							<?php
								$address = $_SESSION['UserInfo']['CustAddress'];
								
								echo $address;
							?> 
							</td>
							<td width="10%">
							</td>
							<td style='font-weight:bold;'> 
								Time: &nbsp;
							</td>
							<td align="left"> 
							<?php
							// Where I learned how to get time
							// https://www.w3schools.com/php/php_date.asp
								date_default_timezone_set("America/Detroit");
								echo date("h:i:sa");
							?>
							</td>
						</tr>
						<tr>
							<td>
							<?php
								$city = $_SESSION['UserInfo']['City'];
								
								echo $city;
							?> 
							</td>
							<td width="10%">
							</td>
							<td colspan="2" style='font-weight:bold;'>
								Credit Card Information: 
							</td>
						</tr>
						<tr>
							<td>

							<?php
								$state = $_SESSION['UserInfo']['State'];
								$zip = $_SESSION['UserInfo']['Zip'];
								echo $state." ".$zip;
							?> 
								
							</td>
							<td width="10%">
							</td>
							<td colspan="2"> 

							<?php
								
								if (empty($_SESSION['CCTemp']))
								{
									$CCName = $_SESSION['UserInfo']['CCName'];
									$CCNum = $_SESSION['UserInfo']['CCNumber'];
								}
								else
								{
									$CCName = $_SESSION['CCTemp'];
									$CCNum = $_SESSION['CCTempNum'];
								}

								echo $CCName." - ".$CCNum;
							?> 
								
							</td>
						</tr>
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
												Shipping & Handling: &ensp; $ &nbsp;
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
													$totalprice = $_SESSION['TotPrice'] + 4.00;
													echo $totalprice;
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
								<button type="button" style='height:50px;width:150px;' onClick="window.print()">
									Print
								</button>
							</td>
							<td>
								&ensp; &nbsp;
							</td>
							<td>
								<a href="S02_Search.php">
									<button type="button" style='height:50px;width:150px;'>
										New Search
									</button>
								</a>
							</td>
							<td>
								&ensp; &nbsp;
							</td>
							<td>
								<a href="S01_Welcome.php">
									<button type="button" style='height:50px;width:150px;'>
										Exit 3-B.com
									</button>
								</a>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>

		<?php
			$_SESSION['CCTemp'];
			$_SESSION['CCTempNum'];
			$_SESSION['TotBooksInCart'] = 0;
			$_SESSION['TotPrice'] = 0.00;
			$_SESSION['DBShoppingCart'] = array();
		?>
		
	</body>
	
</html>