<?php
	include('../db_connect.php');

	if (isset($_POST['old_NumberOfAuditorium']) && isset($_POST['NumberOfAuditorium']) && isset($_POST['QuantityOfSockets']) && isset($_POST['QuantityOfSeats']) && isset($_POST['PresenceOfProjector'])){

		$aud_num = $_POST['NumberOfAuditorium'];
		$sql_1 = "SELECT * FROM Buildings WHERE NumberOfBuilding=" . $aud_num{0};
		$query = mysql_query($sql_1);
		if (mysql_num_rows($query) != 0){
			$sql = "UPDATE Auditoriums SET NumberOfAuditorium='" . $_POST['NumberOfAuditorium'] . "', QuantityOfSockets='" . $_POST['QuantityOfSockets'] . "', QuantityOfSeats='" . $_POST['QuantityOfSeats'] . "', PresenceOfProjector='" . $_POST['PresenceOfProjector'] . "' WHERE NumberOfAuditorium='" . $_POST['old_NumberOfAuditorium'] . "'";
			$result = mysql_query($sql);
			if ($result == true){
				echo "ok";
			} else {
				echo "error";
			}
		} else {
			echo $aud_num{0};
		};
	}

?>