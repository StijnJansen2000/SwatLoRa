<div class="container mt-3">
    <div class="d-flex justify-content-center">
        <div class="col-lg-6 col-md-12">
            <?php
            if (isset($_SESSION['config'])) {
                include 'php/dbh.php';
                require 'php/library.php';
                require 'vendor/autoload.php';

                $catalog = GetCatalog();
                $size = ($catalog['providers'][0]['sensors']);
                $components = array();

                for ($i = 0; $i < sizeof($size); $i++) {
                    if (!in_array($size[$i]['component'], $components) && $size[$i]['component'] != "") {
                        array_push($components, $size[$i]['component']);
                    }
                }

                ?>
                <h1>Add Data From CSV</h1>

                <form method="post" enctype="multipart/form-data" action="php/addExcel.php">
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

                    <div class="form-group">
                        <label for="InputFile">Choose File</label>
                        <input type="file" name="file" class="form-control" id="InputFile" aria-describedby="inputHelp">
                        <small id="inputHelp" class="form-text text-muted">Choose a CSV file</small>
                    </div>

                    <div class="form-group">
                        <label for="InputComponentName">Component:</label>
                        <select class="form-control" id="InputComponentName" name="componentName" aria-describedby="componentNameHelp"><?php
                            for ($i = 0; $i < sizeof($components); $i++){
                                ?>
                                <option name="test" value="<?php echo $components[$i] ?>"><?php echo $components[$i] ?></option>
                                <?php
                            }?>
                        </select>
                        <small id="componentNameHelp" class="form-text text-muted">Component that the data has to be added to</small>
                    </div>


                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
        <?php
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
