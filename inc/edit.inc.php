<div class="container mt-3">
    <div class="d-flex justify-content-center">
        <div class="col-lg-6 col-md-12">

            <h1>Edit a Gateway</h1>
            <form action="php/edit.php" method="post">

                <div class="form-group">
                    <label for="InputLocation">Location</label>
                    <input type="text" class="form-control" id="InputLocation" name="location"
                           aria-describedby="locationHelp">
                    <small id="locationHelp" class="form-text text-muted">Location of the gateway</small>
                </div>

                <div class="form-group">
                    <label for="InputDescription">Description</label>
                    <input type="text" class="form-control" id="InputLocation" name="description"
                           aria-describedby="descriptionHelp">
                    <small id="descriptionHelp" class="form-text text-muted">Description of the gateway</small>
                </div>

                <div class="form-group">
                    <label for="InputLocation">Provider</label>
                    <input type="text" class="form-control" id="InputLocation" name="provider"
                           aria-describedby="providerHelp">
                    <small id="providerHelp" class="form-text text-muted">Name of the provider</small>
                </div>

                <button type="submit" id="addAll" class="btn btn-primary">Edit Gateway</button>

            </form>
        </div>
    </div>
</div>