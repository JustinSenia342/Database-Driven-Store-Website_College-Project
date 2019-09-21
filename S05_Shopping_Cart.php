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

	//checks to see if user is trying to checkout without registering first, if not registered
	//moves user to S07_Require_Registration_Alert.php
	if (isset($_POST['chkOutRegFlag']))
	{
		if (empty($_SESSION['UserID']))
		{
			header("Location: http://db2.emich.edu/~201709_cosc471_group01/S07_Require_Registration_Alert.php");
		}
		else
		{
			header("Location: http://db2.emich.edu/~201709_cosc471_group01/S08_Order_Confirmation.php");
		}
	}
	
	if (isset($_POST['item0']))
	{
		//runs through all Session variables and updates values based on number of items in cart before update was hit
		for ($x = 0; $x < count($_SESSION['DBShoppingCart']); $x++)
		{
			if ($_POST['item'.$x] <= 0)
			{
				$_SESSION['TotBooksInCart'] = $_SESSION['TotBooksInCart'] - $_SESSION['DBShoppingCart'][$x][5];
				$_SESSION['TotPrice'] = $_SESSION['TotPrice'] - ($_SESSION['DBShoppingCart'][$x][5] * $_SESSION['DBShoppingCart'][$x][4]);
			}
			elseif ($_POST['item'.$x] > 0)
			{
				$_SESSION['TotBooksInCart'] = $_SESSION['TotBooksInCart'] - ($_SESSION['DBShoppingCart'][$x][5] - $_POST['item'.$x]);
				$_SESSION['TotPrice'] = $_SESSION['TotPrice'] - (($_SESSION['DBShoppingCart'][$x][5] - $_POST['item'.$x]) * $_SESSION['DBShoppingCart'][$x][4]);
				
				$_SESSION['DBShoppingCart'][$x][5] = $_POST['item'.$x];
			}
		}
		
		//Iterates backwards through session array, looking for quantities of zero and removing those array elements
		for ($x = count($_SESSION['DBShoppingCart']) - 1; $x > -1; $x--)
		{
			if ($_POST['item'.$x] <= 0)
			{
				array_splice($_SESSION['DBShoppingCart'], $x, 1);
			}
		}
	}
	
?>

<!-- Design by Alexander Martens and Privithiraj Narahari, Functional Implementation by Justin Senia and Joseph Galbreath-->
<html>

	<head>

		<script>
			//Made by Justin Senia: modifies history to prevent refresh/redirect errors
			window.onload = function() 
			{
				history.replaceState("", "", "S05_Shopping_Cart.php");
			}

			//Delete then recalculate total cost function
			function delFunc(indexVal)
			{
				document.getElementById("item" + indexVal).value = 0;
				document.getElementById("recalculate").submit();
			}
		</script>
		
		<title> Shopping Cart - 3-B.com </title>
		
	</head>

	<body>
		<table align="center" style="border:2px solid blue;">
			<tbody>
				<tr>
					<td align="center">
						<form id="checkout" action="S05_Shopping_Cart.php" method="post">
							<input type="hidden" name="chkOutRegFlag" id="chkOutRegFlag" value="goToCheckout">
							<input type="submit" name="checkout_submit" id="checkout_submit" value="Proceed to Checkout">
						</form>
					</td>
					<td align="center">
						<form id="new_search" action="S02_Search.php" method="post">
							<input type="submit" name="search" id="search" value="New Search">
						</form>								
					</td>
					<td align="center">
						<form id="exit" action="S01_Welcome.php" method="post">
							<input type="submit" name="exit" id="exit" value="EXIT 3-B.com">
						</form>					
					</td>
				</tr>
				<tr>
					<td colspan="3">
						<div id="bookdetails" style="overflow:scroll;height:180px;width:400px;border:1px solid black;">
							<table align="center" border="2" cellpadding="2" cellspacing="2" width="100%">
								<tbody>
									<tr>
										<form id="recalculate" name="recalculate" action="S05_Shopping_Cart.php" method="post">
										<th width="10%">Remove</th><th width="60%">Book Description</th><th width="10%">Qty</th><th width="10%">Price</th>
									</tr>
								
									<?php
									//Justin Senia wrote the following php code
										for ($x = 0; $x < count($_SESSION['DBShoppingCart']); $x++)
										{
											echo	"<tr>";
											echo 	"<td>";
											echo	"<button id=\"delButton\" onclick=\"delFunc(". $x .")\">Delete Item</button>";
											echo	"</td>";
											echo	"<td>";
											echo	$_SESSION['DBShoppingCart'][$x][1] . "<br><b>By</b>"; 
											echo	$_SESSION['DBShoppingCart'][$x][2] . "<br><b>Publisher:</b>";  
											echo	$_SESSION['DBShoppingCart'][$x][3];
											echo	"</td>";
											echo	"<td>";
											echo	"<input id=\"item" . $x . "\" name=\"item" . $x . "\" value=\"" . $_SESSION['DBShoppingCart'][$x][5] . "\" size=\"1\">";
											echo	"</td>";
											echo	"<td>"; 
											echo	$_SESSION['DBShoppingCart'][$x][4] * $_SESSION['DBShoppingCart'][$x][5];
											echo	"</td>";
											echo	"</tr>";
										}
									?>	
									
								</tbody>
							</table>
						</div>
					</td>
				</tr>
				<tr>
					<td align="center">		
						<input type="submit" name="bttnAction" value="Recalculate Payment">
										</form>
					</td>
					<td align="center">
						&nbsp;
					</td>
					<td align="center">		
					
						<?php
						//justin senia wrote the following php code
						//It displays the subtotal
						if (count($_SESSION['DBShoppingCart']) == 0)
							{
								echo	"Subtotal:  0.00";	
							}
							else
							{
								echo	"Subtotal:  " . $_SESSION['TotPrice'];	
							}		
						?>
						
					</td>
				</tr>
			</tbody>
		</table>

	</body>

</html>