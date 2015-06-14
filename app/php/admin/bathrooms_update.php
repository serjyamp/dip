<?php
	include('../db_connect.php');

	if (isset($_POST['CodeOfBathroom']) && isset($_POST['NumberOfBuilding']) && isset($_POST['Floor']) && isset($_POST['ForMenOrWomen']) && isset($_POST['HowManyBathrooms'])){

		$sql_1 = "SELECT * FROM Buildings WHERE NumberOfBuilding='" . $_POST['NumberOfBuilding'] . "'";
		$query_1 = mysql_query($sql_1);

		if (mysql_num_rows($query_1) == 0){
			echo '<span class="error">Помилка. Корпусу з таким номером не існує.</span>';
		} else {
			$sql_2 = "SELECT * FROM Buildings WHERE (NumberOfBuilding='" . $_POST['NumberOfBuilding'] . "') AND (QuantityOfFloors>='" . $_POST['Floor'] . "')";
			$query_2 = mysql_query($sql_2);

			if (mysql_num_rows($query_2) == 0){
				echo '<span class="error">Помилка. У корпусі <b>' . $_POST['NumberOfBuilding'] . '</b> менше поверхів ніж <b>' . $_POST['Floor'] . '</b>.</span>';
			} else {
				$sql_3 = "SELECT * FROM Bathrooms WHERE (CodeOfBathroom!=" . $_POST['CodeOfBathroom'] . ") AND (NumberOfBuilding='" . $_POST['NumberOfBuilding'] . "') AND (Floor='" . $_POST['Floor'] . "') AND (ForMenOrWomen='" . $_POST['ForMenOrWomen'] . "')";
				$query_3 = mysql_query($sql_3);

				if (mysql_num_rows($query_3) == 0){

					$sql = "UPDATE Bathrooms SET NumberOfBuilding='" . $_POST['NumberOfBuilding'] . "', Floor='" . $_POST['Floor'] . "', HowManyBathrooms='" . $_POST['HowManyBathrooms'] . "' WHERE CodeOfBathroom='" . $_POST['CodeOfBathroom'] . "'";
					$result = mysql_query($sql);
					if ($result == true){
						echo "ok";
					} else {
						echo "error";
					}
				} else {
					echo '<span class="error">Помилка. Такий запис вже є у таблиці, ви можете відредагувати його.</span>';
				};
			}
		};
	}

?>