<?php
	include('../db_connect.php');
	
    $sql = "SELECT * FROM Rooms";
    $query = mysql_query($sql);
    if (mysql_num_rows($query) > 0){
    	echo '<div class="content_table content_table_rooms">';
        echo '<div class="content_row content_row_header"><div class="cc_0"></div><div class="cc_h_1">Назва</div><div class="cc_h_2">Контакти</div><div class="cc_h_3">Аудиторія</div><div class="cc_h_3">Корпус</div><div class="cc_h_3">Поверх</div><div class="cc_h_last"></div></div>';
        while ($row = mysql_fetch_array($query)){
            echo '<div class="content_row" data-val="' . $row['CodeOfRoom'] . '"> <div class="content_cell_check"> <input type="checkbox" class="cell_checkbox"> </div> <div class="content_cell content_cell_1"> <input type="text" class="content_cell_input cci_1" readonly value="' . $row['NameOfRoom'] . '"> </div> <div class="content_cell content_cell_2"> <input type="text" class="content_cell_input cci_2 can_be_empty" readonly value="' . $row['Contacts'] . '"> </div> <div class="content_cell content_cell_3"> <input type="text" class="content_cell_input cci_3 search_input_auditorium can_be_empty" readonly value=' . $row['NumberOfAuditorium'] . '> </div> <div class="content_cell content_cell_4"> <input type="text" class="content_cell_input cci_4 search_input_digits" readonly value=' . $row['NumberOfBuilding'] . '> </div><div class="content_cell content_cell_5"> <input type="text" class="content_cell_input cci_5 search_input_digits" readonly value=' . $row['Floor'] . '> </div> <div class="content_cell content_cell_btns"> <button class="content_cell_btn cell_edit"><i class="fa fa-pencil"></i></button> <button class="content_cell_btn cell_set"><i class="fa fa-check"></i></button> </div> </div>';
    	};
    	echo '</div>';
	} else {
		echo 0;
    };
?>