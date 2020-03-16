<?php
include 'php/dbh.php';
if (isset($_POST['submit'])) {
    require 'php/library.php';
    $catalog = GetCatalog();
    $size = ($catalog['providers'][0]['sensors']);
    $components = array();
    $id = $_POST['data_id'];


    $query = $conn->prepare("SELECT * FROM data WHERE data_id=:id");
    $query->execute(array(
        ":id" => $id
    ));

    $result = $query->fetch(PDO::FETCH_ASSOC);
    for ($i = 0; $i < sizeof($size); $i++){
        if (!in_array($size[$i]['component'], $components) && $size[$i]['component'] != ""){
            array_push($components, $size[$i]['component']);
        }
    }
    print_r($result);
}
?>
<pre>
    <?php

    $dateFrom = str_replace("/", "-",substr($result['dateFrom'], 0, -9));
    $timeFrom = substr($result['dateFrom'], -8, -3);

    $dateTo = str_replace("/", "-",substr($result['dateTo'], 0, -9));
    $timeTo = substr($result['dateTo'], -8, -3);

    $dateFrom = date('Y-m-d', strtotime($dateFrom));
    $dateTo = date('Y-m-d', strtotime($dateTo));
    ?>
</pre>
    <div class="container mt-3">
        <div class="d-flex justify-content-center">
            <div class="col-lg-6 col-md-12">
            <h1>Edit Data From Sentilo</h1>
                <?php
                    $sensors = array();
                    for ($i = 0; $i < sizeof($size); $i++) {
                        if ($size[$i]['component'] == $result['component']) {
                            if (!in_array($size[$i]['sensor'], $sensors) && $size[$i]['sensor'] != "") {
                                array_push($sensors, $size[$i]['sensor']);
                            }
                        }

                }
                ?>

                <form action="php/editData.php" method="post">
                    <div class="form-group">
                        <label for="InputGPS">GPS Quality</label>
                            <select class="form-control" id="InputGPS" name="gps" aria-describedby="gpsHelp">
                                <?php
                                for ($i = 0; $i < sizeof($sensors); $i++){
                                    ?>
                                    <option name="value" value="<?php echo $result['gpsquality']?>"><?php echo $result['gpsquality']?></option>
                                    <option name="test" value="<?php echo $sensors[$i] ?>"><?php echo $sensors[$i] ?></option>
                                    <?php
                                }?>
                            </select>
                            <small id="gpsHelp" class="form-text text-muted">GPS Quality of the data</small>
                        </div>


                        <div class="form-group">
                            <label for="InputRSSI">RSSI dBm</label>
                            <select class="form-control" id="InputRSSI" name="rssi" aria-describedby="rssiHelp">
                                <?php
                                for ($i = 0; $i < sizeof($sensors); $i++){
                                    ?>
                                    <option name="value" value="<?php echo $result['rssi']?>"><?php echo $result['rssi']?></option>
                                    <option name="test" value="<?php echo $sensors[$i] ?>"><?php echo $sensors[$i] ?></option>
                                    <?php
                                }?>
                            </select>
                            <small id="rssiHelp" class="form-text text-muted">RSSI of the data</small>
                        </div>

                        <div class="form-group">
                            <label for="InputSNR">SNR</label>
                            <select class="form-control" id="InputSNR" name="snr" aria-describedby="snrHelp">
                                <?php
                                for ($i = 0; $i < sizeof($sensors); $i++){
                                    ?>
                                    <option name="value" value="<?php echo $result['snr']?>"><?php echo $result['snr']?></option>
                                    <option name="test" value="<?php echo $sensors[$i] ?>"><?php echo $sensors[$i] ?></option>
                                    <?php
                                }?>
                            </select>
                            <small id="snrHelp" class="form-text text-muted">SNR of the data</small>
                        </div>

                        <div class="row">
                            <div class="col">
                                <label for="InputLong">longitude</label>
                                <select class="form-control" id="InputLong" name="longitude" aria-describedby="locationHelp">
                                    <?php
                                    for ($i = 0; $i < sizeof($sensors); $i++){
                                        ?>
                                        <option name="value" value="<?php echo $result['longitude']?>"><?php echo $result['longitude']?></option>
                                        <option name="test" value="<?php echo $sensors[$i] ?>"><?php echo $sensors[$i] ?></option>
                                        <?php
                                    }?>
                                </select>
                                <small id="locationHelp" class="form-text text-muted">Longitude of the gateway (to be determined
                                    which format
                                    this will have)</small>
                            </div>
                            <div class="col">
                                <label for="InputLat">longitude</label>
                                <select class="form-control" id="InputLat" name="latitude" aria-describedby="locationHelp">
                                    <?php
                                    for ($i = 0; $i < sizeof($sensors); $i++){
                                        ?>
                                        <option name="value" value="<?php echo $result['longitude']?>"><?php echo $result['latitude']?></option>
                                        <option name="test" value="<?php echo $sensors[$i] ?>"><?php echo $sensors[$i] ?></option>
                                        <?php
                                    }?>
                                </select>
                                <small id="locationHelp" class="form-text text-muted">Latitude of the gateway (to be determined
                                    which format
                                    this will have)</small>
                            </div>
                        </div>
                        <?php //TODO: fill date/time with values?>
                        <div class="row">
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label for="fromDatePicker">From</label>
                                    <input id="fromDatePicker" class="form-control" name="dateFrom" type="date" value="<?php echo $dateFrom?>">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label for="toDatePicker">To</label>
                                    <input id="toDatePicker" class="form-control" name="dateTo" type="date" value="<?php echo $dateTo?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label for="fromTimePicker">From Time</label>
                                    <input id="fromTimePicker" class="form-control" name="timeFrom" type="time" value="<?php echo $timeFrom?>">

                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label for="toTimePicker">To Time</label>
                                    <input id="toTimePicker" class="form-control" name="timeTo" type="time" value="<?php echo $timeTo?>">
                                </div>
                            </div>
                        </div>
<!--                        <input type="hidden" id="componentName" name="componentName" value="--><?//= $_POST['componentName'] ?><!--">-->
                        <input type="hidden" id="dataId" name="dataId" value="<?= $result['data_id'] ?>">
                        <button type="submit" class="btn btn-primary">Edit Data</button>
                    </form>
            </div>
        </div>
    </div>
    </div>
<?php

