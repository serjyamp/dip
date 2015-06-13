<?php
	include('../db_connect.php');
	
    $sql = "SELECT * FROM Auditoriums";
    $query = mysql_query($sql);
    if (mysql_num_rows($query) > 0){
    	echo '<div class="content_table content_table_auditoriums">';
        echo '<div class="content_row content_row_header"><div class="cc_0"></div><div class="cc_h_1">Номер аудиторії</div><div class="cc_h_2">Кількість розеток</div><div class="cc_h_3">Кількість місць</div><div class="cc_h_3">Проектор</div><div class="cc_h_last"></div></div>';
        while ($row = mysql_fetch_array($query)){
            echo '<div class="content_row" data-val="' . $row['NumberOfAuditorium'] . '"> <div class="content_cell_check"> <input type="checkbox" class="cell_checkbox"> </div> <div class="content_cell content_cell_1"> <input type="text" class="content_cell_input cci_1 search_input_auditorium" readonly value=' . $row['NumberOfAuditorium'] . '> </div> <div class="content_cell content_cell_2"> <input type="text" class="content_cell_input cci_2 search_input_digits" maxlength="3" readonly value=' . $row['QuantityOfSockets'] . '> </div> <div class="content_cell content_cell_3"> <input type="text" class="content_cell_input cci_3 search_input_digits" maxlength="3" readonly value=' . $row['QuantityOfSeats'] . '> </div> <div class="content_cell content_cell_4"> <select class="ccs_4 projector" disabled>';

            if ($row['PresenceOfProjector'] == 0){
                echo '<option value="0" selected>нема</option><option value="1">є</option>';
            } else {
                echo '<option value="0">нема</option><option value="1" selected>є</option>';
            }

            echo '</select> </div> <div class="content_cell content_cell_btns"> <button class="content_cell_btn cell_edit"><i class="fa fa-pencil"></i></button> <button class="content_cell_btn cell_set"><i class="fa fa-check"></i></button> </div> </div>';
    	};
    	echo '</div>';
	} else {
		echo 0;
    };
?>