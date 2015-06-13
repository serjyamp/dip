<?php
	include('../db_connect.php');

	if (isset($_POST['field_building_number']) && isset($_POST['field_building_floors'])){
		$fv_1 = $_POST['field_building_number'];
		$fv_2 = $_POST['field_building_floors'];
		$sql = "INSERT INTO Buildings (NumberOfBuilding,QuantityOfFloors) VALUES ('$fv_1','$fv_2')";

		$result = mysql_query($sql);
        if ($result == true) {
            echo "<span class='success'>Корпус успішно додан до бази даних.</span>";
        } else {
        	echo "<span class='error'>Помилка. Мабуть корпус з таким номером вже існує.</span>";
        };
	}

?>