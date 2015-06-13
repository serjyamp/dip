<?php
	include('../db_connect.php');

	$aud = "";
	$where = "";
	$hasResults = false;

	if (strlen($_POST['auditorium']) != 0){
		$aud = "(NumberOfAuditorium='{$_POST['auditorium']}')";
	};
	
	if (strcmp($aud, "") != 0){
	    $sql = "SELECT NumberOfAuditorium FROM Auditoriums WHERE " . $aud;
	    $aud_query = mysql_query($sql);
	    if (mysql_num_rows($aud_query) > 0){
	    	for ($i=0; $i<2; $i++){
	    		if ($i == 0){
	    			$week = "верхній";
	    		} else {
	    			$week = "нижній";
	    		};
		    	$where = $aud . " AND (DayOfWeek='{$_POST['day']}')" . " AND (Week='$week')";
			 	$sql = "SELECT CodeOfSubject, CodeOfTeacher, NameOfGroup, NumberOfDoublePeriod, Week FROM Lessons WHERE " . $where;
			 	$lesson_query = mysql_query($sql);
			    if (mysql_num_rows($lesson_query) > 0) {
			    	$hasResults = true;
				    echo "<div class='results_table_caption'><span>" . $week . "</span> тиждень</div><div class='results_table'>";
			    	while ($lesson = mysql_fetch_array($lesson_query)){
			    		$subject_sql = "SELECT NameOfSubject FROM Subjects WHERE CodeOfSubject={$lesson['CodeOfSubject']}";
			    		$subject = mysql_fetch_array(mysql_query($subject_sql));

			    		$teacher_sql = "SELECT LastnameOfTeacher, NameOfTeacher, PatronymicOfTeacher FROM Teachers WHERE CodeOfTeacher={$lesson['CodeOfTeacher']}";
			    		$teacher = mysql_fetch_array(mysql_query($teacher_sql));

			    		echo "<div><div class='lesson_header'>" . $lesson['NumberOfDoublePeriod'] . " пара</div>" . $subject['NameOfSubject'] . "<br><b><span class='b_mini'>група</span> " . $lesson['NameOfGroup'] . "</b><br>" .  $teacher['LastnameOfTeacher'] . " " . $teacher['NameOfTeacher'] . " " . $teacher['PatronymicOfTeacher'] . "</div>";
			    	};
			    	echo "</div>";
			    };
		    };
		    if ($hasResults == false) {
		    	echo "В аудиторії нема занять у цей день.";
		    };
		} else {
			echo "Аудиторії не існує у базі даних.";
	    };
	};
?>