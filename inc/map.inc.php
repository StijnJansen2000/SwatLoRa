<div class="d-flex justify-content-end">
<div id="wrapper">
    <!-- Page Content  -->
    <div id="mapContainer">
        <div id="map"></div>
    </div>

    <!-- Side bar -->
    <div id="sidebar">
        <form id="form">
            <?php
            include 'php/dbh.php';
            require 'php/library.php';
//            $i = 0;
//            foreach ( $conn->query('SELECT * FROM gateway') as $row ) {
//                $test = $conn->query('SELECT dataname FROM data WHERE gateway_id=' . $row['gateway_id']);
//                if ($test->rowCount() != 0){
//                    echo "<h2>" . $row['name'] . "</h2>";
//                }
//                foreach ($test as $data){
//            ?>
<!--            <div class="control-group">-->
<!--                <input type="checkbox" class="form-control-input" id="InputAny" name="any">-->
<!--                <label class="form-check-label" for="InputPublicAccess">--><?php //echo $data['dataname']?><!--</label>-->
<!--            </div>-->
<!--            --><?php
//                }
//            }
            ?>
            <button type="submit" class="btn btn-primary">Load</button>

            <?php
                $q = ($conn->query("SELECT * FROM data WHERE data_id=19"));
                $sensor = ($q->fetch()['oneValue']);
                $q = ($conn->query("SELECT * FROM data WHERE data_id=19"));
                $from = ($q->fetch()['dateFrom']);
                $q = ($conn->query("SELECT * FROM data WHERE data_id=19"));
                $to = ($q->fetch()['dateTo']);

                utfToHex($sensor, $from, $to);
//                utfToHex($conn->query("SELECT oneValue FROM data WHERE data_id=18"), $conn->query("SELECT dateFrom FROM data WHERE data_id=18"), $conn->query("SELECT dateTo FROM data WHERE data_id=18"));

            ?>
        </form>
    </div>
</div>

