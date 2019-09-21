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
				history.replaceState("", "", "S12_Admin_Report.php");
			}
		</script>
	
        <title> Administrator Report - 3-B </title>
		
        <!-- https://www.w3schools.com/html/html_tables.asp
        Used to look up Table syntax, also partially borrowed the css syntax -->
        <style>
            table, th, td 
            {
                border: 1px solid black;
            }
        </style>
		
    </head>

    <body align = "center">

        <!-- Referenced screens by Alexander Martens and Privithiraj Narahari
            to see positions css tags and attributes -->
        <div style="margin-left: 15%; margin-right : 15%; overflow:scroll; height:300px; width : 70%; padding-top: 3px; border:1px solid black;">
       
        <?php

                $db = mysqli_connect('localhost','201709_471_g01','8SUH3swJoLLEHzxPNEih','201709_471_g01') or die('Error connecting to MySQL server.');

                //$query = "UPDATE 201709_471_g01.Customer SET CustPin = '$newpin' WHERE CustomerUsername = '$username'";
                $query = "SELECT count(*) AS Count FROM Customer";
                //$query = "UPDATE 201709_471_g01.Customer SET CustPIN = '$newpin' WHERE 201709_471_g01.Customer.CustomerUsername = '$_SESSION['UserInfo']['CustomerUsername']'";
                mysqli_query($db, $query) or die('Error querying database.');

                $result = mysqli_query($db, $query);
                $row = mysqli_fetch_array($result);
                echo "<p>Total Registered Users Online: ".$row['Count']."</p>";
                    //echo $row['BookCategory']." ".$row['Count']."<br/>";
                
            ?>
