<?php
	include('../db_connect.php');

	if (isset($_POST['CodeOfTeacher']) && isset($_POST['LastnameOfTeacher']) && isset($_POST['NameOfTeacher']) && isset($_POST['PatronymicOfTeacher'])){
		
		$sql = "UPDATE Teachers SET LastnameOfTeacher='" . $_POST['LastnameOfTeacher'] . "', NameOfTeacher='" . $_POST['NameOfTeacher'] . "', PatronymicOfTeacher='" . $_POST['PatronymicOfTeacher'] . "' WHERE CodeOfTeacher='" . $_POST['CodeOfTeacher'] . "'";
		$result = mysql_query($sql);
		if ($result == true){
			echo "ok";
		} else {
			echo "error";
		}
	}

?>