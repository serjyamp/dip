<?php
	include('../db_connect.php');

	function deleteRow($tableName, $fieldName, $fieldValue){
		$sql = "DELETE FROM " . $tableName . " WHERE " . $fieldName . "=" . "'" . $fieldValue . "'";
    	$result = mysql_query($sql);
        if ($result == true) {
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