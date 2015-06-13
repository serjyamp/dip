<?php
	include('../db_connect.php');

	if (isset($_POST['f_input_number_of_auditorium']) && isset($_POST['f_input_sockets']) && isset($_POST['f_input_workplaces']) && isset($_POST['projector'])){

		$fv_1 = $_POST['f_input_number_of_auditorium'];
		$fv_2 = $_POST['f_input_sockets'];
		$fv_3 = $_POST['f_input_workplaces'];
		$fv_4 = $_POST['projector'];

		$sql_1 = "SELECT * FROM Buildings WHERE NumberOfBuilding=" . $fv_1{0};
		$query = mysql_query($sql_1);
		if (mysql_num_rows($query) != 0){
			$sql = "INSERT INTO Auditoriums (NumberOfAuditorium,QuantityOfSockets,QuantityOfSeats,PresenceOfProjector) VALUES ('$fv_1','$fv_2','$fv_3','$fv_4')";

			$result = mysql_query($sql);
	        if ($result == true) {
	            echo "<span class='success'>Аудиторія успішно додана до бази даних.</span>";
	        } else {
	        	echo "<span class='error'>Помилка. Мабуть аудиторія з таким номером вже існує.</span>";
	        };
		} else {
			echo "<span class='error'>Помилка. Неможливо додати аудиторію тому що корпуса з номером <b>" . $fv_1{0} . "</b> не існує.</span>";
		};

	}

?>