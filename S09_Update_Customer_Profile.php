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
		
	//used to determine if there has been a pin match error on this page
	//prints an alert if there has been and asks user to try again
	$matchErrorPIN = false;
		
	if (isset($_POST['update_profile']))
	{
        if ($_POST['new_pin'] == $_POST['retypenew_pin'])
		{
			$newpin	= $_POST['new_pin'];
			$retypenew_pin	= $_POST['retypenew_pin'];
			$firstname	= $_POST['firstname'];
			$lastname	= $_POST['lastname'];
			$address	= $_POST['address'];
			$city	= $_POST['city'];
			$state	= $_POST['state'];
			$zip	= $_POST['zip'];
			$creditcard	= $_POST['credit_card'];
			$cardnumber	= $_POST['card_number'];
			$expirationdate	= $_POST['expiration_date'];
			$username = $_SESSION['UserInfo']['CustomerUsername'];

			$db = mysqli_connect('localhost','201709_471_g01','8SUH3swJoLLEHzxPNEih','201709_471_g01') or die('Error connecting to MySQL server.');

			//$query = "UPDATE 201709_471_g01.Customer SET CustPin = '$newpin' WHERE CustomerUsername = '$username'";
			$query = "UPDATE 201709_471_g01.Customer SET CustPIN = '$newpin', FName = '$firstname', LName = '$lastname', CustAddress = '$address', City = '$city', State = '$state', Zip = '$zip', CCNumber = '$cardnumber', CCName = '$creditcard', CCExpDate = '$expirationdate' Where 201709_471_g01.Customer.CustomerUsername = '$username'";
			//$query = "UPDATE 201709_471_g01.Customer SET CustPIN = '$newpin' WHERE 201709_471_g01.Customer.CustomerUsername = '$_SESSION['UserInfo']['CustomerUsername']'";
			mysqli_query($db, $query) or die('Error querying database.');

			//updates all session cart variables with new values as well
			$_SESSION['UserInfo']['CustPIN']			= $_POST['new_pin'];
			$_SESSION['UserInfo']['FName']				= $_POST['firstname'];
			$_SESSION['UserInfo']['LName']				= $_POST['lastname'];
			$_SESSION['UserInfo']['CustAddress']		= $_POST['address'];
			$_SESSION['UserInfo']['City']				= $_POST['city'];
			$_SESSION['UserInfo']['State']				= $_POST['state'];
			$_SESSION['UserInfo']['Zip']				= $_POST['zip'];
			$_SESSION['UserInfo']['CCName']				= $_POST['credit_card'];
			$_SESSION['UserInfo']['CCNumber']			= $_POST['card_number'];
			$_SESSION['UserInfo']['CCExpDate']			= $_POST['expiration_date'];
			
			//echo $_SESSION['UserInfo']['CustomerUsername'];
			header("Location: http://db2.emich.edu/~201709_cosc471_group01/S01_Welcome.php");
			//echo $newpin." ".$retypenew_pin." ".$firstname." ".$lastname." ".$address." ".$city." ".$state." ".$zip." ".$creditcard." ".$cardnumber." ".$expirationdate;
		}
		else
		{
			$matchErrorPIN = true;
		}
    }
?>

