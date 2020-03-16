<div class="container mt-3">
    <div class="d-flex justify-content-center">
        <div class="col-lg-6 col-md-12">
            <?php
            if (isset($_SESSION['config'])) {
                include 'php/dbh.php';
                require 'php/library.php';
                $catalog = GetCatalog();
                $size = ($catalog['providers'][0]['sensors']);
                $components = array();

                for ($i = 0; $i < sizeof($size); $i++){
                    if (!in_array($size[$i]['component'], $components) && $size[$i]['component'] != ""){
                        array_push($components, $size[$i]['component']);
                    }
            }
            ?>
            <h1>Add Data From Sentilo</h1>

                <form method="post">
                <div class="form-group">
                    <label for="Inputgateway">Gateway Name</label>
                    <select class="form-control" id="Inputgateway" name="gateway" aria-describedby="gatewayHelp">
                        <?php
                        foreach ( $conn->query('SELECT * FROM gateway') as $row ) {
                            ?>
                            <option value="<?php echo $row['name']?>"><?php echo $row['name']?></option>
                            <?php
                        }
                        ?>
                    </select>
                    <small id="gatewayHelp" class="form-text text-muted">Gateway where data should be added to</small>
                </div>

                    <div class="form-group">
                        <label for="InputComponentName">Component:</label>
                        <select class="form-control" id="InputComponentName" name="componentName" aria-describedby="componentNameHelp"><?php
                            for ($i = 0; $i < sizeof($components); $i++){
                                ?>
                                <option <?php if (isset($_POST['componentName'])){ if ($_POST['componentName'] == $components[$i]){ echo "selected";} }?>  name="test" value="<?php echo $components[$i] ?>"><?php echo $components[$i] ?></option>
                                <?php
                            }?>
                            <small id="componentNameHelp" class="form-text text-muted">Component that has to be edited</small>
                            <input type="submit" name="submitEdit" value="Select Component" class="btn btn-primary"><?php
                            ?>
                    </div>
                </form>

                <?php if (isset($_POST['componentName'])) {
                    $sensors = array();
                    for ($i = 0; $i < sizeof($size); $i++) {
                        if ($size[$i]['component'] == $_POST['componentName']){
                           if (!in_array($size[$i]['sensor'], $sensors) && $size[$i]['sensor'] != "") {
                                array_push($sensors, $size[$i]['sensor']);
                            }
                        }
                    }
                    ?>

                    <form action="php/addData.php" method="post">
                        <div class="form-group">
                            <label for="InputGPS">GPS Quality</label>
                            <select class="form-control" id="InputGPS" name="gps" aria-describedby="gpsHelp"><?php
                                for ($i = 0; $i < sizeof($sensors); $i++){
                                    ?>
                                    <option name="test" value="<?php echo $sensors[$i] ?>"><?php echo $sensors[$i] ?></option>
                                    <?php
                                }?>
                            </select>
                            <small id="gpsHelp" class="form-text text-muted">GPS Quality of the data</small>
                        </div>


                        <div class="form-group">
                            <label for="InputRSSI">RSSI dBm</label>
                            <select class="form-control" id="InputRSSI" name="rssi" aria-describedby="rssiHelp"><?php
                                for ($i = 0; $i < sizeof($sensors); $i++){
                                    ?>
                                    <option name="test" value="<?php echo $sensors[$i] ?>"><?php echo $sensors[$i] ?></option>
                                    <?php
                                }?>
                            </select>
                            <small id="rssiHelp" class="form-text text-muted">RSSI of the data</small>
                        </div>

                        <div class="form-group">

                            <select class="form-control" id="InputSNR" name="snr" aria-describedby="snrHelp"><?php
                                for ($i = 0; $i < sizeof($sensors); $i++){
                                    ?>
                                    <option name="test" value="<?php echo $sensors[$i] ?>"><?php echo $sensors[$i] ?></option>
                                    <?php
                                }?>
                            </select>
                            <small id="snrHelp" class="form-text text-muted">SNR of the data</small>
                        </div>

                        <div class="row">
                            <div class="col">
                                <label for="InputLong">longitude</label>
                                <select class="form-control" id="InputLong" name="longitude" aria-describedby="locationHelp"><?php
                                    for ($i = 0; $i < sizeof($sensors); $i++){
                                        ?>
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
                                <select class="form-control" id="InputLat" name="latitude" aria-describedby="locationHelp"><?php
                                    for ($i = 0; $i < sizeof($sensors); $i++){
                                        ?>
                                        <option name="test" value="<?php echo $sensors[$i] ?>"><?php echo $sensors[$i] ?></option>
                                        <?php
                                    }?>
                                </select>
                                <small id="locationHelp" class="form-text text-muted">Latitude of the gateway (to be determined
                                    which format
                                    this will have)</small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label for="fromDatePicker">From</label>
                                    <input id="fromDatePicker" class="form-control" name="dateFrom" type="date">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label for="toDatePicker">To</label>
                                    <input id="toDatePicker" class="form-control" name="dateTo" type="date">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label for="fromTimePicker">From Time</label>
                                    <input id="fromTimePicker" class="form-control" name="timeFrom" type="time">

                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label for="toTimePicker">To Time</label>
                                    <input id="toTimePicker" class="form-control" name="timeTo" type="time">
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="gateway" name="componentName" value="<?= $_POST['componentName'] ?>">
                        <input type="hidden" id="gateway" name="componentName" value="<?= $_POST['gateway'] ?>">
                        <button type="submit" class="btn btn-primary">Add Data</button>
                    </form>
                    <?php
                }
                } else {
                    echo '<div class="alert alert-primary" role="alert">';
                    echo "Please set the config first";
                    echo '</div>';
//            echo "<a href='?page=config' class='btn btn-primary'>Set Config here</a>";
                }
                ?>

        </div>
    </div>
</div>
