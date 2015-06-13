<?php
	include('../db_connect.php');

	$aud = "";
	$w_show = true;
	$hasResults = false;

	if (isset($_POST["sockets"]) && isset($_POST["workplaces"])){
		$aud = "(QuantityOfSockets>='{$_POST['sockets']}') AND (QuantityOfSeats>='{$_POST['workplaces']}')";
		if ($_POST['projector'] == 1){
			$aud = $aud . " AND (PresenceOfProjector='{$_POST['projector']}')";
		};
	};

	if (strcmp($aud, "") != 0){
	    $sql = "SELECT NumberOfAuditorium FROM Auditoriums WHERE " . $aud;
	    $aud_query = mysql_query($sql);
	    if (mysql_num_rows($aud_query) > 0){
	    	for ($i=0; $i<2; $i++){
	    		$w_show = true;

	    		if ($i == 0){
	    			$week = "верхній";
	    		} else {
	    			$week = "нижній";
	    		};

	    		$j = -1;
	    		$sql = "SELECT NumberOfAuditorium FROM Auditoriums WHERE " . $aud;
	    		$aud_query = mysql_query($sql);
	    		while ($auditorium = mysql_fetch_array($aud_query)){
	    			$where = "(NumberOfAuditorium='{$auditorium['NumberOfAuditorium']}') AND (Week='$week') AND (DayOfWeek='{$_POST['day']}') AND (NumberOfDoublePeriod='{$_POST['period']}}')";
	    			$sql = "SELECT NumberOfAuditorium FROM Lessons WHERE" . $where;
	    			$lesson_query = mysql_query($sql);
			    	if (mysql_num_rows($lesson_query) == 0) {
			    		$hasResults = true;
			    		$j++;
			    		if ($w_show == true){
			    			echo "<div class='results_table_caption'><span>" . $week . "</span> тиждень</div><div class='results_table'>";
			    			$w_show = false;
			    		}

			    		$sql_aud = "SELECT QuantityOfSockets, QuantityOfSeats, PresenceOfProjector FROM Auditoriums WHERE NumberOfAuditorium='{$auditorium['NumberOfAuditorium']}'";
			    		$aud_q = mysql_query($sql_aud);
			    		$aud_2 = mysql_fetch_array($aud_q);
			    		$prj = $aud_2['PresenceOfProjector'];
			    		if ($prj == 1){
			    			$prj = "є";
			    		} else {
			    			$prj = "відсутній";
			    		}
			    		
			    		echo "<span class='row_caption'>" . $auditorium['NumberOfAuditorium'] . "</span> - розеток: <b>" . $aud_2['QuantityOfSockets'] . "</b>, місць: <b>" . $aud_2['QuantityOfSeats'] . "</b>, проектор <b>" . $prj . "</b><br>";
			    	};
	    		};
	    		echo "</div>";
		    };

		    if ($hasResults == false){
		    	echo "Нема вільної аудиторії у цей день на цій парі.";
		    };
		} else {
			echo "Аудиторій з такими параметрами нема в університеті.";
	    };
	};
?>