<!-- Made by Alexander Martens and Privithiraj Narahari, Modified by Justin Senia and Joseph Galbreath-->
<html>

	<head>

		<script>
			//Made by Justin Senia: modifies history to prevent refresh/redirect errors
			window.onload = function() 
			{
				history.replaceState("", "", "S09_Update_Customer_Profile.php");
			}
		</script>

		<title> Update Customer Profile - 3-B </title>

	</head>
	
	<body>
	
		<?php
			if ($matchErrorPin == true && isset($_POST['update_profile']))
			{
				echo '<script>alert("PIN\'s Don\'t Match, Please Correct and Try Submitting Again.");</script>';
			}
		?>
	
		<form id="update_profile" action="S09_Update_Customer_Profile.php" method="POST">
		<table align="center" style="border:2px solid blue;">
			<tr>
				<td align="right">
				
					<?php
						echo "Username: " . $_SESSION['UserInfo']['CustomerUsername'];
					?>
					
				</td>
				<td colspan="3" align="center">
				</td>
			</tr>
			<tr>
				<td align="right">
					New PIN<span style="color:red">*</span>:
				</td>
				<td>
					<?php
						//handles case where user tried to submit PINS that didn't match
						//repopulates fields with updated data so user doesn't have to re-enter it all
						if (isset($_POST['update_profile']))
						{
							echo "<input type='text' id='new_pin' name='new_pin' value='" . $_POST['new_pin'] . "'>";
						}
						//Handles the case where no new data has been submitted yet, value is derived from session cart
						else
						{
							echo "<input type='text' id='new_pin' name='new_pin' value='" . $_SESSION['UserInfo']['CustPIN'] . "'>";
						}
					?>
				</td>
				<td align="right">
					Re-type New PIN<span style="color:red">*</span>:
				</td>
				<td>
					<?php
						//handles case where user tried to submit PINS that didn't match
						//repopulates fields with updated data so user doesn't have to re-enter it all
						if (isset($_POST['update_profile']))
						{
							echo "<input type='text' id='retypenew_pin' name='retypenew_pin' value='" . $_POST['retypenew_pin'] . "'>";
						}
						//Handles the case where no new data has been submitted yet, value is derived from session cart
						else
						{
							echo "<input type='text' id='retypenew_pin' name='retypenew_pin' value='" . $_SESSION['UserInfo']['CustPIN'] . "'>";
						}
					?>
				</td>
			</tr>
			<tr>
				<td align="right">
					First Name<span style="color:red">*</span>:
				</td>
				<td colspan="3">
				
					<?php
						//handles case where user tried to submit PINS that didn't match
						//repopulates fields with updated data so user doesn't have to re-enter it all
						if (isset($_POST['update_profile']))
						{
							echo "<input type='text' id='firstname' name='firstname' value='" . $_POST['firstname'] . "'>";
						}
						//Handles the case where no new data has been submitted yet, value is derived from session cart
						else
						{
							echo "<input type='text' id='firstname' name='firstname' value='" . $_SESSION['UserInfo']['FName'] . "'>";
						}
					?>
					
				</td>
			</tr>
			<tr>
				<td align="right"> 
					Last Name<span style="color:red">*</span>:
				</td>
				<td colspan="3">
				
					<?php
						//handles case where user tried to submit PINS that didn't match
						//repopulates fields with updated data so user doesn't have to re-enter it all
						if (isset($_POST['update_profile']))
						{
							echo "<input type='text' id='lastname' name='lastname' value='" . $_POST['lastname'] . "'>";
						}
						//Handles the case where no new data has been submitted yet, value is derived from session cart
						else
						{
							echo "<input type='text' id='lastname' name='lastname' value='" . $_SESSION['UserInfo']['LName'] . "'>";
						}
					?>
					
				</td>
			</tr>
			<tr>
				<td align="right">
					Address<span style="color:red">*</span>:
				</td>
				<td colspan="3">
				
					<?php
						//handles case where user tried to submit PINS that didn't match
						//repopulates fields with updated data so user doesn't have to re-enter it all
						if (isset($_POST['update_profile']))
						{
							echo "<input type='text' id='address' name='address' value='" . $_POST['address'] . "'>";
						}
						//Handles the case where no new data has been submitted yet, value is derived from session cart
						else
						{
							echo "<input type='text' id='address' name='address' value='" . $_SESSION['UserInfo']['CustAddress'] . "'>";
						}
					?>
					
				</td>
			</tr>
			<tr>
				<td align="right">
					City<span style="color:red">*</span>:
				</td>
				<td colspan="3">
				
					<?php
						//handles case where user tried to submit PINS that didn't match
						//repopulates fields with updated data so user doesn't have to re-enter it all
						if (isset($_POST['update_profile']))
						{
							echo "<input type='text' id='city' name='city' value='" . $_POST['city'] . "'>";
						}
						//Handles the case where no new data has been submitted yet, value is derived from session cart
						else
						{
							echo "<input type='text' id='city' name='city' value='" . $_SESSION['UserInfo']['City'] . "'>";
						}
					?>
					
				</td>
			</tr>
			<tr>
				<td align="right">
					State<span style="color:red">*</span>:
				</td>
				<td>
					<select id="state" name="state">
					
						<?php
							//handles case where user tried to submit PINS that didn't match
							//repopulates fields with updated data so user doesn't have to re-enter it all
							if (isset($_POST['update_profile']))
							{
								if (strcasecmp($_POST['state'], "Michigan") == 0)
								{
									echo "<option selected>Michigan</option>";
									echo "<option>California</option>";
									echo "<option>Tennessee</option>";
								}
								elseif (strcasecmp($_POST['state'], "California") == 0)
								{
									echo "<option selected>California</option>";
									echo "<option>Michigan</option>";
									echo "<option>Tennessee</option>";
								}
								elseif (strcasecmp($_POST['state'], "Tennessee") == 0)
								{
									echo "<option selected>Tennessee</option>";
									echo "<option>Michigan</option>";
									echo "<option>California</option>";
								}
								else
								{
									echo "<option selected disabled>select a state</option>";
									echo "<option>Michigan</option>";
									echo "<option>California</option>";
									echo "<option>Tennessee</option>";
								}
							}
							//Handles the case where no new data has been submitted yet, value is derived from session cart
							else
							{
								if (strcasecmp($_SESSION['UserInfo']['State'], "Michigan") == 0)
								{
									echo "<option selected>Michigan</option>";
									echo "<option>California</option>";
									echo "<option>Tennessee</option>";
								}
								elseif (strcasecmp($_SESSION['UserInfo']['State'], "California") == 0)
								{
									echo "<option selected>California</option>";
									echo "<option>Michigan</option>";
									echo "<option>Tennessee</option>";
								}
								elseif (strcasecmp($_SESSION['UserInfo']['State'], "Tennessee") == 0)
								{
									echo "<option selected>Tennessee</option>";
									echo "<option>Michigan</option>";
									echo "<option>California</option>";
								}
								else
								{
									echo "<option selected disabled>select a state</option>";
									echo "<option>Michigan</option>";
									echo "<option>California</option>";
									echo "<option>Tennessee</option>";
								}
							}
						?>
						
					</select>
				</td>
				<td align="right">
					Zip<span style="color:red">*</span>:
				</td>
				<td>
				
					<?php
						//handles case where user tried to submit PINS that didn't match
						//repopulates fields with updated data so user doesn't have to re-enter it all
						if (isset($_POST['update_profile']))
						{
							echo "<input type='text' id='zip' name='zip' value='" . $_POST['zip'] . "'>";
						}
						//Handles the case where no new data has been submitted yet, value is derived from session cart
						else
						{
							echo "<input type='text' id='zip' name='zip' value='" . $_SESSION['UserInfo']['Zip'] . "'>";
						}
					?>
					
				</td>
			</tr>
			<tr>
				<td align="right">
					Credit Card<span style="color:red">*</span>:
				</td>
				<td>
					<select id="credit_card" name="credit_card">
					
						<?php
							//handles case where user tried to submit PINS that didn't match
							//repopulates fields with updated data so user doesn't have to re-enter it all
							if (isset($_POST['update_profile']))
							{
								if (strcasecmp($_POST['credit_card'], "VISA") == 0)
								{
									echo "<option selected>VISA</option>";
									echo "<option>MASTER</option>";
									echo "<option>DISCOVER</option>";
								}
								elseif (strcasecmp($_POST['credit_card'], "MASTER") == 0)
								{
									echo "<option selected>MASTER</option>";
									echo "<option>VISA</option>";
									echo "<option>DISCOVER</option>";
								}
								elseif (strcasecmp($_POST['credit_card'], "DISCOVER") == 0)
								{
									echo "<option selected>DISCOVER</option>";
									echo "<option>VISA</option>";
									echo "<option>MASTER</option>";
								}
								else
								{
									echo "<option selected disabled>select a card type</option>";
									echo "<option>DISCOVER</option>";
									echo "<option>VISA</option>";
									echo "<option>MASTER</option>";
								}
							}
							//Handles the case where no new data has been submitted yet, value is derived from session cart
							else
							{
								if (strcasecmp($_SESSION['UserInfo']['CCName'], "VISA") == 0)
								{
									echo "<option selected>VISA</option>";
									echo "<option>MASTER</option>";
									echo "<option>DISCOVER</option>";
								}
								elseif (strcasecmp($_SESSION['UserInfo']['CCName'], "MASTER") == 0)
								{
									echo "<option selected>MASTER</option>";
									echo "<option>VISA</option>";
									echo "<option>DISCOVER</option>";
								}
								elseif (strcasecmp($_SESSION['UserInfo']['CCName'], "DISCOVER") == 0)
								{
									echo "<option selected>DISCOVER</option>";
									echo "<option>VISA</option>";
									echo "<option>MASTER</option>";
								}
								else
								{
									echo "<option selected disabled>select a card type</option>";
									echo "<option>DISCOVER</option>";
									echo "<option>VISA</option>";
									echo "<option>MASTER</option>";
								}
							}
						?>
						
					</select>
				</td>
				<td align="right">
					CC Number<span style="color:red">*</span>:
				</td>
				<td align="left" colspan="2">
				
					<?php
						//handles case where user tried to submit PINS that didn't match
						//repopulates fields with updated data so user doesn't have to re-enter it all
						if (isset($_POST['update_profile']))
						{
							echo "<input type='text' id='card_number' name='card_number' value='" . $_POST['card_number'] . "'>";
						}
						//Handles the case where no new data has been submitted yet, value is derived from session cart
						else
						{
							echo "<input type='text' id='card_number' name='card_number' value='" . $_SESSION['UserInfo']['CCNumber'] . "'>";
						}
					?>
					
				</td>
			</tr>
			<tr>
				<td align="right" colspan="2">
					Expiration Date<span style="color:red">*</span>:
				</td>
				<td colspan="2" align="left">
					
					<?php
						//handles case where user tried to submit PINS that didn't match
						//repopulates fields with updated data so user doesn't have to re-enter it all
						if (isset($_POST['update_profile']))
						{
							echo "<input type='text' id='expiration_date' name='expiration_date' value='" . $_POST['expiration_date'] . "'>";
						}
						//Handles the case where no new data has been submitted yet, value is derived from session cart
						else
						{
							echo "<input type='text' id='expiration_date' name='expiration_date' value='" . $_SESSION['UserInfo']['CCExpDate'] . "'>";
						}
					?>
					
				</td>
			</tr>
			<tr>
				<td align="right" colspan="2">
					<input type="submit" id="update_profile" name="update_profile" value="Update">
				</td>
		</form>
		<form id="cancel" action="S08_Order_Confirmation.php" method="post">	
				<td align="left" colspan="2">
					<input type="submit" id="cancel_submit" name="cancel_submit" value="Cancel">
				</td>
			</tr>
		</table>
		</form>
		
	</body>
	
</html>