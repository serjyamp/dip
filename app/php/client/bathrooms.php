<?php
	include('../db_connect.php');

    $buildingsWithoutBathrooms[] = "";
    $sql = "SELECT NumberOfBuilding, QuantityOfFloors FROM Buildings";
    $buildings_query = mysql_query($sql);
    $hasResults = false;

    if (mysql_num_rows($buildings_query) > 0){
        while($building = mysql_fetch_array($buildings_query)){
            $where = "NumberOfBuilding={$building['NumberOfBuilding']}";
            $sql = "SELECT * FROM Bathrooms WHERE " . $where;
            $bathrooms_query = mysql_query($sql);
            if (mysql_num_rows($bathrooms_query) > 0) {
                echo "<div class='row_caption'><span>" . $building['NumberOfBuilding'] . "</span> корпус</div>";
            	echo "<div class='results_table'>";
                $quantityOfFloors = $building['QuantityOfFloors'];
                for ($i=0; $i<2; $i++){
                    $hasResults = false;

                    if ($i==0){
                        $mw = "Чоловічі";
                    } else{
                        $mw = "Жіночі";
                    };
                    echo '<div class="bathroom_block"><div class="bathroom_block_header">' . $mw . '</div>';
                    for ($j = 1; $j <= $quantityOfFloors; $j++){
                        $k = 0;
                        $where = "(NumberOfBuilding={$building['NumberOfBuilding']}) AND (Floor='$j') AND (ForMenOrWomen='$mw')";
                        $sql = "SELECT Floor, ForMenOrWomen FROM Bathrooms WHERE " . $where;
                        $bathrooms_query = mysql_query($sql);
                        if (mysql_num_rows($bathrooms_query) > 0) {
                        	while($bathroom = mysql_fetch_array($bathrooms_query)){
                                $k++;
                        	};
                            if ($k != 0){
                                $hasResults = true;
                                echo '<div class="lesson_header">' . $j . ' поверх: <span class="count_of_bathrooms">' . $k . '</span></div>';
                            };
                        };
                    };

                    if ($hasResults == false){
                        echo '<div class="lesson_header">відсутні</div>';
                    }

                	echo "</div>";
                };
                echo "</div>";
            } else {
                $buildingsWithoutBathrooms[] = $building['NumberOfBuilding'];
            };
        };
        array_shift($buildingsWithoutBathrooms);
        $bwb_count = count($buildingsWithoutBathrooms);
        if ($bwb_count > 0){
            if ($bwb_count > 1){
                $opening = "корпусах";
            } else {
                $opening = "корпусі";
            };
            echo "<div class='teachers_no'>У " . $opening . " ";
            for ($i=0; $i<$bwb_count; $i++){
                if ($i != $bwb_count-1){
                    echo "<span class='row_caption'>" . $buildingsWithoutBathrooms[$i] . "</span>, ";
                } else {
                    echo "<span class='row_caption'>" . $buildingsWithoutBathrooms[$i] . "</span> ";
                };
            };
            echo "нема вбиралень або інформація про них відсутня.</div>";
        };
    };
?>