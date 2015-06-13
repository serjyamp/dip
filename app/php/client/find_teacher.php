<?php
	include('../db_connect.php');

	$ln = "";
	$nm = "";
	$pc = "";
	$one = 0;
	$two = 0;

	if (strlen($_POST['lastname']) != 0){
		$ln = "(LastnameOfTeacher='{$_POST['lastname']}')";
		$one = 1;
	}
	if (strlen($_POST['name']) != 0){
		if ($one == 1){
			$nm = " AND (NameOfTeacher='{$_POST['name']}')";
		} else {
			$nm = "(NameOfTeacher='{$_POST['name']}')";
		}
		$two = 1;
	}
	if (strlen($_POST['patronymic']) != 0){
		if ($one == 1 || $two == 1){
			$pp = " AND (PatronymicOfTeacher='{$_POST['patronymic']}')";
		} else {
			$pp = "(PatronymicOfTeacher='{$_POST['patronymic']}')";
		}
	}
	$where = $ln . $nm . $pp;
	if (strcmp($where, "") != 0){
		$teachersWithoutLessons[] = "";
	    $hasResults = false;
	    $showName = true;
	 	$sql = "SELECT CodeOfTeacher, LastnameOfTeacher, NameOfTeacher, PatronymicOfTeacher FROM Teachers WHERE " . $where;
	 	$teacher_query = mysql_query($sql);
	    if (mysql_num_rows($teacher_query) > 0) {
		    	while ($teacher = mysql_fetch_array($teacher_query)){
		    		$showName = true;
		    		$hasResults = false;
			    	for ($i=0; $i<2; $i++){
			    		if ($i == 0){
			    			$week = "верхній";
			    		} else {
			    			$week = "нижній";
			    		};
					    $where = "(CodeOfTeacher={$teacher['CodeOfTeacher']}) AND (DayOfWeek='{$_POST['day']}') AND (Week='$week')";
					    $sql = "SELECT CodeOfSubject, NameOfGroup, NumberOfAuditorium, NumberOfDoublePeriod, Week FROM Lessons WHERE " . $where;
					    $lesson_query = mysql_query($sql);
					    if (mysql_num_rows($lesson_query) > 0){
					    	if ($showName == true){
					    		echo "<span class='row_caption'><b>№" . $teacher['CodeOfTeacher'] . " у базі:</b> " . $teacher['LastnameOfTeacher'] . " " . $teacher['NameOfTeacher'] . " " . $teacher['PatronymicOfTeacher'] . "</span><br>";
					    		$showName = false;
					    	};
					    	$hasResults = true;
					    	echo "<div class='results_table_caption'><span>" . $week . "</span> тиждень</div><div class='results_table'>";
					    	while($lesson = mysql_fetch_array($lesson_query)){
					    		$subject_sql = "SELECT NameOfSubject FROM Subjects WHERE CodeOfSubject={$lesson['CodeOfSubject']}";
					    		$subject = mysql_fetch_array(mysql_query($subject_sql));
					    		echo "<div><div class='lesson_header'>" . $lesson['NumberOfDoublePeriod'] . " пара</div>" . $subject['NameOfSubject'] . "<br><b>" . $lesson['NumberOfAuditorium'] . "</b><br>" . "група " . $lesson['NameOfGroup'] . "</div>";
					    	};
					    	echo "</div>";
					    };
			    	};
			    	if ($hasResults == false) {
			    		$teachersWithoutLessons[] = "<span class='row_caption'><b>№" . $teacher['CodeOfTeacher'] . " у базі:</b> " . $teacher['LastnameOfTeacher'] . " " . $teacher['NameOfTeacher'] . " " . $teacher['PatronymicOfTeacher'] . "</span>";
				    };
		    	};

		    	array_shift($teachersWithoutLessons);
		    	$teachersWL_count = count($teachersWithoutLessons);
		    	if ($teachersWL_count > 0){
			    	if ($teachersWL_count > 1){
			    		$ending = "ів";
			    	} else {
			    		$ending = "а";
			    	};
			    	echo "<div class='teachers_no'>У викладач" . $ending . " ";
			    	for ($i=0; $i<$teachersWL_count; $i++){
			    		if ($i !=$teachersWL_count-1){
			    			echo $teachersWithoutLessons[$i] . ", ";		
			    		} else {
			    			echo $teachersWithoutLessons[$i];	
			    		}
			    	};
			    	echo " нема занять у цей день.</div>";
		    	}
		    } else {
		    	echo "Викладача не існує у базі даних.";
		    };
	};
?>