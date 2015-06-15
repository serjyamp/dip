<?php
	include('../db_connect.php');

	if (isset($_POST['CodeOfRoom']) && isset($_POST['NameOfRoom']) && isset($_POST['Contacts']) && isset($_POST['NumberOfAuditorium'])){

		$err = "Помилка: ";
		$r = 0;

		// does auditorium exist
		$sql_3 = "SELECT * FROM Auditoriums WHERE NumberOfAuditorium=" . $_POST['NumberOfAuditorium'];
		$query_3 = mysql_query($sql_3);
		if (mysql_num_rows($query_3) == 0){
			$err .= "аудиторії з номером <b>" . $_POST['NumberOfAuditorium'] . "</b> не існує";
			$r++;
		}

		//

		if ($r > 0){
			echo $err . ".";
		} else {
			$sql_5 = "SELECT * FROM Rooms WHERE (CodeOfRoom!='" . $_POST['CodeOfRoom'] . "') AND (NameOfRoom='" . $_POST['NameOfRoom'] . "')";
			$query_5 = mysql_query($sql_5);
			if (mysql_num_rows($query_5) != 0){
				echo "Помилка. Приміщення з такою назвою вже існує.";
			} else {
				$count_of_ok = 0;

				$sql_1 = "UPDATE Rooms SET NameOfRoom='" . $_POST['NameOfRoom'] . "', Contacts='" . $_POST['Contacts'] . "', NumberOfAuditorium='" . $_POST['NumberOfAuditorium'] . "' WHERE CodeOfRoom='" . $_POST['CodeOfRoom'] . "'";

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