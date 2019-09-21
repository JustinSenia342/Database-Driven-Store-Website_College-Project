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

<!-- Made by Alexander Martens and Privithiraj Narahari, Modified by Justin Senia and Joseph Galbreath-->
<html>

	<head>
	
		<script>
			//Made by Justin Senia: modifies history to prevent refresh/redirect errors
			window.onload = function() 
			{
				history.replaceState("", "", "S02_Search.php");
			}
		</script>
		
		<title> Search - 3-B.com </title>
		
	</head>
	
	<body>
	
		<form id="search" action="S03_Search_Results.php" method="POST">
			<table align="center" style="border:1px solid blue;">
				<tbody>
					<tr>
						<td>
							Search for: 
						</td>
						<td>
							<input name="searchfor">
						</td>
						<td>
							<input type="submit" name="search" value="Search">
						</td>
					</tr>
					<tr>
						<td>
							Search In: 
						</td>
						<td>
							<select name="searchon">
								<option value="anywhere">Keyword anywhere</option>
								<option value="title">Title</option>
								<option value="author">Author</option>
								<option value="publisher">Publisher</option>
								<option value="isbn">ISBN</option>				
							</select>
						</td>
						<td>
							<a href="S05_Shopping_Cart.php"><input type="button" name="manage" value="Manage Shopping Cart"></a>
						</td>
					</tr>
					<tr>
						<td>
							Category: 
						</td>
						<td>
							<select name="category">
								<option value="all" selected="selected">All Categories</option>
								<option value="Fantasy">Fantasy</option>
								<option value="Adventure">Adventure</option>
								<option value="Fiction">Fiction</option>
								<option value="Horror">Horror</option>				
							</select>
						</td>
		</form>
						<td>
							<form action="S01_Welcome.php" method="post">
								<input type="submit" name="exit" value="EXIT 3-B.com">
							</form>
						</td>
					</tr>
				</tbody>
			</table>
			
	</body>

</html>