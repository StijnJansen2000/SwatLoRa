<div class="container mt-3 mb-3">
    <?php
    if (isset($_SESSION['config'])) {
        if ($_SESSION['config'] == "Config is incorrect"){
            echo '<div class="alert alert-danger" role="alert" style="text-align:center">';
            echo $_SESSION['config'] . "<br>";
            echo "Please set a correct config first";
            echo '</div>';
            echo "<a href='?page=config' class='btn btn-primary'>Set Config here</a>";
        } else {
            ?>
            <h1>Data <?= $_POST['name'] ?>:</h1>

            <form method="post" action="?page=map">
                <table class="table mt-2">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">RSSI</th>
                        <th scope="col">SNR</th>
                        <th scope="col">Latitude</th>
                        <th scope="col">Longitude</th>
                        <th scope="col">Gateway</th>
                        <th scope="col">Gateway Latitude</th>
                        <th scope="col">Gateway Longitude</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?= $_POST['rssi'] ?></td>
                            <td><?= $_POST['snr'] ?></td>
                            <td><?= $_POST['lat'] ?></td>
                            <td><?= $_POST['long'] ?></td>
                            <td><?= $_POST['gateway'] ?></td>
                            <td><?= $_POST['gLat'] ?></td>
                            <td><?= $_POST['gLong'] ?></td>
                        </tr>
                    </tbody>
                </table>
            </form>
            <a href="?page=data" class="btn btn-primary">Go Back</a>

            <?php
        }
    } else {
        echo '<div class="alert alert-primary" role="alert">';
        echo "Please set the config first";
        echo '</div>';
        echo "<a href='?page=config' class='btn btn-primary'>Set Config here</a>";
    }
    ?>
</div>
