<div class="container mt-3 mb-3">
    <?php
    if (isset($_SESSION['config'])) {
        include 'php/dbh.php';
    ?>
    <h1>Data Management</h1>
    <a href="?page=addData" class="btn btn-primary">Add Data</a>
    <form method="post" action="?page=map">
    <table class="table mt-2">
        <thead class="thead-dark">
        <tr>
            <th scope="col">Select</th>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">From</th>
            <th scope="col">To</th>
            <th scope="col">Gateway</th>
            <th scope="col">Manage</th>
            <th scope="col">Loaded</th>
        </tr>
        </thead>
        <tbody>

        <?php
        $id = $_SESSION['config_id'];

        $query = $conn->prepare("
                SELECT  D.data_id AS data_id,
                        D.dataName AS dataName,
                        D.latitude AS latitude,
                        D.longitude AS longitude,
                        D.gpsquality AS gps,
                        D.rssi AS rssi,
                        D.snr AS snr,
                        D.dateFrom AS dateFrom,
                        D.dateTo AS dateTo,
                        D.component AS component,
                        D.gateway_id AS gateway_id,
                        G.name AS gatewayName
                FROM data AS D
                INNER JOIN gateway as G ON D.gateway_id = G.gateway_id
                INNER JOIN config AS C ON G.config_id = C.config_id
                WHERE C.config_id=:id
            ");

        $query->execute(array(
            ":id" => $id
        ));
        $i = 1;
        foreach ($query as $row) {
            $boolean = rand(0, 1);
            ?>
            <tr>
                <td><input type="checkbox" name="<?= $row['dataName']?>"></td>
                <th scope="row"><?php echo $i ?></th>
                <td><?= $row['dataName']?></td>
                <td><?= $row['dateFrom']?></td>
                <td><?= $row['dateTo'] ?></td>
                <td><?= $row['gatewayName'] ?></td>
                <td style='white-space: nowrap'>
                    <div class="row">
                        <form action="?page=editData" method="post">
                            <input type="hidden" name="data_id" value="<?= $row['data_id'] ?>">
                            <button type="submit" name="submit" class="btn">
                                <i class="fas fa-edit"></i>
                            </button>
                        </form>
                        &nbsp;
                        <form action="php/deleteData.php" method="post"
                              onsubmit="return confirm('Are you sure you want to delete data: <?= $row['component'] ?>?');">
                            <input type="hidden" name="data_id" value="<?= $row['data_id'] ?>">
                            <button type="submit" name="submit" class="btn">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                        &nbsp;
                        <form action="?page=map" method="post">
                            <input type="hidden" name="dataName" value="<?= $row['dataName'] ?>">
                            <button type="submit" name="submitSpec" class="btn">
                                <i class="fas fa-map-marked-alt"></i>
                            </button>
                        </form>
                    </div>
                </td>

                <td style="white-space: nowrap">
                    <?php
                    if ($boolean == 1) {
                        echo "<span class=\"badge badge-success\"> </span>";

                    } else {
                        echo "<span class=\"badge badge-danger\"> </span>";
                    }

                    ?>
                </td>
            </tr>

            <?php
            $i++;
        }
        ?>
        </tbody>
    </table>
        <input type="submit" name="submitLoad" value="Load on Map" class="btn btn-primary"><?php
        ?>
        </form>


    <?php
            } else {
                echo '<div class="alert alert-primary" role="alert">';
                echo "Please set the config first";
                echo '</div>';
                echo "<a href='?page=config' class='btn btn-primary'>Set Config here</a>";
            }
    ?>
</div>
