<?php
	include('../db_connect.php');
	
    $sql = "SELECT * FROM Teachers";
    $query = mysql_query($sql);
    if (mysql_num_rows($query) > 0){
    	echo '<div class="content_table content_table_teachers">';
        echo '<div class="content_row content_row_header"><div class="cc_0"></div><div class="cc_h_1">Код викладача</div><div class="cc_h_2">Прізвище</div><div class="cc_h_3">Ім’я</div><div class="cc_h_2">По батькові</div><div class="cc_h_last"></div></div>';
        while ($row = mysql_fetch_array($query)){
            echo '<div class="content_row" data-val=' . $row['CodeOfTeacher'] . '> <div class="content_cell_check"> <input type="checkbox" class="cell_checkbox"> </div> <div class="content_cell content_cell_1"> <input type="text" class="content_cell_input cci_1 restrict" readonly value=' . $row['CodeOfTeacher'] . '> </div> <div class="content_cell content_cell_2"> <input type="text" class="content_cell_input cci_2" readonly value=' . $row['LastnameOfTeacher'] . '> </div> <div class="content_cell content_cell_3"> <input type="text" class="content_cell_input cci_3" readonly value=' . $row['NameOfTeacher'] . '> </div><div class="content_cell content_cell_4"> <input type="text" class="content_cell_input cci_4" readonly value=' . $row['PatronymicOfTeacher'] . '> </div><div class="content_cell content_cell_btns"> <button class="content_cell_btn cell_edit"><i class="fa fa-pencil"></i></button> <button class="content_cell_btn cell_set"><i class="fa fa-check"></i></button> </div> </div>';
    	};
    	echo '</div>';
	} else {
		echo 0;
    };
?>