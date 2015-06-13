<?php
	include('../db_connect.php');

	$where = "";

	if (strlen($_POST['room']) != 0){
		$against = "";
		$str_trimmed = full_trim($_POST['room']);
		$words = explode(" ", $str_trimmed);
		$words_quantity = count($words);
		for ($i=0; $i < $words_quantity; $i++){
			$against .= "+" . $words[$i] . " ";
		}
		$where = "MATCH (NameOfRoom) AGAINST ('$against' IN BOOLEAN MODE)";
	};

	function full_trim($str)
	{
	    return trim(preg_replace('/\s{2,}/', ' ', $str));
	};

	if (strcmp($where, "") != 0){
	    $sql = "SELECT CodeOfRoom, NameOfRoom FROM Rooms_c WHERE " . $where;
	    $query = mysql_query($sql);
	    if (mysql_num_rows($query) > 0){
	    	while ($room=mysql_fetch_array($query)){
	    		$c = "";
	    		$aud_num = "";
	    		$building_num = "";
	    		$f = "";

	    		$sql_2 = "SELECT Contacts, NumberOfAuditorium, NumberOfBuilding, Floor FROM Rooms WHERE CodeOfRoom={$room['CodeOfRoom']}";
	    		$query_2 = mysql_query($sql_2);
	    		if (mysql_num_rows($query_2) > 0){
	    			$aud = mysql_fetch_array($query_2);
	    			$c = $aud['Contacts'];
	    			$aud_num = $aud['NumberOfAuditorium'];
	    			$building_num = $aud['NumberOfBuilding'];
	    			$f = $aud['Floor'];
	    		};
	    		
	    		$contacts = "";
	    		$number_of_auditorium = "";
	    		$number_of_building = "";
	    		$floor = "";
	    		$both = "інформація про це приміщення відсутня";
	    		$k = 0;

	    		if (strcmp($c, "") != 0){
	    			$contacts = $c . '<br>';
	    			$k++;
	    		};
	    		if (empty($building_num) == false){
	    			$number_of_building = "<b>" . $building_num . "</b> корпус<br>";
	    			$k++;
	    		};
	    		if (empty($f) == false){
	    			$floor = "<b>" . $f . "</b> поверх<br>";
	    			$k++;
	    		};
	    		if (empty($aud_num) == false){
	    			$number_of_auditorium = "аудиторія <b>" . $aud_num . "</b>";
	    			$k++;
	    		};
	    		
	    		if ($k == 0){
	    			echo "<div class='room_result'><span class='row_caption'>" . $room['NameOfRoom'] . "</span><br>" . $both . "</div>";
	    		} else {
	    			echo "<div class='room_result'><span class='row_caption'>" . $room['NameOfRoom'] . "</span><br>" . $contacts . $number_of_building . $floor . $number_of_auditorium . "</div>";
	    		};
	    	};
		} else {
			echo "По даному запиту нічого не знайдено.";
	    };
	};
?>