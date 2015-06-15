<?php
	include('../db_connect.php');
	
    $sql = "SELECT * FROM Lessons ORDER BY NameOfGroup";
    $query = mysql_query($sql);
    if (mysql_num_rows($query) > 0){
    	echo '<div class="content_table content_table_lessons">';
        echo '<div class="content_row content_row_header"><div class="cc_0"></div><div class="cc_h_1">Код предмету</div><div class="cc_h_2">Код викладача</div><div class="cc_h_3">Група</div><div class="cc_h_4">Аудиторія</div><div class="cc_h_5">День</div><div class="cc_h_6">Пара</div><div class="cc_h_7">Тиждень</div><div class="cc_h_last"></div></div>';
        while ($row = mysql_fetch_array($query)){
            echo '<div class="content_row" data-val="' . $row['CodeOfLesson'] . '"><div class="content_cell_check"><input type="checkbox" class="cell_checkbox"></div><div class="content_cell content_cell_1"><input type="text" class="content_cell_input cci_1 search_input_digits" maxlength="11" readonly value=' . $row['CodeOfSubject'] . '></div><div class="content_cell content_cell_2"> <input type="text" class="content_cell_input cci_2 search_input_digits" maxlength="11" readonly value=' . $row['CodeOfTeacher'] . '> </div> <div class="content_cell content_cell_3"> <input type="text" class="content_cell_input cci_3" maxlength="11" readonly value=' . $row['NameOfGroup'] . '> </div> <div class="content_cell content_cell_4"> <input type="text" class="content_cell_input search_input_auditorium cci_4" readonly value=' . $row['NumberOfAuditorium'] . '> </div>';

            echo '<div class="content_cell content_cell_5"><select class="ccs_5" disabled>';

            // choose selected day and construct list
            $k = 1;
            if (strcmp($row['DayOfWeek'], "вівторок") == 0){
                $k = 2;
            };
            if (strcmp($row['DayOfWeek'], "середа") == 0){
                $k = 3;
            };
            if (strcmp($row['DayOfWeek'], "четвер") == 0){
                $k = 4;
            };
            if (strcmp($row['DayOfWeek'], "п’ятниця") == 0){
                $k = 5;
            };
            if (strcmp($row['DayOfWeek'], "субота") == 0){
                $k = 6;
            };
            if (strcmp($row['DayOfWeek'], "неділя") == 0){
                $k = 7;
            };

            for ($i=1; $i<=7; $i++){
                if ($i == $k){
                    echo '<option value="' . $row['DayOfWeek'] . '" selected>' . $row['DayOfWeek'] . '</option>';       
                } else {
                    if ($i == 1){
                        echo '<option value="понеділок">понеділок</option>';
                    };
                    if ($i == 2){
                        echo '<option value="вівторок">вівторок</option>';
                    };
                    if ($i == 3){
                        echo '<option value="середа" >середа</option>';
                    };
                    if ($i == 4){
                        echo '<option value="четвер">четвер</option>';
                    };
                    if ($i == 5){
                        echo '<option value="п’ятниця">п’ятниця</option>';
                    };
                    if ($i == 6){
                        echo '<option value="субота" >субота</option>';
                    };
                    if ($i == 7){
                        echo '<option value="неділя">неділя</option>';
                    };
                };
            };

            echo '</select></div><div class="content_cell content_cell_6"><select class="ccs_6" disabled>';

            // choose selected double period and construct list
            $m = 1;
            if ($row['NumberOfDoublePeriod'] == 2){
                $m = 2;
            };
            if ($row['NumberOfDoublePeriod'] == 3){
                $m = 3;
            };
            if ($row['NumberOfDoublePeriod'] == 4){
                $m = 4;
            };
            if ($row['NumberOfDoublePeriod'] == 5){
                $m = 5;
            };
            if ($row['NumberOfDoublePeriod'] == 6){
                $m = 6;
            };
            if ($row['NumberOfDoublePeriod'] == 7){
                $m = 7;
            };
            if ($row['NumberOfDoublePeriod'] == 8){
                $m = 8;
            };

            for ($i=1; $i<=8; $i++){
                if ($i == $m){     
                    echo '<option value="' . $row['NumberOfDoublePeriod'] . '" selected>' . $row['NumberOfDoublePeriod'] . '</option>';             
                } else {
                    if ($i == 1){
                        echo '<option value="1">1</option>';
                    };
                    if ($i == 2){
                        echo '<option value="2">2</option>';
                    };
                    if ($i == 3){
                        echo '<option value="3">3</option>';
                    };
                    if ($i == 4){
                        echo '<option value="4">4</option>';
                    };
                    if ($i == 5){
                        echo '<option value="5">5</option>';
                    };
                    if ($i == 6){
                        echo '<option value="6">6</option>';
                    };
                    if ($i == 7){
                        echo '<option value="7">7</option>';
                    };
                    if ($i == 8){
                        echo '<option value="8">8</option>';
                    };
                };
            };

            echo '</select> </div> <div class="content_cell content_cell_7"> <select class="ccs_7" disabled>';

            // choose selected week and construct list
            $w = 0;
            if (strcmp($row['Week'], 'нижній') == 0){
                $w = 1;
            };

            for ($i=0; $i<2; $i++){
                if ($i == $w){
                    echo '<option value="' . $row['Week'] . '" selected>' . $row['Week'] . '</option>';                 
                } else {
                    if ($i == 0){
                        echo '<option value="верхній">верхній</option>';
                    };
                    if ($i == 1){
                        echo '<option value="нижній">нижній</option>';
                    };
                };
            };

            echo '</select> </div> <div class="content_cell content_cell_btns"> <button class="content_cell_btn cell_edit"><i class="fa fa-pencil"></i></button> <button class="content_cell_btn cell_set"><i class="fa fa-check"></i></button> </div> </div>';
    	};
    	echo '</div>';
	} else {
		echo 0;
    };
?>