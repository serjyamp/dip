<?php
	include('../db_connect.php');
	
    $sql = "SELECT * FROM Subjects";
    $query = mysql_query($sql);
    if (mysql_num_rows($query) > 0){
    	echo '<div class="content_table content_table_subjects">';
        echo '<div class="content_row content_row_header"><div class="cc_0"></div><div class="cc_h_1">Код предмету</div><div class="cc_h_2">Назва</div><div class="cc_h_last"></div></div>';
        while ($row = mysql_fetch_array($query)){
            echo '<div class="content_row" data-val=' . $row['CodeOfSubject'] . '> <div class="content_cell_check"> <input type="checkbox" class="cell_checkbox"> </div> <div class="content_cell content_cell_1"> <input type="text" class="content_cell_input cci_1 restrict" readonly value=' . $row['CodeOfSubject'] . '> </div> <div class="content_cell content_cell_2"> <input type="text" class="content_cell_input cci_2" readonly value="' . $row['NameOfSubject'] . '"> </div> <div class="content_cell content_cell_btns"> <button class="content_cell_btn cell_edit"><i class="fa fa-pencil"></i></button> <button class="content_cell_btn cell_set"><i class="fa fa-check"></i></button> </div> </div>';
    	};
    	echo '</div>';
	} else {
		echo 0;
    };
?>