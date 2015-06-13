<?php
	include('../db_connect.php');

	if (isset($_POST['CodeOfSubject']) && isset($_POST['CodeOfTeacher']) && isset($_POST['NameOfGroup']) && isset($_POST['NumberOfAuditorium']) && isset($_POST['DayOfWeek']) && isset($_POST['NumberOfDoublePeriod']) && isset($_POST['Week'])){

		$fv_1 = $_POST['CodeOfSubject'];
		$fv_2 = $_POST['CodeOfTeacher'];
		$fv_3 = $_POST['NameOfGroup'];
		$fv_4 = $_POST['NumberOfAuditorium'];
		$fv_5 = $_POST['DayOfWeek'];
		$fv_6 = $_POST['NumberOfDoublePeriod'];
		$fv_7 = $_POST['Week'];

		include('_shared_lessons.php');

		if ($c != 0){
			echo $k;
		} else {
			$ok = 1;
			$nextChecking = 1;

			// does group have lesson on this double period?
			$sql_5 = "SELECT * FROM Lessons WHERE (NameOfGroup='" . $_POST['NameOfGroup'] . "') AND (DayOfWeek='" . $_POST['DayOfWeek'] . "') AND (NumberOfDoublePeriod='" . $_POST['NumberOfDoublePeriod'] . "') AND (Week='" . $_POST['Week'] . "')";
			$query_5 = mysql_query($sql_5);
			if (mysql_num_rows($query_5) != 0){
				echo "<span class='error'>Помилка. Ця група вже має заняття у такий час.</span>";
				$ok = 0;
				$nextChecking = 0;
			};

			// a few groups have the same lesson
			if ($nextChecking == 1){
				$sql_6 = "SELECT * FROM Lessons WHERE (NumberOfAuditorium='" . $_POST['NumberOfAuditorium'] . "') AND (DayOfWeek='" . $_POST['DayOfWeek'] . "') AND (NumberOfDoublePeriod='" . $_POST['NumberOfDoublePeriod'] . "') AND (Week='" . $_POST['Week'] . "')";
				$query_6 = mysql_query($sql_6);
				if (mysql_num_rows($query_6) != 0){
					$r = mysql_fetch_array($query_6);
					if ($r['CodeOfSubject'] != $_POST['CodeOfSubject'] || $r['CodeOfTeacher'] != $_POST['CodeOfTeacher']){
						echo "<span class='error'>Помилка. Ця аудиторія зайнята у такий час.</span>";
						$ok = 0;
					}
				};
			};

			if ($ok == 1){
				$sql = "INSERT INTO Lessons (CodeOfSubject,CodeOfTeacher,NameOfGroup,NumberOfAuditorium,DayOfWeek,NumberOfDoublePeriod,Week) VALUES ('$fv_1','$fv_2','$fv_3','$fv_4','$fv_5','$fv_6','$fv_7')";

				$result = mysql_query($sql);
		        if ($result == true) {
		            echo "<span class='success'>Заняття успішно додано до бази даних.</span>";
		        } else {
		        	echo "<span class='error'>Помилка. Мабуть таке заняття вже існує.</span>";
		        };
			};
		};
	}

?>