<?php
	include('../db_connect.php');

	function deleteRow($tableName, $fieldName, $fieldValue){
		$ok = false;

		$sql_1 = "DELETE FROM " . $tableName . " WHERE " . $fieldName . "=" . "'" . $fieldValue . "'";
    	$res_1 = mysql_query($sql_1);
        if ($res_1 == true) {
        	$sql_2 = "DELETE FROM Rooms_c WHERE " . $fieldName . "=" . "'" . $fieldValue . "'";
    		$res_2 = mysql_query($sql_2);
    		if ($res_2 == true){
    			$ok = true;
    		};   	
        };
        if ($ok == true) {
        	echo "<span class='success'>Обрані записи успішно видалені з бази даних.</span>";
		} else {
        	echo "<span class='error'>Сталася помилка під час видалення.</span>";
        };
	}

	if (isset($_POST['tableName']) && isset($_POST['fieldName']) && isset($_POST['fieldValue'])){
		$tableName = $_POST['tableName'];
		$fieldName = $_POST['fieldName'];
		$fieldValue = $_POST['fieldValue'];
		
		deleteRow($tableName, $fieldName, $fieldValue);
	}

?>