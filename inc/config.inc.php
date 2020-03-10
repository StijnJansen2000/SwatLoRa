<div class="container mt-3">
    <div class="d-flex justify-content-center">
        <div class="col-lg-6 col-md-12">

            <?php
            if (isset($_SESSION['config'])) {
                echo '<div class="alert alert-primary" role="alert">';
                echo $_SESSION['config'];
                echo '</div>';

                echo $_SESSION['providerID'] . "<br>";
                echo $_SESSION['host'] . "<br>";
                echo $_SESSION['token'] . "<br>";
            }
            ?>
            <h1>Existing Config:</h1>
            <form action="php/config.php" method="post">

                <?php
                //TEST THIS!!!!
                $out = fopen('csv/config.csv', 'r');
                ?>
                <div class="form-group">
                    <select class="form-control" id="configSettings" name="configSettings"><?php
                        while (($data = fgetcsv($out)) !== FALSE) {
                            ?>
                            <option selected="selected"
                                    value="<?php echo $data[1] . ',' . $data[2] . ',' . $data[3] ?>"><?php echo "Name: " . $data[0] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Set this Config</button>

            </form>

            <h1>New Config:</h1>

            <form action="php/config.php" method="post">
                <div class="form-group">
                    <label for="InputName">Name</label>
                    <input type="text" class="form-control" id="InputName" name="name" aria-describedby="nameHelp"
                           value="<?php if (isset($_SESSION['config'])) {
                               echo $_SESSION['name'];
                           } ?>">
                    <small id="nameHelp" class="form-text text-muted">Here needs to be a name to which you can save
                        this config information</small>
                </div>
                <div class="form-group">
                    <label for="InputUrl">URL / Host</label>
                    <input type="text" class="form-control" id="InputUrl" name="url" aria-describedby="urlHelp"
                           value="<?php if (isset($_SESSION['config'])) {
                               echo $_SESSION['host'];
                           } ?>">
                    <small id="urlHelp" class="form-text text-muted">Here needs to be your url / host to make a
                        connection
                        to your server</small>
                </div>
                <div class="form-group">
                    <label for="InputID">Provider ID</label>
                    <input type="text" class="form-control" id="InputID" name="providerID" aria-describedby="IdHelp"
                           value="<?php if (isset($_SESSION['config'])) {
                               echo $_SESSION['providerID'];
                           } ?>">
                    <small id="IdHelp" class="form-text text-muted">Here needs to be your ProviderID to make a
                        connection to
                        your sensors</small>
                </div>
                <div class="form-group">
                    <label for="InputToken">Token</label>
                    <input type="text" class="form-control" id="InputToken" name="token" aria-describedby="TokenHelp"
                           value="<?php if (isset($_SESSION['config'])) {
                               echo $_SESSION['token'];
                           } ?>">
                    <small id="TokenHelp" class="form-text text-muted">Here needs to be your Token to verify that it is
                        your
                        server</small>
                </div>
                <button type="submit" class="btn btn-primary">Set Config</button>
            </form>

            <?php
            if (isset($_SESSION['config'])) {
                $out = fopen('csv/config.csv', 'r');
                $line = $_SESSION['name'] . ',' . $_SESSION['host'] . ',' . $_SESSION['providerID'] . ',' . $_SESSION['token'];
                $counter = 0;
                while (($data = fgetcsv($out)) !== FALSE) {
                    $line2 = $data[0] . ',' . $data[1] . ',' . $data[2] . ',' . $data[3];
                    if ($line == $line2) {
                        $counter++;
                    }
                }
                $response = "";
                if ($counter == 0) {
                    if (isset($size)) {
                        $append = fopen('csv/config.csv', 'a');
                        fputcsv($append, array($_SESSION['name'], $_SESSION['host'], $_SESSION['providerID'], $_SESSION['token']));
                        $response = "Config credentials are added to the config file";
                    } else {
                        $response = "False credentials, credentials will not be added to the config file.";
                    }
                }
                echo $response;
                fclose($out);

            }
            ?>

        </div>
    </div>
</div>