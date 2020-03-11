<div class="container mt-3">
    <div class="d-flex justify-content-center">
        <div class="col-lg-6 col-md-12">
            <?php
            if (isset($_SESSION['config'])) {
                echo '<div class="alert alert-primary" role="alert">';
                echo $_SESSION['config'];
                echo '</div>';
            ?>
            <h1>Add a Gateway</h1>
            <form action="php/create.php" method="post">
                <div class="form-group">
                    <label for="InputGateway">Gateway Name</label>
                    <input type="text" class="form-control" id="InputGateway" name="gateway"
                           aria-describedby="gatewayHelp">
                    <small id="gatewayHelp" class="form-text text-muted">Name of the gateway to be added, the name has
                        to be
                        unique</small>
                </div>

                <div class="row">
                    <div class="col">
                        <input type="text" class="form-control" placeholder="Longitude" id="InputLong"
                               name="longitude" aria-describedby="locationHelp">
                        <small id="locationHelp" class="form-text text-muted">Longitude of the gateway (to be determined
                            which format
                            this will have)</small>
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" placeholder="Latitude" id="InputLat" name="latitude"
                               aria-describedby="locationHelp">
                        <small id="locationHelp" class="form-text text-muted">Latitude of the gateway (to be determined
                            which format
                            this will have)</small>
                    </div>
                </div>

                <div class="form-group">
                    <label for="InputDescription">Description</label>
                    <input type="text" class="form-control" id="InputLocation" name="description"
                           aria-describedby="descriptionHelp">
                    <small id="descriptionHelp" class="form-text text-muted">Description of the gateway
                        (optional)</small>
                </div>

                <div class="form-group">
                    <label for="InputLocation">Provider</label>
                    <input type="text" class="form-control" id="InputLocation" name="provider"
                           aria-describedby="providerHelp">
                    <small id="providerHelp" class="form-text text-muted">Name of the provider (necesarry?
                        optional)</small>
                </div>

                <button type="submit" id="addAll" class="btn btn-primary">Create Gateway</button>

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