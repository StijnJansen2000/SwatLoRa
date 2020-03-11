<?php
include 'php/dbh.php';
?>
<div class="container mt-3 mb-3">
    <div class="d-flex justify-content-center">
        <div class="col-lg-6 col-md-12">

            <?php
//            if (isset($_SESSION['config'])) {
//                echo '<div class="alert alert-primary" role="alert">';
//                echo $_SESSION['config'];
//                echo '</div>';
//
//                echo $_SESSION['providerID'] . "<br>";
//                echo $_SESSION['host'] . "<br>";
//                echo $_SESSION['token'] . "<br>";
//            }

            echo $_SESSION['config'];
            ?>

            <h1>Existing Config:</h1>

            <form action="php/Econfig.php" method="post">

                <div class="form-group">
                    <select class="form-control" id="configSettings" name="configSettings">
                        <?php
                        $query = $conn->prepare('SELECT * FROM config');
                        $query->execute();

                        foreach ($query as $result) {
                            ?>
                            <option name="name" value="<?= $result['name'] ?>"><?= $result['name'] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Set this Config</button>

            </form>

            <h1>New Config:</h1>

            <form action="php/Nconfig.php" method="post">
                <div class="form-group">
                    <label for="InputName">Name</label>
                    <input type="text" class="form-control" id="InputName" name="name" aria-describedby="nameHelp"
                           required>
                    <small id="nameHelp" class="form-text text-muted">Here needs to be a name to which you can save this
                        config information</small>
                </div>
                <div class="form-group">
                    <label for="InputHost">URL / Host</label>
                    <input type="text" class="form-control" id="InputHost" name="host" aria-describedby="hostHelp"
                           required>
                    <small id="hostHelp" class="form-text text-muted">Here needs to be your url / host to make a
                        connection to your server</small>
                </div>
                <div class="form-group">
                    <label for="InputID">Provider ID</label>
                    <input type="text" class="form-control" id="InputID" name="provider_id" aria-describedby="IdHelp"
                           required>
                    <small id="IdHelp" class="form-text text-muted">Here needs to be your ProviderID to make a
                        connection to your sensors</small>
                </div>
                <div class="form-group">
                    <label for="InputToken">Token</label>
                    <input type="text" class="form-control" id="InputToken" name="token" aria-describedby="TokenHelp"
                           required>
                    <small id="TokenHelp" class="form-text text-muted">Here needs to be your Token to verify that it is
                        your server</small>
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Create and Set Config</button>
            </form>

        </div>
    </div>
</div>