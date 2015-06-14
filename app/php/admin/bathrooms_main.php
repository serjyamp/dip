<?php
	include('../db_connect.php');
	
    $sql = "SELECT * FROM Bathrooms ORDER BY NumberOfBuilding";
    $query = mysql_query($sql);
    if (mysql_num_rows($query) > 0){
    	echo '<div class="content_table content_table_bathrooms">';
        echo '<div class="content_row content_row_header"><div class="cc_0"></div><div class="cc_h_1">Корпус</div><div class="cc_h_2">Поверх</div><div class="cc_h_3">Тип</div><div class="cc_h_4">Кількість</div><div class="cc_h_last"></div></div>';
        while ($row = mysql_fetch_array($query)){
            echo '<div class="content_row" data-val=' . $row['CodeOfBathroom'] . '> <div class="content_cell_check"> <input type="checkbox" class="cell_checkbox"> </div> <div class="content_cell content_cell_1"> <input type="text" class="content_cell_input search_input_digits cci_1" readonly value=' . $row['NumberOfBuilding'] . '> </div> <div class="content_cell content_cell_2"> <input type="text" class="content_cell_input cci_2 search_input_digits" readonly value="' . $row['Floor'] . '"> </div> <div class="content_cell content_cell_3"> <input type="text" class="content_cell_input cci_3 restrict" readonly maxlength="2" value="' . $row['ForMenOrWomen'] . '"> </div> <div class="content_cell content_cell_4"> <input type="text" class="content_cell_input cci_4 search_input_digits" readonly maxlength="2" value="' . $row['HowManyBathrooms'] . '"> </div> <div class="content_cell content_cell_btns"> <button class="content_cell_btn cell_edit"><i class="fa fa-pencil"></i></button> <button class="content_cell_btn cell_set"><i class="fa fa-check"></i></button> </div> </div>';
    	};
    	echo '</div>';
	} else {
		echo 0;
    };
?>