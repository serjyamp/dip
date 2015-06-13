<?php
	include('../db_connect.php');

	if (isset($_POST['CodeOfSubject']) && isset($_POST['NameOfSubject'])){
		$sql_1 = "SELECT * FROM Subjects WHERE (CodeOfSubject!=" . $_POST['CodeOfSubject'] . ") AND (NameOfSubject='" . $_POST['NameOfSubject'] . "')";
		$query = mysql_query($sql_1);
		if (mysql_num_rows($query) == 0){
			$sql = "UPDATE Subjects SET NameOfSubject='" . $_POST['NameOfSubject'] . "' WHERE CodeOfSubject='" . $_POST['CodeOfSubject'] . "'";
			$result = mysql_query($sql);
			if ($result == true){
				echo "ok";
			} else {
				echo "error";
			}
		} else {
			echo '<span class="error">Помилка. Предмет з назвою <b>"' . $_POST['NameOfSubject'] . '"</b> вже існує.</span>';
		};
	}

?>