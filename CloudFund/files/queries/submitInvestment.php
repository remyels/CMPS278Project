<?php

try {
	
	include '../../connect/connectPDO.php';
	include '../../connect/sessionCheck.php';

	if (isset($_REQUEST['VALUE'])&&!empty($_REQUEST['VALUE'])
		&&isset($_REQUEST['LISTINGID'])&&!empty($_REQUEST['LISTINGID'])) {

		$value = $db->quote($_REQUEST['VALUE']);
		$listingid = $db->quote($_REQUEST['LISTINGID']);
		
		$userid = $_SESSION['LoggedInUserID'];
		
		// if we are here, then that means that the investment is ready to be processed
		$query = "INSERT INTO investment(ListingID, UserID, AmountInvested) VALUES ($listingid, $userid, $value);";
		
		$db->exec($query);	
	}
} catch (PDOException $e) {} 

?>