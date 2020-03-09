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
            <form action="php/config.php" method="post">
                <div class="form-group">
                    <label for="InputUrl">URL / Host</label>
                    <input type="text" class="form-control" id="InputUrl" name="url" aria-describedby="urlHelp" value="<?php if (isset($_SESSION['config'])) {echo $_SESSION['host'];} ?>">
                    <small id="urlHelp" class="form-text text-muted">Here needs to be your url / host to make a
                        connection
                        to your server</small>
                </div>
                <div class="form-group">
                    <label for="InputID">Provider ID</label>
                    <input type="text" class="form-control" id="InputID" name="providerID" aria-describedby="IdHelp" value="<?php if (isset($_SESSION['config'])) {echo $_SESSION['providerID'];}  ?>">
                    <small id="IdHelp" class="form-text text-muted">Here needs to be your ProviderID to make a
                        connection to
                        your sensors</small>
                </div>
                <div class="form-group">
                    <label for="InputToken">Token</label>
                    <input type="text" class="form-control" id="InputToken" name="token" aria-describedby="TokenHelp" value="<?php if (isset($_SESSION['config'])) {echo $_SESSION['token'];} ?>">
                    <small id="TokenHelp" class="form-text text-muted">Here needs to be your Token to verify that it is
                        your
                        server</small>
                </div>
                <button type="submit" class="btn btn-primary">Set Config</button>
            </form>
        </div>
    </div>
</div>