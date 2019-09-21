<?php 

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
}
	if (isset($_POST['update_profile']))
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

        //echo $_SESSION['UserInfo']['CustomerUsername'];
        header("Location: http://db2.emich.edu/~201709_cosc471_group01/S02_Search.php");
        //echo $newpin." ".$retypenew_pin." ".$firstname." ".$lastname." ".$address." ".$city." ".$state." ".$zip." ".$creditcard." ".$cardnumber." ".$expirationdate;
    }
    
?>