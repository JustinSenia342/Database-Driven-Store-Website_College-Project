<?php

	//php created by Justin Senia
	
	//starting session to store shopping cart variables
	session_start();
	
	//checks to see if session already exists, if it doesn't create session variables for cart storage
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
	
	if (isset($_POST['redir']))
	{
		if ($_POST['redir'] == "S02_Search.php")
		{
			header("Location: http://db2.emich.edu/~201709_cosc471_group01/S02_Search.php");
		}
		elseif ($_POST['redir'] == "S06_Customer_Registration.php")
		{
			header("Location: http://db2.emich.edu/~201709_cosc471_group01/S06_Customer_Registration.php");
		}
		elseif ($_POST['redir'] == "S11a_User_Login.php")
		{
			header("Location: http://db2.emich.edu/~201709_cosc471_group01/S11a_User_Login.php");
		}
		elseif ($_POST['redir'] == "S11b_Admin_Login.php")
		{
			header("Location: http://db2.emich.edu/~201709_cosc471_group01/S11b_Admin_Login.php");
		}
	}
	
?>

<!-- Made by Alexander Martens and Privithiraj Narahari, Modified by Justin Senia and Joseph Galbreath-->
<html>

	<head>
	
		<script>
			//Made by Justin Senia: modifies history to prevent refresh and redirect errors
			window.onload = function() 
			{
				history.replaceState("", "", "S01_Welcome.php");
			}
		</script>
		
		<title> Welcome - 3-B.com </title>
		
	</head>
	
	<body>
	
		<table align="center" style="border:1px solid blue;">
			<tbody>
				<tr>
					<td>
						<h2>Best Book Buy (3-B.com)</h2>
					</td>
				</tr>
				<tr>
					<td>
						<h4>Online Bookstore</h4>
					</td>
				</tr>
				<tr>
					<td>
						<form name = "location" action="S01_Welcome.php" method="POST">
							<input type="radio" name="redir" value="S02_Search.php" checked>Search Online<br>
							<input type="radio" name="redir" value="S06_Customer_Registration.php">New Customer<br>
							<input type="radio" name="redir" value="S11a_User_Login.php">Returning Customer<br>
							<input type="radio" name="redir" value="S11b_Admin_Login.php">Administrator<br>
							<input type="submit" name="submit" value="ENTER">
						</form>
					</td>
				</tr>
			</tbody>
		</table>
		
	</body>

</html>