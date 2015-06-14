<?php
	include('../db_connect.php');

	function deleteRow($tableName, $fieldName, $fieldValue){
		$sql = "DELETE FROM " . $tableName . " WHERE " . $fieldName . "=" . "'" . $fieldValue . "'";
    	$result = mysql_query($sql);
        if ($result == true) {
        	$sql_1 = "SELECT NumberOfAuditorium FROM Auditoriums";
        	$query_1 = mysql_query($sql_1);
        	if (mysql_num_rows($query_1) > 0){
	        	while ($row = mysql_fetch_array($query_1)){
	        		$num_of_auditorium = $row['NumberOfAuditorium'];
	        		$num_of_building = $num_of_auditorium{0};

	        		if ($num_of_building == $fieldValue){
	        			$sql_2 = "DELETE FROM Auditoriums WHERE NumberOfAuditorium='" . $num_of_auditorium . "'";
	    				$query_2 = mysql_query($sql_2);
	        		}
	        	};
        	}
        	
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