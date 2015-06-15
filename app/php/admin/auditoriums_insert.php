<?php
	include('../db_connect.php');

	if (isset($_POST['f_input_number_of_auditorium']) && isset($_POST['f_input_sockets']) && isset($_POST['f_input_workplaces']) && isset($_POST['projector'])){

		$fv_1 = $_POST['f_input_number_of_auditorium'];
		$fv_2 = $_POST['f_input_sockets'];
		$fv_3 = $_POST['f_input_workplaces'];
		$fv_4 = $_POST['projector'];

		$sql_1 = "SELECT * FROM Buildings WHERE NumberOfBuilding=" . $fv_1{0};
		$query_1 = mysql_query($sql_1);
		if (mysql_num_rows($query_1) != 0){
			$sql_2 = "SELECT * FROM Buildings WHERE (NumberOfBuilding=" . $fv_1{0} . ") AND (QuantityOfFloors>=" . $fv_1{2} . ")";
			$query_2 = mysql_query($sql_2);
			if (mysql_num_rows($query_2) != 0){
				$sql = "INSERT INTO Auditoriums (NumberOfAuditorium,QuantityOfSockets,QuantityOfSeats,PresenceOfProjector) VALUES ('$fv_1','$fv_2','$fv_3','$fv_4')";

				$result = mysql_query($sql);
		        if ($result == true) {
		            echo "<span class='success'>Аудиторія успішно додана до бази даних.</span>";
		        } else {
		        	echo "<span class='error'>Помилка. Мабуть аудиторія з таким номером вже існує.</span>";
		        };
			} else {
				echo "<span class='error'>Помилка. У корпусі <b>" . $fv_1{0} . "</b> менше поверхів ніж <b>" . $fv_1{2} . "</b>.</span>";
			}
		} else {
			echo "<span class='error'>Помилка. Неможливо додати аудиторію тому що корпуса з номером <b>" . $fv_1{0} . "</b> не існує.</span>";
		};

	}

?>