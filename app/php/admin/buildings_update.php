<?php
	include('../db_connect.php');

	if (isset($_POST['old_NumberOfBuilding']) && isset($_POST['QuantityOfFloors'])){
		$sql = "UPDATE Buildings SET QuantityOfFloors='" . $_POST['QuantityOfFloors'] . "' WHERE NumberOfBuilding='" . $_POST['old_NumberOfBuilding'] . "'";
		$result = mysql_query($sql);
		if ($result == true){
			$sql_1 = "SELECT QuantityOfFloors FROM Buildings WHERE NumberOfBuilding='" . $_POST['old_NumberOfBuilding'] . "'";
			$query_1 = mysql_query($sql_1);
			$row_1 = mysql_fetch_array($query_1);
			$q_of_floors = $row_1['QuantityOfFloors'];

			$sql_2 = "SELECT NumberOfAuditorium FROM Auditoriums";
			$query_2 = mysql_query($sql_2);
			if (mysql_num_rows($query_2) != 0){
				while ($row_2 = mysql_fetch_array($query_2)){
					$aud_num = $row_2['NumberOfAuditorium'];
					$floors_in_aud_num = $aud_num{2};
					if ($floors_in_aud_num > $q_of_floors){
						$sql_3 = "DELETE FROM Auditoriums WHERE NumberOfAuditorium='" . $aud_num . "'";
						$query_3 = mysql_query($sql_3);
					}
				};
			};

			$sql_3 = "SELECT Floor FROM Bathrooms";
			$query_3 = mysql_query($sql_3);
			if (mysql_num_rows($query_3) != 0){
				while ($row_3 = mysql_fetch_array($query_3)){
					if ($row_3['Floor'] > $q_of_floors){
						$sql_4 = "DELETE FROM Bathrooms WHERE NumberOfBuilding='" . $_POST['old_NumberOfBuilding'] . "'";
						$query_4 = mysql_query($sql_4);
					}
				};
			};

			$sql_5 = "SELECT * FROM Buffets";
			$query_5 = mysql_query($sql_5);
			if (mysql_num_rows($query_5) != 0){
				while ($row_5 = mysql_fetch_array($query_5)){
					if ($row_5['Floor'] > $q_of_floors){
						$sql_6 = "DELETE FROM Buffets WHERE NumberOfBuilding='" . $_POST['old_NumberOfBuilding'] . "'";
						$query_6 = mysql_query($sql_6);
					}
				};
			};

			echo "ok";
		} else {
			echo "error";
		}
	}

?>