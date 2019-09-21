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
		
?>

<!-- Made by Joseph Galbreath -->
<html>

	<head>

		<script>
			//Made by Justin Senia: modifies history to prevent refresh/redirect errors
			window.onload = function() 
			{
				history.replaceState("", "", "S07_Require_Registration_Alert.php");
			}
		</script>

		<title> Require Registration Alert - 3-B </title>
		
	</head>

	<body>
	
		<!-- Referenced screens by Alexander Martens and Privithiraj Naraharito see positions css tags-->
		<p align = "center">
			*You must either Register with our website or Log in before checking out*
		</p>
		<p align = "center">
			Returning to main menu where Registration & Login links are available...
		</p>

		<!-- Referenced screens by Alexander Martens and Privithiraj Narahari to see positions css tags-->

		<a href="S01_Welcome.php"><input type="button" style = "margin-left : 45%; margin-right : 45%; width : 10%" name="GoBackToRegister" value="OK"></a>

	</body>
	
</html>