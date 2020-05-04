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

                for ($i = 0; $i < sizeof($size); $i++) {
                    if (!in_array($size[$i]['component'], $components) && $size[$i]['component'] != "") {
                        array_push($components, $size[$i]['component']);
                    }
                }

            ?>
            <h1>Add Data From Sentilo</h1>

                <form method="post">
                    <div class="form-group">
                        <label for="InputName">Data Name</label>
                        <input type="text" class="form-control" id="InputName" name="dataName" aria-describedby="nameHelp" value="<?php if (isset($_POST['dataName'])){echo $_POST['dataName'];} ?>">
                        <small id="nameHelp" class="form-text text-muted">Name for this particular data</small>
                    </div>

                    <div class="form-group">
                        <label for="Inputgateway">Gateway Name</label>
                        <select class="form-control" id="Inputgateway" name="gateway" aria-describedby="gatewayHelp">
                            <?php
                                foreach ( $conn->query('SELECT * FROM gateway WHERE config_id='.$_SESSION['config_id']) as $row ) {
                            ?>
                                    <option value="<?php echo $row['gateway_id']?>"><?php echo $row['name']?></option>
                            <?php
                                }
                            ?>
                        </select>
                        <small id="gatewayHelp" class="form-text text-muted">Gateway where data should be added to</small>
                    </div>

                    <div class="control-group">
                        <input type="checkbox" class="form-control-input" id="InputOne" name="one" <?php if (isset($_POST['one'])){
                            echo "checked";
                        } ?>>
                        <label class="form-check-label" for="InputOne">Only one</label>
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
                        if ($size[$i]['component'] == $_POST['componentName']) {
                            if (!in_array($size[$i]['sensor'], $sensors) && $size[$i]['sensor'] != "") {
                                array_push($sensors, $size[$i]['sensor']);
                            }
                        }
                    }
                    ?>

                    <form action="php/addData.php" method="post">
                        <?php
                        if (isset($_POST['one'])) {
                            ?>

                            <div class="form-group">
                                <label for="InputSensor">Select Sensor</label>
                                <select class="form-control" id="InputSensor" name="sensor"
                                        aria-describedby="gpsHelp"><?php
                                    for ($i = 0; $i < sizeof($sensors); $i++) {
                                        ?>
                                        <option name="test"
                                                value="<?php echo $sensors[$i] ?>"><?php echo $sensors[$i] ?></option>
                                        <?php
                                    } ?>
                                </select>
                                <small id="gpsHelp" class="form-text text-muted">GPS Quality of the data</small>
                            </div>
                            <input type="hidden" id="oneValue" name="oneValue" value="<?php echo $_POST['one'] ?>">
                            <?php
                        } else { ?>
                            <div class="form-group">
                                <label for="InputGPS">GPS Quality</label>
                                <select class="form-control" id="InputGPS" name="gps"
                                        aria-describedby="gpsHelp"><?php
                                    for ($i = 0; $i < sizeof($sensors); $i++) {
                                        ?>
                                        <option name="test"
                                                value="<?php echo $sensors[$i] ?>"><?php echo $sensors[$i] ?></option>
                                        <?php
                                    } ?>
                                </select>
                                <small id="gpsHelp" class="form-text text-muted">GPS Quality of the data</small>
                            </div>

                            <div class="form-group">
                                <label for="InputRSSI">RSSI dBm</label>
                                <select class="form-control" id="InputRSSI" name="rssi"
                                        aria-describedby="rssiHelp"><?php
                                    for ($i = 0; $i < sizeof($sensors); $i++) {
                                        ?>
                                        <option name="test"
                                                value="<?php echo $sensors[$i] ?>"><?php echo $sensors[$i] ?></option>
                                        <?php
                                    } ?>
                                </select>
                                <small id="rssiHelp" class="form-text text-muted">RSSI of the data</small>
                            </div>

                            <div class="form-group">
                                <label for="InputSNR">SNR</label>
                                <select class="form-control" id="InputSNR" name="snr"
                                        aria-describedby="snrHelp"><?php
                                    for ($i = 0; $i < sizeof($sensors); $i++) {
                                        ?>
                                        <option name="test"
                                                value="<?php echo $sensors[$i] ?>"><?php echo $sensors[$i] ?></option>
                                        <?php
                                    } ?>
                                </select>
                                <small id="snrHelp" class="form-text text-muted">SNR of the data</small>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <label for="InputLat">Latitude</label>
                                    <select class="form-control" id="InputLat" name="latitude"
                                            aria-describedby="locationHelp"><?php
                                        for ($i = 0; $i < sizeof($sensors); $i++) {
                                            ?>
                                            <option name="test"
                                                    value="<?php echo $sensors[$i] ?>"><?php echo $sensors[$i] ?></option>
                                            <?php
                                        } ?>
                                    </select>
                                    <small id="locationHelp" class="form-text text-muted">Latitude of the
                                        gateway</small>
                                </div>
                                <div class="col">
                                    <label for="InputLong">Longitude</label>
                                    <select class="form-control" id="InputLong" name="longitude"
                                            aria-describedby="locationHelp" ><?php
                                        for ($i = 0; $i < sizeof($sensors); $i++) {
                                            ?>
                                            <option name="test"
                                                    value="<?php echo $sensors[$i] ?>"><?php echo $sensors[$i] ?></option>
                                            <?php
                                        } ?>
                                    </select>
                                    <small id="locationHelp" class="form-text text-muted">Longitude of the
                                        gateway</small>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="row">
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label for="fromDatePicker">From</label>
                                    <input placeholder="dd-mm-yyyy" class="form-control" name="dateFrom" type="text" onfocus="(this.type='date')" onblur="(this.type='text')" id="fromDatePicker" />

                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label for="toDatePicker">To</label>
                                    <input placeholder="dd-mm-yyyy" class="form-control" name="dateTo" type="text" onfocus="(this.type='date')" onblur="(this.type='text')" id="toDatePicker" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label for="fromTimePicker">From Time</label>
                                    <input id="fromTimePicker" class="form-control" name="timeFrom" type="time" placeholder="--:--">

                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label for="toTimePicker">To Time</label>
                                    <input id="toTimePicker" class="form-control" name="timeTo" type="time" placeholder="--:--">
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="componentName" name="componentName"
                               value="<?= $_POST['componentName'] ?>">
                        <input type="hidden" id="dataName" name="dataName" value="<?php echo $_POST['dataName'] ?>">
                        <input type="hidden" id="gateway" name="gateway" value="<?= $_POST['gateway'] ?>">
                        <button type="submit" class="btn btn-primary">Add Data</button>
                    </form>
                    <?php
                }
                } else {
                    echo '<div class="alert alert-primary" role="alert">';
                    echo "Please set the config first";
                    echo '</div>';
                    echo "<a href='?page=config' class='btn btn-primary'>Set Config here</a>";
                }
                ?>

        </div>
    </div>
</div>
