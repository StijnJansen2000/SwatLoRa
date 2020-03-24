<?php
include "php/dbh.php";

//$query = $conn->prepare("SELECT * FROM config");
//$query->execute();
//
//$result = $query->fetch(PDO::FETCH_ASSOC);
//print_r($_SESSION['config_id']);
?>
<div class="container mt-3">
    <div class="d-flex justify-content-center">
        <div class="col-lg-6 col-md-12">

            <h1>Add a Gateway</h1>

            <?php
            if (isset($_SESSION['message'])){
                echo '<div class="alert alert-primary" role="alert">';
                echo $_SESSION['message'];
                echo '</div>';

                $_SESSION['message'] = null;

//                print_r($result);
            }
            ?>

            <form action="php/create.php" method="post">

                <input type="hidden" name="config_id" value="<?= $_SESSION['config_id'] ?>">

                <div class="form-group">
                    <label for="InputGateway">Gateway Name</label>
                    <input type="text" class="form-control" id="InputGateway" name="name"
                           aria-describedby="gatewayHelp">
                    <small id="gatewayHelp" class="form-text text-muted">Name of the gateway to be added, the name has to be unique</small>
                </div>

                <label for="InputLong">Location</label>
                <div class="row">
                    <div class="col">
                        <input type="text" class="form-control" placeholder="Latitude" id="InputLat" name="latitude"
                               aria-describedby="locationHelp">
                        <small id="locationHelp" class="form-text text-muted">Latitude of the gateway</small>
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" placeholder="Longitude" id="InputLong"
                               name="longitude" aria-describedby="locationHelp">
                        <small id="locationHelp" class="form-text text-muted">Longitude of the gateway</small>
                    </div>
                </div>

                <div class="form-group">
                    <label for="InputDescription">Description</label>
                    <input type="text" class="form-control" id="InputLocation" name="description"
                           aria-describedby="descriptionHelp">
                    <small id="descriptionHelp" class="form-text text-muted">Description of the gateway
                        (optional)</small>
                </div>

                <button type="submit" id="addAll" class="btn btn-primary">Create Gateway</button>

            </form>

        </div>
    </div>
</div>