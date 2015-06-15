<?php
	include('../db_connect.php');

	if (isset($_POST['old_NumberOfAuditorium']) && isset($_POST['NumberOfAuditorium']) && isset($_POST['QuantityOfSockets']) && isset($_POST['QuantityOfSeats']) && isset($_POST['PresenceOfProjector'])){

		$aud_num = $_POST['NumberOfAuditorium'];
		$sql_1 = "SELECT * FROM Buildings WHERE NumberOfBuilding=" . $aud_num{0};
		$query = mysql_query($sql_1);
		if (mysql_num_rows($query) != 0){
			$sql_2 = "SELECT * FROM Buildings WHERE (NumberOfBuilding=" . $aud_num{0} . ") AND (QuantityOfFloors>=" . $aud_num{2} . ")";
			$query_2 = mysql_query($sql_2);
			if (mysql_num_rows($query_2) != 0){
				$sql = "UPDATE Auditoriums SET NumberOfAuditorium='" . $_POST['NumberOfAuditorium'] . "', QuantityOfSockets='" . $_POST['QuantityOfSockets'] . "', QuantityOfSeats='" . $_POST['QuantityOfSeats'] . "', PresenceOfProjector='" . $_POST['PresenceOfProjector'] . "' WHERE NumberOfAuditorium='" . $_POST['old_NumberOfAuditorium'] . "'";
				$result = mysql_query($sql);
				if ($result == true){
					echo "ok";
				} else {
					echo "error";
				}
			} else {
				echo "<span class='error'>Помилка. У корпусі <b>" . $aud_num{0} . "</b> менше поверхів ніж <b>" . $aud_num{2} . "</b>.</span>";
			}
		} else {
			echo "Помилка. Неможливо додати аудиторію тому що корпуса з номером <b>" . $aud_num{0} . "</b> не існує.";
		};
	}

?>