<?php
	include('../db_connect.php');

	if (isset($_POST['NameOfRoom']) && isset($_POST['Contacts']) && isset($_POST['NumberOfAuditorium'])){

		$fv_1 = $_POST['NameOfRoom'];
		$fv_2 = $_POST['Contacts'];
		$fv_3 = $_POST['NumberOfAuditorium'];

		$err = "<span class='error'>Помилка: ";
		$r = 0;

		$sql_1 = "SELECT * FROM Rooms WHERE NameOfRoom='" . $_POST['NameOfRoom'] . "'";
		$query_1 = mysql_query($sql_1);
		if (mysql_num_rows($query_1) != 0){
			$err .= "приміщення з такою назвою вже існує";
			$r++;
		}

		// does auditorium exist
		$sql_2 = "SELECT * FROM Auditoriums WHERE NumberOfAuditorium=" . $_POST['NumberOfAuditorium'];
		$query_2 = mysql_query($sql_2);
		if (mysql_num_rows($query_2) == 0){
			if ($r > 0){
				$err .= " та ";
			}
			$err .= "аудиторії з номером <b>" . $_POST['NumberOfAuditorium'] . "</b> не існує";
			$r++;
		};

		if ($r > 0){
			echo $err . ".</span>";
		} else {
			$ok = false;

			$sql_3 = "INSERT INTO Rooms (NameOfRoom,Contacts,NumberOfAuditorium) VALUES ('$fv_1','$fv_2','$fv_3')";
			$res_1 = mysql_query($sql_3);
	        if ($res_1 == true) {
	        	$sql_4 = "INSERT INTO Rooms_c (NameOfRoom) VALUES ('$fv_1')";
				$res_2 = mysql_query($sql_4);
				if ($res_2 == true){
	    			$ok = true;
	    		};
	    	};

	    	if ($ok == true) {
	            echo "<span class='success'>Приміщення успішно додано до бази даних.</span>";
	        } else {
	        	echo "<span class='error'>Помилка. Повторіть операцію.</span>";
	        };
		};

	}

?>