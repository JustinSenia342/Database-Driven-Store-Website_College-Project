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
		
	//checks to see if user is logged in after requesting to go to the order confirmation page
	if (isset($_POST['ordConfFlag']))
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
		
	//if a search has just been done from S02_Search.php, saves search parameters for navigation continuity
	if (isset($_POST['searchfor']))
	{
		$_SESSION['SearchFor']	= $_POST['searchfor'];
		$_SESSION['SearchOn']	= $_POST['searchon'];
		$_SESSION['Category']	= $_POST['category'];
	}
		
	//makes sure data has just been pushed to cart before updating
	if (isset($_POST['CRTISBN']))
	{
		//handles case when cart is empty
		if(count($_SESSION['DBShoppingCart']) == 0)
		{
			//variable array sequence
			//ISBN, Title, Author, Publisher, Price, NumInCart
			array_push($_SESSION['DBShoppingCart'], array($_POST['CRTISBN'], $_POST['CRTTitle'], $_POST['CRTAuthor'], $_POST['CRTPublisher'], $_POST['CRTPrice'], 1));
			
			//creating session variable to store total books in cart value
			$_SESSION['TotBooksInCart'] = $_SESSION['TotBooksInCart'] + 1;

			//creating session variable to store total price of all books in cart value
			$_SESSION['TotPrice'] = $_SESSION['TotPrice'] + $_POST['CRTPrice'];
		} 
		
		//handles case when cart has items already in it
		else 
		{	
			//variable keeps track of whether or new addition already exists in the cart
			$ExistsInCart = 0;
			
			//checks if book already exists, if it does, increments number of books in cart
			//also increments total price, number of book field in session variable located at [5]
			//and also sets exist cart variable so that it won't be double counted by the next method
			for ($y = 0; $y < count($_SESSION['DBShoppingCart']); $y++)
			{
				if ($_SESSION['DBShoppingCart'][$y][0] == $_POST['CRTISBN'])
				{
					$_SESSION['DBShoppingCart'][$y][5] = $_SESSION['DBShoppingCart'][$y][5] + 1;
					$_SESSION['TotBooksInCart'] = $_SESSION['TotBooksInCart'] + 1; 
					$_SESSION['TotPrice'] = $_SESSION['TotPrice'] + $_POST['CRTPrice'];
					$ExistsInCart = 1;
				}
			}
			
			//if the new addition does not exist in the cart already
			if($ExistsInCart == 0)
			{
				//push new information to a new array to be stored in the main DBShoppingCart session array
				//also updates total price of cart and total number of books currently in cart session variables
				array_push($_SESSION['DBShoppingCart'], array($_POST['CRTISBN'], $_POST['CRTTitle'], $_POST['CRTAuthor'], $_POST['CRTPublisher'], $_POST['CRTPrice'], 1));
				$_SESSION['TotBooksInCart'] = $_SESSION['TotBooksInCart'] + 1; 
				$_SESSION['TotPrice'] = $_SESSION['TotPrice'] + $_POST['CRTPrice'];
			} 
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
				history.replaceState("", "", "S03_Search_Results.php");
			}
		</script>
		
		<title> Search Results - 3-B.com </title>
	
	</head>

	<body>
	
		<table align="center" style="border:1px solid blue;">
			<tbody>
				<tr>
					<td align="left">
						
						<?php
							echo "<h6> <fieldset>Your Shopping Cart has " . $_SESSION['TotBooksInCart'] . " items</fieldset> </h6>";
						?>
						
					</td>
					<td>
						&nbsp;
					</td>
					<td align="right">
						<form action="S05_Shopping_Cart.php" method="post">
							<input type="submit" value="Manage Shopping Cart">
						</form>
					</td>
				</tr>	
				<tr>
					<td style="width: 350px" colspan="3" align="center">
						<div id="bookdetails" style="overflow:scroll;height:180px;width:400px;border:1px solid black;background-color:LightBlue">
							<table>
								<tbody>
				
									<?php
										// This is where I learned how connect with a database via PHP
										//https://coolestguidesontheplanet.com/how-to-connect-to-a-mysql-database-with-php/
										//Step1
										$db = mysqli_connect('localhost','201709_471_g01','8SUH3swJoLLEHzxPNEih','201709_471_g01')
										or die('Error connecting to MySQL server.');

										// All code below is based on following tutorial
										// https://www.eduonix.com/blog/web-programming-tutorials/phpmysql-and-html-forms/
										// as well as
										//https://www.formget.com/php-select-option-and-php-radio-button/
										// create a variable
										$search=$_SESSION['SearchFor'];
										$searchOn=$_SESSION['SearchOn'];
										$category=$_SESSION['Category'];

										//Execute the query

										if ($searchOn == "anywhere")
										{
											if ($category == "all")
											{
												$query = "SELECT * FROM 201709_471_g01.Book Where 201709_471_g01.Book.BookTitle Like '%$search%' OR 201709_471_g01.Book.BookAuthor Like '%$search%' OR 201709_471_g01.Book.BookPublisher Like '%$search%' OR 201709_471_g01.Book.ISBN Like '%$search%'";
												mysqli_query($db, $query) or die('Error querying database.');
											}
											else
											{
												$query = "SELECT * FROM 201709_471_g01.Book Where (201709_471_g01.Book.BookTitle Like '%$search%' OR 201709_471_g01.Book.BookAuthor Like '%$search%' OR 201709_471_g01.Book.BookPublisher Like '%$search%' OR 201709_471_g01.Book.ISBN Like '%$search%') AND 201709_471_g01.Book.BookCategory = '$category'";
												mysqli_query($db, $query) or die('Error querying database.');
											}

										}
										else if ($searchOn == "title")
										{
											if ($category == "all")
											{
												$query = "SELECT * FROM 201709_471_g01.Book Where 201709_471_g01.Book.BookTitle Like '%$search%'";
												mysqli_query($db, $query) or die('Error querying database.');
											}
											else
											{
												$query = "SELECT * FROM 201709_471_g01.Book Where 201709_471_g01.Book.BookTitle Like '%$search%' AND 201709_471_g01.Book.BookCategory = '$category'";
												mysqli_query($db, $query) or die('Error querying database.');
											}
										}
										else if ($searchOn == "author")
										{
											if ($category == "all")
											{
												$query = "SELECT * FROM 201709_471_g01.Book Where 201709_471_g01.Book.BookAuthor Like '%$search%'";
												mysqli_query($db, $query) or die('Error querying database.');
											}
											else
											{
												$query = "SELECT * FROM 201709_471_g01.Book Where 201709_471_g01.Book.BookAuthor Like '%$search%' AND 201709_471_g01.Book.BookCategory = '$category'";
												mysqli_query($db, $query) or die('Error querying database.');
											}
										}
										else if ($searchOn == "publisher")
										{
											if ($category == "all")
											{
												$query = "SELECT * FROM 201709_471_g01.Book Where 201709_471_g01.Book.BookPublisher Like '%$search%'";
												mysqli_query($db, $query) or die('Error querying database.');
											}
											else
											{
												$query = "SELECT * FROM 201709_471_g01.Book Where 201709_471_g01.Book.BookPublisher Like '%$search%' AND 201709_471_g01.Book.BookCategory = '$category'";
												mysqli_query($db, $query) or die('Error querying database.');
											}
										}
										else
										{
											if ($category == "all")
											{
												$query = "SELECT * FROM 201709_471_g01.Book Where 201709_471_g01.Book.ISBN Like '%$search%'";
												mysqli_query($db, $query) or die('Error querying database.');
											}
											else
											{
												$query = "SELECT * FROM 201709_471_g01.Book Where 201709_471_g01.Book.ISBN Like '%$search%' AND 201709_471_g01.Book.BookCategory = '$category'";
												mysqli_query($db, $query) or die('Error querying database.');
											}
										}
												
										$result = mysqli_query($db, $query);

										$x = 0;
										while ($row = mysqli_fetch_array($result)) 
										{
											// How I learned to send a noninputted value over php
											// https://stackoverflow.com/questions/2958383/sending-variables-in-post-without-the-input-tag
											echo 	'<tr>';
											echo	'<td align="left">';
											echo	'<form id="Add'.$x.'" action="S03_Search_Results.php" method="post">';
											echo	'<input type="submit" name="AddToCart" id="AddToCart" value="Add To Cart">';
											echo	'<input type="hidden" value='.$search.' name = "searchfor">';
											echo	'<input type="hidden" value='.$searchOn.' name = "searchon">';
											echo	'<input type="hidden" value='.$category.' name = "category">';
											echo	'<input type="hidden" value='.$row['ISBN'].' name = "CRTISBN">';
											echo	'<input type="hidden" value="'.$row['BookTitle'].'" name = "CRTTitle">';
											echo	'<input type="hidden" value="'.$row['BookAuthor'].'" name = "CRTAuthor">';
											echo	'<input type="hidden" value="'.$row['BookPublisher'].'" name = "CRTPublisher">';
											echo	'<input type="hidden" value='.$row['BookPrice'].' name = "CRTPrice">';
											echo	'</form>';
											echo	'</td>';
											echo	'<td rowspan="2" align="left">';
											echo	$row['BookTitle'];
											echo	'<br>'."By ".$row['BookAuthor'];
											echo	'<br>'.'<b>'."Publisher: ".'</b>'.$row['BookPublisher'].",";
											echo	'<br>'.'<b>'.'ISBN:'.'</b>'.$row['ISBN']." ".'<b>'."Price: ".'</b>'.$row['BookPrice'];
											echo	'</td>';
											echo	'</tr>';
											echo	'<tr>';
											echo	'<td align="left">';
											echo	'<form id='.$x.' action="S04_Book_Reviews.php" method="POST">';
											echo	'<input type="submit" name="Reviews" value="Reviews">';
											echo	'<input type="hidden" value='.$row['ISBN'].' name = "ISBN">';
											echo	'</td>';
											echo	'</tr>';
											echo	'</form>';
											echo	'<tr>';
											echo	'<td colspan="2">';
											echo	'<p>';
											echo	"_______________________________________________";
											echo	'</p>';
											echo	'</td>';
											echo	'</tr>';

											$x = $x + 1;
										}
										
										 mysqli_close($db);
									?>	
				
								</tbody>
							</table>
						</div>
					</td>
				</tr>
				<tr>
					<td align="center">
						<form action="S03_Search_Results.php" method="post">
							<input type="hidden" name="ordConfFlag" id="ordConfFlag" value="goToCheckout">
							<input type="submit" value="Proceed To Checkout" id="checkout" name="checkout">
						</form>
					</td>
					<td align="center">
						<form action="S02_Search.php" method="post">
							<input type="submit" value="New Search">
						</form>
					</td>
					<td align="center">
						<form action="S01_Welcome.php" method="post">
							<input type="submit" name="exit" value="EXIT 3-B.com">
						</form>
					</td>
				</tr>
			</tbody>
		</table>

	</body>

</html>