<div class="container mt-3">
    <div class="d-flex justify-content-center">
        <div class="col-lg-6 col-md-12">
            <?php
            if (isset($_SESSION['config'])) {
                include 'php/dbh.php'
            ?>
            <h1>Add Data From Sentilo</h1>
            <form action="php/addData.php" method="post">
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label for="InputComponent">Component Name</label>
                            <select class="form-control" id="InputComponent" name="component" aria-describedby="componentHelp">
                                <?php
                                    foreach ( $conn->query('SELECT * FROM gateway') as $row ) {
                                        ?>
                                        <option value="<?php echo $row['name']?>"><?php echo $row['name']?></option>
                                <?php
                                    }
                                ?>
                            </select>
                            <small id="componentHelp" class="form-text text-muted">Name of the Component the date should come from</small>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label for="InputAny">Any</label>
                            <input type="checkbox" class="form-control" id="InputAny" name="any" aria-describedby="anyHelp">
                            <small id="anyHelp" class="form-text text-muted">Select Any</small>
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <label for="InputLatitude">Latitude</label>
                    <input type="text" class="form-control" id="InputLatitude" name="latitude" aria-describedby="latitudeHelp">
                    <small id="latitudeHelp" class="form-text text-muted">Latitude of the data</small>
                </div>

                <div class="form-group">
                    <label for="InputLongitude">Longitude</label>
                    <input type="text" class="form-control" id="InputLongitude" name="longitude" aria-describedby="longitudeHelp">
                    <small id="longitudeHelp" class="form-text text-muted">Longitude of the data</small>
                </div>

                <div class="form-group">
                    <label for="InputGPS">GPS Quality</label>
                    <input type="text" class="form-control" id="InputGPS" name="gps" aria-describedby="gpsHelp">
                    <small id="gpsHelp" class="form-text text-muted">GPS Quality of the datas</small>
                </div>

                <div class="form-group">
                    <label for="InputRSSI">RSSI dBm</label>
                    <input type="text" class="form-control" id="InputRSSI" name="rssi" aria-describedby="rssiHelp">
                    <small id="rssiHelp" class="form-text text-muted">RSSI of the data</small>
                </div>

                <div class="form-group">
                    <label for="InputSNR">SNR dB</label>
                    <input type="text" class="form-control" id="InputSNR" name="snr" aria-describedby="snrHelp">
                    <small id="snrHelp" class="form-text text-muted">SNR of the data</small>
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
                <button type="submit" class="btn btn-primary">Add Data</button>
            </form>
            <?php

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
