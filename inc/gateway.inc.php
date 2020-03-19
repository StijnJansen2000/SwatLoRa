<div class="container mt-3" xmlns="http://www.w3.org/1999/html">
    <?php
    if (isset($_SESSION['config'])) {
        include 'php/dbh.php';
        ?>
        <pre>

        <h1>Manage Gateways</h1>
            <div style="white-space: nowrap">
                <a href="?page=create" class="btn btn-primary">Add Gateway</a>
            </div>
        <table class="table w-100">
            <thead class="thead-dark">
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Name</th>
                  <th scope="col">Location</th>
                  <th scope="col">Description</th>
                  <th scope="col">Provider</th>
                  <th scope="col">Manage</th>
                </tr>
            </thead>
            <tbody>

            <?php
            $id = $_SESSION['config_id'];

            $query = $conn->prepare("
                SELECT  G.gateway_id AS gateway_id,
                        G.name AS name,
                        G.longitude AS longitude,
                        G.latitude AS latitude,
                        G.description AS description,
                        C.name AS provider
                FROM gateway AS G
                INNER JOIN config AS C ON G.config_id = C.config_id
                WHERE G.config_id=:id
            ");
            $query->execute(array(
                ":id" => $id
            ));

            $i = 1;
            foreach ($query as $row) {
                ?>
                <tr>
                     <td><?php echo $i; ?></td>
                     <td><?= $row['name'] ?></td>
                     <td><?= $row['longitude'] . " " . $row['latitude'] ?></td>
                     <td><?= $row['description'] ?></td>
                     <td><?= $row['provider'] ?></td>
                     <td style='white-space: nowrap'>
                        <div class="row">
                            <form action="?page=edit" method="post">
                                <input type="hidden" id="gateway" name="id" value="<?= $row['gateway_id'] ?>">
                                <button type="submit" name="submit" class="btn">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </form>
                            &nbsp;
                            <form action="php/delete.php" method="post"
                                  onsubmit="return confirm('Are you sure you want to delete gateway: <?= $row['name'] ?>?');">
                                <input type="hidden" id="gateway" name="gateway_id" value="<?= $row['gateway_id'] ?>">
                                <button type="submit" name="deleteGateway" class="btn">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                            &nbsp;
                            <form action="?page=map" method="post">
                                <input type="hidden" id="gateway" name="gateway" value="<?= $row['gateway_id'] ?>">
                                <button type="submit" name="deleteGateway" class="btn">
                                    <i class="fas fa-map-marked-alt"></i>
                                </button>
                            </form>
                        </div>
                     </td>
                </tr>
                <?php
                $i++;
            }
            ?>
            </tbody>
        </table>
        </pre>
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
