<?php
	include('../db_connect.php');

	if (isset($_POST['HowManyBathrooms']) && isset($_POST['ForMenOrWomen']) && isset($_POST['NumberOfBuilding']) && isset($_POST['Floor'])){
		$fv_1 = $_POST['HowManyBathrooms'];
		$fv_2 = $_POST['ForMenOrWomen'];
		$fv_3 = $_POST['NumberOfBuilding'];
		$fv_4 = $_POST['Floor'];

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
				$sql_3 = "SELECT * FROM Bathrooms WHERE (NumberOfBuilding='" . $_POST['NumberOfBuilding'] . "') AND (Floor='" . $_POST['Floor'] . "') AND (ForMenOrWomen='" . $_POST['ForMenOrWomen'] . "')";
				$query_3 = mysql_query($sql_3);

				if (mysql_num_rows($query_3) == 0){

					$sql = "INSERT INTO Bathrooms (HowManyBathrooms,ForMenOrWomen,NumberOfBuilding,Floor) VALUES ('$fv_1','$fv_2','$fv_3','$fv_4')";
					$result = mysql_query($sql);
					if ($result == true){
						echo "<span class='success'>Вбиральні успішно додані до бази даних.</span>";
			        } else {
			        	echo "<span class='error'>Помилка. Мабуть такий запис вже є у таблиці.</span>";
					}
				} else {
					echo '<span class="error">Помилка. Такий запис вже є у таблиці, ви можете відредагувати його.</span>';
				};
			};
		};
	};

?>