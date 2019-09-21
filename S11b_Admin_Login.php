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
	
	if (isset($_POST['adminname']))
	{
		// This is where I learned how connect with a database via PHP
		//https://coolestguidesontheplanet.com/how-to-connect-to-a-mysql-database-with-php/
		//Step1
		$db = mysqli_connect('localhost','201709_471_g01','8SUH3swJoLLEHzxPNEih','201709_471_g01')
		or die('Error connecting to MySQL server.');
		$uName=$_POST['adminname'];
		$pWord=$_POST['pin'];
		 
		$query = "SELECT * FROM 201709_471_g01.Administrator WHERE 201709_471_g01.Administrator.AdminUsername = '$uName' AND 201709_471_g01.Administrator.AdminPassword = '$pWord'";
		mysqli_query($db, $query) or die('Error querying database.');
		
		$result = mysqli_query($db, $query);
		
		$userData = mysqli_fetch_array($result);
		
		if (!empty($userData))
		{
			mysqli_close($db);
			header("Location: http://db2.emich.edu/~201709_cosc471_group01/S12_Admin_Report.php");
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
				history.replaceState("", "", "S11b_Admin_Login.php");
			}
		</script>

		<title> Administrator Login - 3-B </title>

	</head>

	<body>

		<table align="center" style="border:2px solid blue;">
			<form action="S11b_Admin_Login.php" method="post" id="admin_login_screen">
			<tr>
				<td align="right">
					Adminname<span style="color:red">*</span>:
				</td>
				<td align="left">
					<input type="text" name="adminname" id="adminname">
				</td>
				<td align="right">
					<input type="submit" name="login" id="login" value="Login">
				</td>
			</tr>
			<tr>
				<td align="right">
					PIN<span style="color:red">*</span>:
				</td>
				<td align="left">
					<input type="password" name="pin" id="pin">
				</td>
			</form>
			<form action="S01_Welcome.php" method="post" id="login_screen">
				<td align="right">
					<input type="submit" name="cancel" id="cancel" value="Cancel">
				</td>
			</form>
			</tr>
		</table>
		
	</body>

</html>