<!-- 
        <p>
            Total Registered Users Online: 17
        </p> -->
       
        <!-- https://www.w3schools.com/html/html_tables.asp
        Used to look up Table syntax, also partially borrowed the css syntax -->
        <!-- Referenced screens by Alexander Martens and Privithiraj Narahari
            to see positions css tags 
            https://stackoverflow.com/questions/19089933/how-to-position-two-elements-side-by-side-using-css
            Used above for positioning help
            https://computerservices.temple.edu/creating-tables-html
            Above was for more help with table syntax -->

        <table style = "float : left; margin-left : 15%; margin-right : 10px">
            <tr>
                <th colspan = "2">
                    <h5>
                        Total Books 
                    </h5>
                </th>
            </tr>
            <tr>
                <th>
                    Category
                </th>
                <th>
                    Number of Books
                </th>
            </tr>
            <?php

                $db = mysqli_connect('localhost','201709_471_g01','8SUH3swJoLLEHzxPNEih','201709_471_g01') or die('Error connecting to MySQL server.');

                //$query = "UPDATE 201709_471_g01.Customer SET CustPin = '$newpin' WHERE CustomerUsername = '$username'";
                $query = "SELECT BookCategory, count(*) AS Count FROM Book GROUP BY(BookCategory)";
                //$query = "UPDATE 201709_471_g01.Customer SET CustPIN = '$newpin' WHERE 201709_471_g01.Customer.CustomerUsername = '$_SESSION['UserInfo']['CustomerUsername']'";
                mysqli_query($db, $query) or die('Error querying database.');

                $result = mysqli_query($db, $query);

                while ($row = mysqli_fetch_array($result)) 
                {
                    echo "<tr>"."<td>".$row['BookCategory']."</td>"."<td>".$row['Count']."</td>"."</tr>";
                    //echo $row['BookCategory']." ".$row['Count']."<br/>";
                }
            ?>


        </table>
        
        <table style = "float : left; margin-right : 10px">
            <tr>
                 <th colspan = "2">
                      <h5>
                         Average Monthly Revenue 
                     </h5>
                 </th>
             </tr>
            <tr>
                <th>
                    Month
                </th>
                <th>
                    Revenue
                </th>
            </tr>

            <?php
            $JanuaryRevenue = 0;
            $FebruaryRevenue = 0;
            $MarchRevenue = 0;
            $AprilRevenue = 0;
            $MayRevenue = 0;
            $JuneRevenue = 0;
            $JulyRevenue = 0;
            $AugustRevenue = 0;
            $SeptemberRevenue = 0;
            $OctoberRevenue = 0;
            $NovemberRevenue = 0;
            $DecemberRevenue = 0;

            
            $db = mysqli_connect('localhost','201709_471_g01','8SUH3swJoLLEHzxPNEih','201709_471_g01') or die('Error connecting to MySQL server.');
            
            //$query = "UPDATE 201709_471_g01.Customer SET CustPin = '$newpin' WHERE CustomerUsername = '$username'";
            $query = "SELECT OrderID, OrderTotal, MONTH(OrderDate) AS Month FROM storeOrder WHERE YEAR(storeOrder.OrderDate) = YEAR(CURDATE())";
            //$query = "UPDATE 201709_471_g01.Customer SET CustPIN = '$newpin' WHERE 201709_471_g01.Customer.CustomerUsername = '$_SESSION['UserInfo']['CustomerUsername']'";
            mysqli_query($db, $query) or die('Error querying database.');
            
            $result = mysqli_query($db, $query);
            
            while ($row = mysqli_fetch_array($result)) 
            {
                if ($row['Month'] == 1)
                {
                    $JanuaryRevenue = $JanuaryRevenue + $row['OrderTotal'];
                }
                else if ($row['Month'] == 2)
                {
                    $FebruaryRevenue = $FebruaryRevenue + $row['OrderTotal'];
                }
                else if ($row['Month'] == 3)
                {
                    $MarchRevenue = $MarchRevenue + $row['OrderTotal'];
                }
                else if ($row['Month'] == 4)
                {
                    $AprilRevenue = $AprilRevenue + $row['OrderTotal'];
                }
                else if ($row['Month'] == 5)
                {
                    $MayRevenue = $MayRevenue + $row['OrderTotal'];
                }
                else if ($row['Month'] == 6)
                {
                    $JuneRevenue = $JuneRevenue + $row['OrderTotal'];
                }
                else if ($row['Month'] == 7)
                {
                    $JulyRevenue = $JulyRevenue + $row['OrderTotal'];
                }
                else if ($row['Month'] == 8)
                {
                    $AugustRevenue = $AugustRevenue + $row['OrderTotal'];
                }
                else if ($row['Month'] == 9)
                {
                    $SeptemberRevenue = $SeptemberRevenue + $row['OrderTotal'];
                }
                else if ($row['Month'] == 10)
                {
                    $OctoberRevenue = $OctoberRevenue + $row['OrderTotal'];
                }
                else if ($row['Month'] == 11)
                {
                    $NovemberRevenue = $NovemberRevenue + $row['OrderTotal'];
                }
                else if ($row['Month'] == 12)
                {
                    $DecemberRevenue = $DecemberRevenue + $row['OrderTotal'];
                }
                
                //echo $row['BookCategory']." ".$row['Count']."<br/>";
            }
            echo "<tr>"."<td>"."January"."</td>"."<td>".money_format('%i', $JanuaryRevenue)."</td>"."</tr>";
            echo "<tr>"."<td>"."February"."</td>"."<td>".money_format('%i', $FebruaryRevenue)."</td>"."</tr>";
            echo "<tr>"."<td>"."March"."</td>"."<td>".money_format('%i', $MarchRevenue)."</td>"."</tr>";
            echo "<tr>"."<td>"."April"."</td>"."<td>".money_format('%i', $AprilRevenue)."</td>"."</tr>";
            echo "<tr>"."<td>"."May"."</td>"."<td>".money_format('%i', $MayRevenue)."</td>"."</tr>";
            echo "<tr>"."<td>"."June"."</td>"."<td>".money_format('%i', $JuneRevenue)."</td>"."</tr>";
            echo "<tr>"."<td>"."July"."</td>"."<td>".money_format('%i', $JulyRevenue)."</td>"."</tr>";
            echo "<tr>"."<td>"."August"."</td>"."<td>".money_format('%i', $AugustRevenue)."</td>"."</tr>";
            echo "<tr>"."<td>"."September"."</td>"."<td>".money_format('%i', $SeptemberRevenue)."</td>"."</tr>";
            echo "<tr>"."<td>"."October"."</td>"."<td>".money_format('%i', $OctoberRevenue)."</td>"."</tr>";
            echo "<tr>"."<td>"."November"."</td>"."<td>".money_format('%i', $NovemberRevenue)."</td>"."</tr>";
            echo "<tr>"."<td>"."December"."</td>"."<td>".money_format('%i', $DecemberRevenue)."</td>"."</tr>";
            ?>

        </table>

        <table style = "float : left;">
                <tr>
                     <th colspan = "2">
                          <h5>
                             Reviews 
                         </h5>
                     </th>
                 </tr>
                <tr>
                    <th>
                        Title
                    </th>
                    <th>
                        Reviews
                    </th>
                </tr>
                <?php

                $db = mysqli_connect('localhost','201709_471_g01','8SUH3swJoLLEHzxPNEih','201709_471_g01') or die('Error connecting to MySQL server.');

                $query = "SELECT Book.BookTitle, count(Reviews.TitleReview) AS Count FROM Book, Reviews WHERE Book.ISBN = Reviews.ISBN GROUP BY(Book.BookTitle)";
                $query1 = "SELECT Book.BookTitle FROM Book";
                mysqli_query($db, $query) or die('Error querying database.');
                mysqli_query($db, $query1) or die('Error querying database.');


                $result = mysqli_query($db, $query);
                $result1 = mysqli_query($db, $query1);
                
                while ($row1 = mysqli_fetch_array($result1)) 
                {
                    $changed = false;
                    $result = mysqli_query($db, $query);
                    while ($row = mysqli_fetch_array($result))
                    {
                        
                        if ($row['BookTitle'] == $row1['BookTitle'])
                        {
                            echo "<tr>"."<td>".$row['BookTitle']."</td>"."<td>".$row['Count']."</td>"."</tr>";
                            $changed = true;
                        }
                    }
                    if ($changed == false)
                    {
                    echo "<tr>"."<td>".$row1['BookTitle']."</td>"."<td>"."0"."</td>"."</tr>";
                    }
                    //echo $row['BookCategory']." ".$row['Count']."<br/>";
                }
                                
                ?>

            </table>
            
			<a href="S01_Welcome.php">
				<button type="button" style="margin-left : 45%; margin-top : 10px; margin-right : 45%; width: 10%">
					Exit 3-B.com
				</button>
			</a>
        </div>
        
    </body>
	
</html>