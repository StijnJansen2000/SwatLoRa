<div class="container mt-3">
    <div class="d-flex justify-content-center">
        <div class="col-lg-6 col-md-12">
            <?php
            if (isset($_SESSION['config'])) {
                echo '<div class="alert alert-primary" role="alert">';
                echo $_SESSION['config'];
                echo '</div>';

            ?>
            <h1 class="display-6">Edit a Gateway</h1>
            <?php
                if (!isset($_POST['editValue'])) {
                    ?>
                    <div class="form-group">
                        <label for="selectGateway">Gateway Name</label>
                        <select class="form-control" name="selectGateway" id="selectGateway"
                                aria-describedby="selectHelp">
                            <option>List of gateways here</option>
                        </select>
                        <small id="selectHelp" class="form-text text-muted">Name of the gateway to be edited, the name
                            has to be unique</small>
                    </div>
                    <button type="submit" id="addAll" class="btn btn-primary">Select this Gateway</button>

                    <h5>after pushing this button form below will appear with filled in fields</h5>
                    <?php
                }
                    ?>
            <form action="php/edit.php" method="post">

                <div class="form-group">
                    <label for="InputGateway">Gateway Name</label>
                    <input type="text" class="form-control" id="InputGateway" name="gateway" aria-describedby="gatewayHelp" value="<?php if (isset($_POST['editValue'])) {echo $_POST['gateway'];} ?>">
                    <small id="gatewayHelp" class="form-text text-muted">Name of the gateway to be added, the name has to be unique</small>
                </div>


                <div class="row">
                    <div class="col">
                        <input type="text" class="form-control" placeholder="Longitude" id="InputLong"
                               name="longitude" aria-describedby="locationHelp" value="<?php if (isset($_POST['editValue'])) {echo $_POST['longitude'];} ?>">
                        <small id="locationHelp" class="form-text text-muted">Longitude of the gateway (to be determined
                            which format
                            this will have)</small>
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" placeholder="Latitude" id="InputLat" name="latitude"
                               aria-describedby="locationHelp"value="<?php if (isset($_POST['editValue'])) {echo $_POST['latitude'];} ?>">
                        <small id="locationHelp" class="form-text text-muted">Latitude of the gateway (to be determined
                            which format
                            this will have)</small>
                    </div>
                </div>

                <div class="form-group">
                    <label for="InputDescription">Description</label>
                    <input type="text" class="form-control" id="InputLocation" name="description"
                           aria-describedby="descriptionHelp" value="<?php if (isset($_POST['editValue'])) {echo $_POST['description'];} ?>">
                    <small id="descriptionHelp" class="form-text text-muted">Description of the gateway</small>
                </div>

                <div class="form-group">
                    <label for="InputLocation">Provider</label>
                    <input type="text" class="form-control" id="InputLocation" name="provider"
                           aria-describedby="providerHelp" value="<?php if (isset($_POST['editValue'])) {echo $_POST['provider'];} ?>">
                    <small id="providerHelp" class="form-text text-muted">Name of the provider</small>
                </div>

                <button type="submit" id="addAll" class="btn btn-primary">Edit Gateway</button>

            </form>
            <?php
            } else {
                echo '<div class="alert alert-primary" role="alert">';
                echo "Please set the config first";
                echo '</div>';
            }
            ?>
        </div>
    </div>
</div>