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
            $i = 0;
            foreach ( $conn->query('SELECT * FROM gateway') as $row ) {
                $test = $conn->query('SELECT dataname FROM data WHERE gateway_id=' . $row['gateway_id']);
                if ($test->rowCount() != 0){
                    echo "<h2>" . $row['name'] . "</h2>";
                }
                foreach ($test as $data){
            ?>
            <div class="control-group">
                <input type="checkbox" class="form-control-input" id="InputAny" name="any">
                <label class="form-check-label" for="InputPublicAccess"><?php echo $data['dataname']?></label>
            </div>
            <?php
                }
            }
            ?>
            <button type="submit" class="btn btn-primary">Load</button>
        </form>
    </div>
</div>

