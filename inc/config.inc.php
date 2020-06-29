<?php
//session_start();
include 'php/dbh.php';
?>
<div class="container mt-3 mb-3">
    <div class="d-flex justify-content-center">
        <div class="col-lg-6 col-md-12">
            <h1>Existing Config:</h1>

            <form action="php/Econfig.php" method="post">

                <?php

                if (isset($_SESSION['config'])){
                    if ($_SESSION['config'] != "Config is set"){
                        echo '<div class="alert alert-danger" role="alert">';
                        echo $_SESSION['config'];
                        echo '</div>';
                        ?>
                        <div class="form-group">
                            <select class="form-control" id="configSettings" name="configSettings">
                                <?php
                                $query1 = $conn->prepare('SELECT * FROM config');
                                $query1->execute();

                                foreach ($query1 as $result) {
                                    ?>
                                    <option name="name" value="<?= $result['name'] ?>"><?= $result['name'] ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div><?php
                    } else {
                        ?>
                        <div class="form-group">
                            <select class="form-control" id="configSettings" name="configSettings">
                                <?php
                                $query = $conn->prepare('SELECT * FROM config WHERE config_id <> :id');
                                $query->execute(array(
                                    ":id" => $_SESSION['config_id']
                                ));
//                                print_r($_SESSION);
                                ?>

                                <option name="name" value="<?= $_SESSION['name'] ?>"><?= $_SESSION['name'] ?></option>
                                <?php
                                foreach ($query as $result) {
                                    ?>
                                    <option name="name" value="<?= $result['name'] ?>"><?= $result['name'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <?php
                    }
                } else {
                    ?>
                    <div class="form-group">
                        <select class="form-control" id="configSettings" name="configSettings">
                            <?php
                            $query1 = $conn->prepare('SELECT * FROM config');
                            $query1->execute();

                            foreach ($query1 as $result) {
                                ?>
                                <option name="name" value="<?= $result['name'] ?>"><?= $result['name'] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                <?php
                }
                ?>

                <button type="submit" name="submit" class="btn btn-primary">Set this Config</button>

            </form>

            <h1>New Config:</h1>

            <form action="php/Nconfig.php" method="post">
                <div class="form-group">
                    <label for="InputName">Name</label>
                    <input type="text" class="form-control" id="InputName" name="name" aria-describedby="nameHelp"
                           required value="<?php if (isset($_SESSION['config']) && $_SESSION['config'] == "Config is set") {echo $_SESSION['name'];} ?>">
                    <small id="nameHelp" class="form-text text-muted">Here needs to be a name to which you can save this
                        config information</small>
                </div>
                <div class="form-group">
                    <label for="InputHost">URL / Host</label>
                    <input type="text" class="form-control" id="InputHost" name="host" aria-describedby="hostHelp"
                           required value="<?php if (isset($_SESSION['config']) && $_SESSION['config'] == "Config is set") {echo $_SESSION['host'];} ?>">
                    <small id="hostHelp" class="form-text text-muted">Here needs to be your url / host to make a
                        connection to your server</small>
                </div>
                <div class="form-group">
                    <label for="InputID">Provider ID</label>
                    <input type="text" class="form-control" id="InputID" name="provider_id" aria-describedby="IdHelp"
                           required value="<?php if (isset($_SESSION['config']) && $_SESSION['config'] == "Config is set") {echo $_SESSION['provider_id'];} ?>">
                    <small id="IdHelp" class="form-text text-muted">Here needs to be your ProviderID to make a
                        connection to your sensors</small>
                </div>
                <div class="form-group">
                    <label for="InputToken">Token</label>
                    <input type="text" class="form-control" id="InputToken" name="token" aria-describedby="TokenHelp"
                           required value="<?php if (isset($_SESSION['config']) && $_SESSION['config'] == "Config is set") {echo $_SESSION['token'];} ?>">
                    <small id="TokenHelp" class="form-text text-muted">Here needs to be your Token to verify that it is
                        your server</small>
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Create and Set Config</button>
            </form>

        </div>
    </div>
</div>