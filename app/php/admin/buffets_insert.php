<?php
	include('../db_connect.php');

	if (isset($_POST['NameOfBuffet']) && isset($_POST['BusinessHours']) && isset($_POST['NumberOfBuilding']) && isset($_POST['Floor'])){
		$fv_1 = $_POST['NameOfBuffet'];
		$fv_2 = $_POST['BusinessHours'];
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
				$sql_3 = "SELECT * FROM Buffets WHERE (NameOfBuffet='" . $_POST['NameOfBuffet'] . "') AND (NumberOfBuilding='" . $_POST['NumberOfBuilding'] . "') AND (Floor='" . $_POST['Floor'] . "')";
				$query_3 = mysql_query($sql_3);

				if (mysql_num_rows($query_3) == 0){
					$sql = "INSERT INTO Buffets (NameOfBuffet,BusinessHours,NumberOfBuilding,Floor) VALUES ('$fv_1','$fv_2','$fv_3','$fv_4')";
					$result = mysql_query($sql);
			        if ($result == true) {
			            echo "<span class='success'>Буфет успішно додано до бази даних.</span>";
			        } else {
			        	echo "<span class='error'>Помилка. Мабуть такий буфет вже існує.</span>";
			        };
			    } else {
			    	echo '<span class="error">Помилка. Буфет з такою назвою вже існує у цьому корпусі та на цьому поверсі.</span>';
			    }
			};
		};
	};

?>