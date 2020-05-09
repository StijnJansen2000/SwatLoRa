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
        include 'php/dbh.php';
        require 'php/library.php';
        ?>
        <h1>Data Management</h1>
        <a href="?page=addData" class="btn btn-primary">Add Data</a>
        <a href="?page=addExcel" class="btn btn-success">Import from Excel file</a>
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
                        D.oneValue AS oneValue,
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
                    ?>
                    <tr>
                        <td><input type="checkbox" name="<?= $row['dataName'] ?>"></td>
                        <th scope="row"><?php echo $i ?></th>
                        <td><?= $row['dataName'] ?></td>
                        <td><?= $row['dateFrom'] ?></td>
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
//                            echo "<pre>";
//                            print_r($row);
//                            echo "</pre>";

                            $gID = $row['gateway_id'];

                            $sep = $conn->prepare("
                                SELECT longitude AS gatewayLong,
                                       latitude AS gatewayLat
                                FROM gateway
                                WHERE gateway_id = $gID ");

                            $sep->execute();
                            $res = $sep->fetch(PDO::FETCH_ASSOC);
                            $latitude = $res['gatewayLat'];
                            $longitude = $res['gatewayLong'];

                            if ($row['oneValue'] != ""){
                                $checkValues = oneSensorData($row['oneValue'], $row['dateFrom'], $row['dateTo'], $row['gatewayName'], $latitude, $longitude);
                                if ($checkValues == ""){
                                    echo "<span class=\"badge badge-danger\"> </span>";
                                    echo " No data loaded for these dates";
                                } else {
                                    echo "<span class=\"badge badge-success\"> </span>";
                                }
                            } else {
                                $checkValues = seperateData($row['rssi'], $row['snr'], $row['latitude'], $row['longitude'], $row['dateFrom'], $row['dateTo'], $row['gatewayName'], $latitude, $longitude);
                                if ($checkValues == ""){
                                    echo "<span class=\"badge badge-danger\"> </span>";
                                    echo " No data loaded for these dates";
                                } else {
                                    ?>
                                    <form action="?page=showData" method="post">
                                        <input type="hidden" name="id" value="<?= $row['data_id'] ?>">
                                        <input type="submit" name="loadData" value="Show data" class="btn btn-success">
                                    </form>
                            <?php

                                }
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
    }
            } else {
                echo '<div class="alert alert-primary" role="alert">';
                echo "Please set the config first";
                echo '</div>';
                echo "<a href='?page=config' class='btn btn-primary'>Set Config here</a>";
            }
    ?>
</div>
