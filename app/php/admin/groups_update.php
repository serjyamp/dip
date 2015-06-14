<?php
	include('../db_connect.php');

	if (isset($_POST['old_NameOfGroup']) && isset($_POST['NameOfGroup'])){
		$sql = "UPDATE Groups SET NameOfGroup='" . $_POST['NameOfGroup'] . "' WHERE NameOfGroup='" . $_POST['old_NameOfGroup'] . "'";
		$result = mysql_query($sql);
		if ($result == true){
			echo "ok";
		} else {
			echo "error";
		};
	};

?>