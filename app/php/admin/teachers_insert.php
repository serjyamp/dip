<?php
	include('../db_connect.php');

	if (isset($_POST['lastname']) && isset($_POST['name']) && isset($_POST['patronymic'])){
		$fv_1 = $_POST['lastname'];
		$fv_2 = $_POST['name'];
		$fv_3 = $_POST['patronymic'];

		$sql = "INSERT INTO Teachers (LastnameOfTeacher,NameOfTeacher,PatronymicOfTeacher) VALUES ('$fv_1','$fv_2','$fv_3')";

		$result = mysql_query($sql);
        if ($result == true) {
            echo "<span class='success'>Викладача успішно додано до бази даних.</span>";
        } else {
        	echo "<span class='error'>Помилка. Повторіть операцію.</span>";
        };
	}

?>