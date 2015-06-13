<?php
	include('../db_connect.php');

	if (isset($_POST['old_NumberOfBuilding']) && isset($_POST['NumberOfBuilding']) && isset($_POST['QuantityOfFloors'])){
		$sql = "UPDATE Buildings SET NumberOfBuilding='" . $_POST['NumberOfBuilding'] . "', QuantityOfFloors='" . $_POST['QuantityOfFloors'] . "' WHERE NumberOfBuilding='" . $_POST['old_NumberOfBuilding'] . "'";
		$result = mysql_query($sql);
		if ($result == true){
			echo "ok";
		} else {
			echo "error";
		}
	}

?>