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

//            print_r($_POST);
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
                WHERE C.config_id=:id AND D.data_id=:did
            ");
            $query->execute(array(
                ":id" => $id,
                ":did" => $_POST['id']
            ));
            $query = $query->fetch(PDO::FETCH_ASSOC);

            $result = showData($query['rssi'], $query['snr'], $query['latitude'], $query['longitude'], $query['dateFrom'], $query['dateTo'], 100);
            $dName = $query['dataName'];
            ?>
            <h1>Data <?= $query['dataName'] ?>:</h1>

            <form method="post" action="?page=map">
                <div class="table-responsive-sm">
                <table class="table mt-2" id="table2excel">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">RSSI</th>
                        <th scope="col">SNR</th>
                        <th scope="col">Latitude</th>
                        <th scope="col">Longitude</th>
                        <th scope="col">Time of Measurement</th>
                        <th scope="col">Sentilo Value Lat</th>
                        <th scope="col">Sentilo Value Long</th>
                        <th scope="col">Lat to hex</th>
                        <th scope="col">Long to hex</th>
                        <th scope="col">Lat hex to BCD</th>
                        <th scope="col">Long hex to BCD</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $test = array();
                    for ($j=0; $j < sizeof($result[0]); $j++){
                        for ($i=0; $i < sizeof($result[0]['observations']); $i++) {
                            $gpsLat = intval($result[2]['observations'][$i]['value']);
                            $gpsLatHex = dechex($gpsLat);
                            $gpsLatResult = formatEndian($gpsLatHex, 'N');
                            $gpsLatResult = substr_replace( $gpsLatResult, "°", 2, 0);
                            $gpsLatResult = substr_replace( $gpsLatResult, ",", 6, 0);

                            $latMinus = false;
                            $gpsLatResult = substr_replace($gpsLatResult, (substr($gpsLatResult, -1, 1) == 0)? "N" :  "S", -1);
                            if (substr($gpsLatResult,-1,1) == "S"){
                                $latMinus = true;
                            }
                            $gpsLatDD = DMStoDD(substr($gpsLatResult, 0,2), substr($gpsLatResult,4,2), substr($gpsLatResult,7,3));
                            if ($latMinus){
                                 $gpsLatResult = "-" . $gpsLatResult;
                                 $gpsLatDD = "-" . $gpsLatDD;
                            }

                            $gpsLong = intval($result[3]['observations'][$i]['value']);
                            $gpsLongHex = dechex($gpsLong);
                            $gpsLongResult = formatEndian($gpsLongHex, 'N');
                            $gpsLongResult = substr_replace( $gpsLongResult, "°", 3, 0);
                            $gpsLongResult = substr_replace( $gpsLongResult, ",", 7, 0);
                            $longMinus = false;
                            $gpsLongResult = substr_replace($gpsLongResult, (substr($gpsLongResult, -1, 1) == 0)? "E" :  "W", -1);
                            if (substr($gpsLongResult, -1,1) == "W"){
                                $longMinus = true;
                            }
                            $gpsLongDD = DMStoDD(substr($gpsLongResult, 0,3), substr($gpsLongResult,5,2), substr($gpsLongResult,8,2));
                            if ($longMinus){
                                $gpsLongResult = "-" . $gpsLongResult;
                                $gpsLongDD = "-" . $gpsLongDD;
                            }
                            ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td><?php if ($result[0]['observations'][$i]['value'][0] == "-") {
                                        echo $result[0]['observations'][$i]['value'];
                                    } else {
                                        echo "-" . result[0]['observations'][$i]['value'];
                                    }?></td>
                                <td><?= $result[1]['observations'][$i]['value'] ?></td>
                                <td><?= $gpsLatDD ?></td>
                                <td><?= $gpsLongDD ?></td>
                                <td><?= $result[0]['observations'][$i]['timestamp'] ?></td>
                                <td><?= $result[2]['observations'][$i]['value'] ?></td>
                                <td><?= $result[3]['observations'][$i]['value'] ?></td>
                                <td><?= $gpsLatHex ?></td>
                                <td><?= $gpsLongHex ?></td>
                                <td><?= $gpsLatResult ?></td>
                                <td><?= $gpsLongResult ?></td>
                            </tr>
                            <?php
                            if (!in_array($gpsLongResult , $test)){
                                array_push($test, $gpsLongResult);
                            }
                        }
                    }?>
                    </tbody>
                </table>
                </div>
            </form>
            <a href="?page=data" class="btn btn-primary">Go Back</a>
            <button id="button" class="btn btn-success">Export table to CSV file</button>

            <script type="text/javascript">
                var dName = "<?= $query['dataName'] ?>";
                function download_csv(csv, filename) {
                    var csvFile;
                    var downloadLink;

                    // CSV FILE
                    csvFile = new Blob([csv], {type: "text/csv"});

                    // Download link
                    downloadLink = document.createElement("a");

                    // File name
                    downloadLink.download = filename;

                    // We have to create a link to the file
                    downloadLink.href = window.URL.createObjectURL(csvFile);

                    // Make sure that the link is not displayed
                    downloadLink.style.display = "none";

                    // Add the link to your DOM
                    document.body.appendChild(downloadLink);

                    // Lanzamos
                    downloadLink.click();
                }

                function export_table_to_csv(html, filename) {
                    var csv = [];
                    var rows = document.querySelectorAll("table tr");

                    for (var i = 0; i < rows.length; i++) {
                        var row = [], cols = rows[i].querySelectorAll("td, th");

                        for (var j = 0; j < cols.length; j++)
                            row.push(cols[j].innerText);

                        csv.push(row.join(","));
                    }

                    // Download CSV
                    download_csv(csv.join("\n"), filename);
                }

                document.querySelector("#button").addEventListener("click", function () {
                    var html = document.querySelector("table").outerHTML;
                    export_table_to_csv(html, dName + ".csv");
                });
            </script>

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
