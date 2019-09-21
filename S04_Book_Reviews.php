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

	//if ISBN has been posted  S03_Search.php, saves search parameters
	if (isset($_POST['ISBN']))
	{
		$_SESSION['ISBN']	= $_POST['ISBN'];
	}

?>

<!-- Based on HTML by Alexander Martens and Privithiraj Narahari, edited by Joseph Galbreath-->
<?php
// This is where I learned how interact with a database via PHP
// All PHP Code is based on the example here
//https://coolestguidesontheplanet.com/how-to-connect-to-a-mysql-database-with-php/
//Step1
 $db = mysqli_connect('localhost','201709_471_g01','8SUH3swJoLLEHzxPNEih','201709_471_g01')
 or die('Error connecting to MySQL server.');
?>

<html>

	<head>

		<script>
			//Made by Justin Senia: modifies history to prevent refresh/redirect errors
			window.onload = function() 
			{
				history.replaceState("", "", "S04_Book_Reviews.php");
			}
		</script>

		<title> Book Reviews - 3-B.com </title>

		<style>
		.field_set
		{
			border-style: inset;
			border-width:4px;
		}
		</style>
		
	</head>

	<body>
	
		<table align="center" style="border:1px solid blue;">
			<tbody>
				<tr>
					<td align="center">
						<h5> Reviews For:</h5>
					</td>
					<td align="left">
					
						<?php
							$ISBN1 = $_SESSION['ISBN'];
							$query1 = "SELECT * FROM 201709_471_g01.Book WHERE 201709_471_g01.Book.ISBN = $ISBN1";
							mysqli_query($db, $query1) or die('Error querying database.');

							$result1 = mysqli_query($db, $query1);

							$row1 = mysqli_fetch_array($result1);

							echo '<h5>'.$row1['BookTitle']." by ".$row1['BookAuthor'].'</h5>';
						?>
						
					</td>
				</tr>
				
				<!-- This is where the edit by Joseph was made, the table was formatted kind
					 of oddly so I touched it up -->
				<tr align = "center">
					<td colspan="2">
						<div id="bookdetails" style="overflow:scroll;height:200px;width:300px;border:1px solid black;">
							<p>
							</p>
								<table>
									<tbody>
									
										<?php
											$ISBN = $_SESSION['ISBN'];

											$query = "SELECT TitleReview FROM 201709_471_g01.Reviews WHERE 201709_471_g01.Reviews.ISBN = $ISBN";
											mysqli_query($db, $query) or die('Error querying database.');

											$result = mysqli_query($db, $query);

											//This link helped me solve an issue I was having where the first element of my
											//Table was skipped when I tried to display it
											//https://stackoverflow.com/questions/18258675/mysql-fetch-array-skipping-first-row
											while ($row = mysqli_fetch_array($result)) 
											{
												echo '<tr>'.'<td style= "padding : 10px; border:1px solid black">';
												echo $row['TitleReview'];
												echo '</td>'.'</tr>';
											}
											mysqli_close($db);
										?>
									</tbody>
								</table>
						</div>
					</td>
				</tr>
				<tr>
					<td colspan="2" align="center">
						<form action="S03_Search_Results.php" method="post">
							<input type="submit" value="Done">
						</form>
					</td>
				</tr>
			</tbody>
		</table>

	</body>

</html>