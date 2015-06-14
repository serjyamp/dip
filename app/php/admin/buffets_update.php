<?php
	include('../db_connect.php');

	if (isset($_POST['CodeOfBuffet']) && isset($_POST['NameOfBuffet']) && isset($_POST['BusinessHours']) && isset($_POST['NumberOfBuilding']) && isset($_POST['Floor'])){

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
				$sql_3 = "SELECT * FROM Buffets WHERE (CodeOfBuffet!=" . $_POST['CodeOfBuffet'] . ") AND (NameOfBuffet='" . $_POST['NameOfBuffet'] . "') AND (NumberOfBuilding='" . $_POST['NumberOfBuilding'] . "') AND (Floor='" . $_POST['Floor'] . "')";
				$query_3 = mysql_query($sql_3);

				if (mysql_num_rows($query_3) == 0){

					$sql = "UPDATE Buffets SET NameOfBuffet='" . $_POST['NameOfBuffet'] . "', NumberOfBuilding='" . $_POST['NumberOfBuilding'] . "', BusinessHours='" . $_POST['BusinessHours'] . "', Floor='" . $_POST['Floor'] . "' WHERE CodeOfBuffet='" . $_POST['CodeOfBuffet'] . "'";
					$result = mysql_query($sql);
					if ($result == true){
						echo "ok";
					} else {
						echo "error";
					}

				} else {
					echo '<span class="error">Помилка. Буфет з такою назвою вже існує у цьому корпусі та на цьому поверсі.</span>';
				};
			}
		};
	}

?>