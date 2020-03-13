<!--<div class="d-flex justify-content-end">-->
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
                ?>
                <h2><?php echo $row['name']?></h2>
                <div class="control-group">
                    <input type="checkbox" class="form-control-input" id="InputAny" name="any">
                    <label class="form-check-label" for="InputPublicAccess">Data 1</label>
                </div>
                <div class="control-group">
                    <input type="checkbox" class="form-control-input" id="InputAny" name="any">
                    <label class="form-check-label" for="InputPublicAccess">Data 2</label>
                </div>
                <div class="control-group">
                    <input type="checkbox" class="form-control-input" id="InputAny" name="any">
                    <label class="form-check-label" for="InputPublicAccess">Data 3</label>
                </div>
                <?php
            }
            ?>


            <button type="submit" class="btn btn-primary">Load</button>
        </form>
    </div>
</div>
