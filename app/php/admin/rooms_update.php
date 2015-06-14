<?php
	include('../db_connect.php');

	if (isset($_POST['CodeOfRoom']) && isset($_POST['NameOfRoom']) && isset($_POST['Contacts']) && isset($_POST['NumberOfAuditorium']) && isset($_POST['NumberOfBuilding']) && isset($_POST['Floor'])){

		$Contacts_set = "Contacts='" . $_POST['Contacts'] . "'";
		$NumberOfAuditorium_set = "";
		$NumberOfBuilding_set = "";
		$Floor_set = "";

		// check input data
		$err = "Помилка: ";
		$err_length = strlen($err);
		$r = 0;

		// has NumberOfAuditorium been set
		$aud_numbers = $_POST['NumberOfAuditorium'];
		$aud_numbers = preg_replace('~\D+~','',$aud_numbers);
		if (strlen($aud_numbers) != 0){
			$sql_3 = "SELECT * FROM Auditoriums WHERE NumberOfAuditorium=" . $_POST['NumberOfAuditorium'];
			$query_3 = mysql_query($sql_3);
			if (mysql_num_rows($query_3) == 0){
				$err .= "аудиторії з номером <b>" . $_POST['NumberOfAuditorium'] . "</b> не існує";
				$r++;
			} else {
				$NumberOfAuditorium_set .= ", NumberOfAuditorium='" . $_POST['NumberOfAuditorium'] . "'";
			}
		} else {
			$NumberOfAuditorium_set .= ", NumberOfAuditorium='0'";
		}

		// does NumberOfBuilding exist
		$building_exists = true;

		$sql_3 = "SELECT * FROM Buildings WHERE NumberOfBuilding='" . $_POST['NumberOfBuilding'] . "'";
		$query_3 = mysql_query($sql_3);
		if (mysql_num_rows($query_3) == 0){
			if ($r != 0){
				$err .= ", ";
			}
			$err .= "корпусу з номером <b>" . $_POST['NumberOfBuilding'] . "</b> не існує.";
			$building_exists = false;
		} else {
			$NumberOfBuilding_set .= ", NumberOfBuilding='" . $_POST['NumberOfBuilding'] . "'";
		};

		// does Floor exist
		if ($building_exists == true){
			$sql_4 = "SELECT * FROM Buildings WHERE (NumberOfBuilding='" . $_POST['NumberOfBuilding'] . "') AND (QuantityOfFloors>='" . $_POST['Floor'] . "')";
			$query_4 = mysql_query($sql_4);
			if (mysql_num_rows($query_4) == 0){
				if ($r != 0){
					$err .= ", ";
				}
				$err .= "у корпусі <b>" . $_POST['NumberOfBuilding'] . "</b> менше поверхів ніж <b>" . $_POST['Floor'] . "</b>";
			} else {
				$Floor_set .= ", Floor='" . $_POST['Floor'] . "'";
			};
		};

		if (strlen($err) > $err_length){
			echo $err . ".";
		} else {
			$sql_5 = "SELECT * FROM Rooms WHERE (CodeOfRoom!='" . $_POST['CodeOfRoom'] . "') AND (NameOfRoom='" . $_POST['NameOfRoom'] . "')";
			$query_5 = mysql_query($sql_5);
			if (mysql_num_rows($query_5) != 0){
				echo "Помилка. Приміщення з такою назвою вже існує.";
			} else {
				$count_of_ok = 0;

				$sql_1 = "UPDATE Rooms SET NameOfRoom='" . $_POST['NameOfRoom'] . "', " . $Contacts_set . $NumberOfAuditorium_set . $NumberOfBuilding_set . $Floor_set . " WHERE CodeOfRoom='" . $_POST['CodeOfRoom'] . "'";

				$res_1 = mysql_query($sql_1);
				if ($res_1 == true){
					$count_of_ok++;
				}

				$sql_2 = "UPDATE Rooms_c SET NameOfRoom='" . $_POST['NameOfRoom'] . "' WHERE CodeOfRoom='" . $_POST['CodeOfRoom'] . "'";
				$res_2 = mysql_query($sql_2);
				if ($res_2 == true){
					$count_of_ok++;
				}

				if ($count_of_ok == 2){
					echo "ok";
				} else {
					echo "error";
				}
			}
		}

	}
?>