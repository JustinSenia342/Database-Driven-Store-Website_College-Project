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


	if (isset($_POST['firstname']))
	{
		//Joseph Galbreath created/edited the following
		
		// Based on following tutorial
		//https://www.eduonix.com/blog/web-programming-tutorials/phpmysql-and-html-forms/
		//can be re-enabled for testing/verification purposes
		//print_r($_POST);
		
		// This is where I learned how connect with a database via PHP
		//https://coolestguidesontheplanet.com/how-to-connect-to-a-mysql-database-with-php/
		//Step1
		 $db = mysqli_connect('localhost','201709_471_g01','8SUH3swJoLLEHzxPNEih','201709_471_g01')
		 or die('Error connecting to MySQL server.');
		
		// All code below is based on following tutorial
		// https://www.eduonix.com/blog/web-programming-tutorials/phpmysql-and-html-forms/
		// create a variable
		$username=$_POST['username'];
		$pin=$_POST['pin'];
		$retype_pin=$_POST['retype_pin'];
		$firstname=$_POST['firstname'];
		$lastname=$_POST['lastname'];
		$address=$_POST['address'];
		$city=$_POST['city'];
		$state=$_POST['state'];
		$zip=$_POST['zip'];
		$credit_card=$_POST['credit_card'];
		$card_number=$_POST['card_number'];
		$expiration=$_POST['expiration'];

		//Execute the query
		 
		mysqli_query($db, "INSERT INTO 201709_471_g01.Customer (CustomerUsername,CustPIN,FName,LName,CustAddress,City,State,Zip,CCNumber,CCName,CCExpDate) VALUES('$username','$pin','$firstname','$lastname','$address','$city','$state','$zip','$card_number','$credit_card','$expiration')");

		//can be re-enabled for testing verification purposes
		/*
		if(mysqli_affected_rows($db) > 0)
		{
			echo "<p>Employee Added</p>";
			//echo "<a href="index.html">Go Back</a>";
		} 
		else {
			echo "Employee NOT Added<br />";
			echo mysqli_error ($db);
		}
		*/
		
		header("Location: http://db2.emich.edu/~201709_cosc471_group01/S01_Welcome.php");
	}

?>

<!-- visual design by Alexander Martens and Privithiraj Narahari
	 Html/css created by Justin Senia
	 Forms & php created and/or compiled for sql integration by Joseph Galbreath-->
<html>

	<head>

		<script>
			//Made by Justin Senia: modifies history to prevent refresh/redirect errors
			window.onload = function() 
			{
				history.replaceState("", "", "S06_Customer_Registration.php");
			}
		</script>

		<title> Customer Registration - 3-B.com </title>

	</head>

	<body>
	
		<table align="center" style="border:2px solid blue;">
			<tbody>
				<tr>
					<!-- Form tag set up base on tutorial
					https://www.eduonix.com/blog/web-programming-tutorials/phpmysql-and-html-forms/ -->
					<form id="register" method="POST" action="S06_Customer_Registration.php">
					<td align="right">
						Username<span style="color:red">*</span>:
					</td>
					<td align="left" colspan="3">
						<input type="text" id="username" name="username" placeholder="Enter your username">
					</td>
				</tr>
				<tr>
					<td align="right">
						PIN<span style="color:red">*</span>:
					</td>
					<td align="left">
						<input type="password" id="pin" name="pin">
					</td>
					<td align="right">
						Re-type PIN<span style="color:red">*</span>:
					</td>
					<td align="left">
						<input type="password" id="retype_pin" name="retype_pin">
					</td>
				</tr>
				<tr>
					<td align="right">
						Firstname<span style="color:red">*</span>:
					</td>
					<td colspan="3" align="left">
						<input type="text" id="firstname" name="firstname" placeholder="Enter your firstname">
					</td>
				</tr>
				<tr>
					<td align="right">
						Lastname<span style="color:red">*</span>:
					</td>
					<td colspan="3" align="left">
						<input type="text" id="lastname" name="lastname" placeholder="Enter your lastname">
					</td>
				</tr>
				<tr>
					<td align="right">
						Address<span style="color:red">*</span>:
					</td>
					<td colspan="3" align="left">
						<input type="text" id="address" name="address">
					</td>
				</tr>
				<tr>
					<td align="right">
						City<span style="color:red">*</span>:
					</td>
					<td colspan="3" align="left">
						<input type="text" id="city" name="city">
					</td>
				</tr>
				<tr>
					<td align="right">
						State<span style="color:red">*</span>:
					</td>
					<td align="left">
						<select id="state" name="state">
							<option selected="" disabled="">select a state</option>
							<option>Michigan</option>
							<option>California</option>
							<option>Tennessee</option>
						</select>
					</td>
					<td align="right">
						Zip<span style="color:red">*</span>:
					</td>
					<td align="left">
						<input type="text" id="zip" name="zip">
					</td>
				</tr>
				<tr>
					<td align="right">
						Credit Card<span style="color:red">*</span>
					</td>
					<td align="left">
						<select id="credit_card" name="credit_card">
							<option selected="" disabled="">select a card type</option>
							<option>VISA</option>
							<option>MASTER</option>
							<option>DISCOVER</option>
						</select>
					</td>
					<td colspan="2" align="left">
						<input type="text" id="card_number" name="card_number" placeholder="Credit card number">
					</td>
				</tr>
				<tr>
					<td colspan="2" align="right">
						Expiration Date<span style="color:red">*</span>:
					</td>
					<td colspan="2" align="left">
						<input type="text" id="expiration" name="expiration" placeholder="MM/YY">
					</td>
				</tr>
				<tr>
					<td colspan="2" align="center"> 
						<input type="submit" id="register_submit" name="register_submit" value="Register">
					</td>
					<td colspan="2" align="center">
						<input type="submit" id="donotregister" name="donotregister" value="Don't Register">
					</td>	
					</form>
				</tr>
			</tbody>
		</table>

	</body>
	
</html>