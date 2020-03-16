<div class="container mt-3">
    <?php
    if (isset($_SESSION['config'])) {
        include 'php/dbh.php';
    ?>
    <h1>Data Management</h1>
    <div style="white-space: nowrap">
        <a href="?page=addData" class="btn btn-primary">Add Data</a>
    </div>
    <table class="table">
        <thead class="thead-dark">
        <tr>
            <th scope="col">Select</th>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Description</th>
            <th scope="col">Date of data</th>
            <th scope="col">Gateway</th>
            <th scope="col">Manage</th>
            <th scope="col">Loaded</th>
        </tr>
        </thead>
        <tbody>

        <?php
        $id = $_SESSION['config_id'];

        $query = $conn->prepare("
                SELECT  D.data_id AS gateway_id,
                        D.longitude AS longitude,
                        D.latitude AS latitude,
                        D.gpsquality AS gps,
                        D.rssi AS rssi,
                        D.snr AS snr,
                        D.dateFrom AS dateFrom,
                        D.dateTo AS dateTo,
                        D.component AS component
                FROM data AS D
            ");
        $query->execute(array(
            ":id" => $id
        ));
        $i = 1;
        foreach ($query as $row) {
            $boolean = rand(0, 1);
            ?>
            <tr>
                <td><input type="checkbox"> </td>
                <th scope="row"><?php echo $i ?></th>
                <td><?php echo $row['component']?></td>
                <td><?php echo "Data from " . $row['component'] ?></td>
                <td><?php echo "from: " . $row['dateFrom'] . " to: " . $row['dateTo'] ?></td>
                <td><?php echo "Name of gateway " . $i ?></td>
                <td style='white-space: nowrap'>
                    <a href="?page=edit" class="btn btn-primary">Edit</a>
                    <a href="?page=delete" class="btn btn-danger">Delete</a>
                    <a href="?page=map" class="btn btn-success">See</a>
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

    <a href="" class="btn btn-primary">Load</a>
    <?php
            } else {
                echo '<div class="alert alert-primary" role="alert">';
                echo "Please set the config first";
                echo '</div>';
                echo "<a href='?page=config' class='btn btn-primary'>Set Config here</a>";
            }
    ?>
</div>
</div>