<?php
		$k = "<span class='error'>Помилка. Не існує ";
		$c = 0;

		$sql_1 = "SELECT CodeOfSubject FROM Subjects WHERE CodeOfSubject='{$_POST['CodeOfSubject']}'";
		$query_1 = mysql_query($sql_1);
		if (mysql_num_rows($query_1) == 0){
			$k .= "предмета з кодом <b>" . $_POST['CodeOfSubject'] . "</b>";
			$c++;
		};

		$sql_2 = "SELECT * FROM Teachers WHERE CodeOfTeacher=" . $_POST['CodeOfTeacher'];
		$query_2 = mysql_query($sql_2);
		if (mysql_num_rows($query_2) == 0){
			if ($c != 0){
				$k .= ", викладача з кодом <b>" . $_POST['CodeOfTeacher'] . "</b>";
 			} else {
 				$k .= "викладача з кодом <b>" . $_POST['CodeOfTeacher'] . "</b>";
 			}
 			$c++;
		};

		$sql_3 = "SELECT NameOfGroup FROM Groups WHERE NameOfGroup='" . $_POST['NameOfGroup'] . "'";
		$query_3 = mysql_query($sql_3);
		if (mysql_num_rows($query_3) == 0){
			if ($c != 0){
				$k .= ", групи з назвою <b>" . $_POST['NameOfGroup'] . "</b>";
 			} else {
 				$k .= "групи з назвою <b>" . $_POST['NameOfGroup'] . "</b>";
 			}
 			$c++;
		};

		$sql_4 = "SELECT * FROM Auditoriums WHERE NumberOfAuditorium=" . $_POST['NumberOfAuditorium'];
		$query_4 = mysql_query($sql_4);
		if (mysql_num_rows($query_4) == 0){
			if ($c != 0){
				$k .= ", аудиторії з номером <b>" . $_POST['NumberOfAuditorium'] . "</b>";
 			} else {
 				$k .= "аудиторії з номером <b>" . $_POST['NumberOfAuditorium'] . "</b>";
 			}
 			$c++;
		};

		$k .= ".</span>";
?>