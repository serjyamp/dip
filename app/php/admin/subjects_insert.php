<?php
	include('../db_connect.php');

	if (isset($_POST['NameOfSubject'])){
		$fv_1 = $_POST['NameOfSubject'];

		$sql_1 = "SELECT * FROM Subjects WHERE NameOfSubject='" . $fv_1 . "'";
		$query = mysql_query($sql_1);
		if (mysql_num_rows($query) == 0){
			$sql = "INSERT INTO Subjects (NameOfSubject) VALUES ('$fv_1')";
			$result = mysql_query($sql);
	        if ($result == true) {
	            echo "<span class='success'>Предмет успішно додано до бази даних.</span>";
	        } else {
	        	echo "<span class='error'>Помилка. Повторіть операцію.</span>";
	        };
		} else {
			echo '<span class="error">Помилка. Предмет з назвою <b>"' . $fv_1 . '"</b> вже існує.</span>';
		};
	}

?>