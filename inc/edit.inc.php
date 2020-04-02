<?php
include "php/dbh.php";

if (isset($_POST['submit'])){
    $id = $_POST['id'];

    $query = $conn->prepare("SELECT * FROM gateway WHERE gateway_id=:id");
    $query->execute(array(
        ":id" => $id
    ));

    $result = $query->fetch(PDO::FETCH_ASSOC);

    $query2 = $conn->prepare("SELECT * FROM config WHERE config_id=:id");
    $query2->execute(array(
        ":id" => $result['config_id']
    ));

    $result2 = $query2->fetch(PDO::FETCH_ASSOC);
}
?>

<div class="container mt-3">
    <div class="d-flex justify-content-center">
        <div class="col-lg-6 col-md-12">

            <h1 class="display-6">Edit a Gateway</h1>

            <form action="php/edit.php" method="post">

                <input type="hidden" name="gateway_id" value="<?= $result['gateway_id'] ?>">

                <h4>Name: <?= $result['name'] ?></h4>
                <div class="form-group">
                    <label for="InputProvider">Name</label>
                    <input type="text" class="form-control" id="InputProvider" name="provider"
                           aria-describedby="providerHelp" value="<?= $result['name'] ?>" placeholder="<?= $_SESSION['name'] ?>" disabled>
                    <small id="providerHelp" class="form-text text-muted">Name of the provider</small>
                </div>

                <div class="row">
                    <div class="col">
                            <label for="InputLatitude">Latitude</label>
                            <input type="text" class="form-control" placeholder="Latitude" id="InputLatitude" name="latitude"
                                   aria-describedby="locationHelp" value="<?= $result['latitude'] ?>">
                            <small id="locationHelp" class="form-text text-muted">Latitude of the gateway</small>
                        <label for="InputLongitude">Longitude</label>
                        <input type="text" class="form-control" placeholder="Longitude" id="InputLongitude"
                               name="longitude" aria-describedby="locationHelp"
                               value="<?= $result['longitude'] ?>">
                        <small id="locationHelp" class="form-text text-muted">Longitude of the gateway</small>
                    </div>
                </div>

                <div class="form-group">
                    <label for="InputDescription">Description</label>
                    <input type="text" class="form-control" id="InputDescription" name="description"
                           aria-describedby="descriptionHelp" value="<?= $result['description'] ?>">
                    <small id="descriptionHelp" class="form-text text-muted">Description of the gateway</small>
                </div>

                <div class="form-group">
                    <label for="InputProvider">Provider</label>
                    <input type="text" class="form-control" id="InputProvider" name="provider"
                           aria-describedby="providerHelp" value="<?= $result2['provider'] ?>" placeholder="<?= $result2[' provider'] ?>" disabled>
                    <small id="providerHelp" class="form-text text-muted">Name of the provider</small>
                </div>

                <button type="submit" name="submit" class="btn btn-primary">Edit Gateway</button>

            </form>

        </div>
    </div>
</div>