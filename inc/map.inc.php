<div class="d-flex justify-content-end">
<div id="wrapper">
    <!-- Map Content  -->
    <div id="mapContainer">
        <div id="map"></div>
    </div>

    <!-- Side bar -->
    <div id="sidebar">
        <?php
            include 'php/dbh.php';
            require 'php/library.php';
        ?>

        <form action="" method="post" id="form">
            <div class="form-group">
                <?php
                    $i = 0;
                    foreach ($conn->query('SELECT * FROM gateway') as $row){
                        $getRows = $conn->query('SELECT dataname FROM data WHERE gateway_id=' . $row['gateway_id']);
                        if ($getRows->rowCount() != 0){
                            echo "<h2>" . $row['name'] . "</h2>";
                        }
                        foreach ($getRows as $data){
                            ?>
                            <div class="form-group">
                                <input type="checkbox" class="form-control-input" id="InputCheck" name="<?php echo $data['dataname'] ?>">
                                <label class="form-check-label" for="InputCheck"><?php echo $data['dataname'] ?></label>
                            </div>
                            <?php
                        }
                    }
                ?>
            </div>
            <input type="submit" name="SubmitButton" class="btn btn-primary"/>
        </form>
        <?php
            if (isset($_POST['SubmitButton'])) {
                foreach ($_POST as $key => $value) {
                    $checkRow = $conn->query("SELECT * FROM data WHERE dataName='" . $key . "'");
                    if ($checkRow->rowCount() != 0) {
                        if ($checkRow->fetch()['oneValue'] != "") {
                            $q = $conn->query("SELECT * FROM data WHERE dataName='" . $key . "'");
                            $sensor = ($q->fetch()['oneValue']);
                            $q = $conn->query("SELECT * FROM data WHERE dataName='" . $key . "'");
                            $from = ($q->fetch()['dateFrom']);
                            $q = $conn->query("SELECT * FROM data WHERE dataName='" . $key . "'");
                            $to = ($q->fetch()['dateTo']);
//                            utfToHex($sensor, $from, $to);
                        } else {
                            $q = $conn->query("SELECT * FROM data WHERE dataName='" . $key . "'");
                            $snr = ($q->fetch()['snr']);
                            $q = $conn->query("SELECT * FROM data WHERE dataName='" . $key . "'");
                            $rssi = ($q->fetch()['rssi']);
                            $q = $conn->query("SELECT * FROM data WHERE dataName='" . $key . "'");
                            $lat = ($q->fetch()['latitude']);
                            $q = $conn->query("SELECT * FROM data WHERE dataName='" . $key . "'");
                            $long = ($q->fetch()['longitude']);
                            $q = $conn->query("SELECT * FROM data WHERE dataName='" . $key . "'");
                            $from = ($q->fetch()['dateFrom']);
                            $q = $conn->query("SELECT * FROM data WHERE dataName='" . $key . "'");
                            $to = ($q->fetch()['dateTo']);
//                            echo "SNR " . $rssi . "<br> RSSI " . $snr . "<br> Lat: " . $lat . "<br> Long: " . $long . "<br> from: " . $from . "<br> to: " . $to;
                            seperateData($rssi, $snr, $lat, $long, $from, $to);
                        }
                    }
                }
            }
//            echo "</div>";

//                utfToHex($conn->query("SELECT oneValue FROM data WHERE data_id=18"), $conn->query("SELECT dateFrom FROM data WHERE data_id=18"), $conn->query("SELECT dateTo FROM data WHERE data_id=18"));

            ?>

    </div>
</div>

