<?php
	include('../db_connect.php');

	if (isset($_POST['fieldValue'])){
		$fv = $_POST['fieldValue'];
		$sql = "INSERT INTO Groups (NameOfGroup) VALUES ('$fv')";

		$result = mysql_query($sql);
        if ($result == true) {
            echo "<span class='success'>Група успішно додана до бази даних.</span>";
        } else {
        	echo "<span class='error'>Помилка. Мабуть група з такою назвою вже існує.</span>";
        };
	}

?>