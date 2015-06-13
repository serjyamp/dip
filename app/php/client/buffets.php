<?php
	include('../db_connect.php');


 	$sql = "SELECT NameOfBuffet, Floor, BusinessHours, NumberOfBuilding FROM Buffets";
 	$buffets_query = mysql_query($sql);
    if (mysql_num_rows($buffets_query) > 0) {
    	echo "<div class='results_table'>";
    	while($buffet = mysql_fetch_array($buffets_query)){
    		echo '<div class="buffet_block"><div class="lesson_header">"' . $buffet['NameOfBuffet'] . '"</div>' . $buffet['NumberOfBuilding'] . " корпус<br>" . $buffet['Floor'] . " поверх<br><b>" . $buffet['BusinessHours'] . "</b></div>";
    	};
    	echo "</div>";
    } else {
    	echo "В університеті нема буфетів або інформація про них відсутня.";
    };
?>