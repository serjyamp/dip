<?php
	include('../db_connect.php');

	if (isset($_POST['oldVal']) && isset($_POST['newVal'])){
		$sql = "UPDATE Groups SET NameOfGroup='" . $_POST['newVal'] . "' WHERE NameOfGroup='" . $_POST['oldVal'] . "'";
		$result = mysql_query($sql);
		if ($result == true){
			echo "ok";
		} else {
			echo "error";
		}
	}

?>