<div class="container mt-3">
    <?php
    if (isset($_SESSION['config'])) {
        echo '<div class="alert alert-primary" role="alert">';
        echo $_SESSION['config'];
        require_once 'library.php';
        echo '</div>';
    }
    ?>

    <?php
        $server = "localhost";
        $user = "root";
        $password = "";
    ?>
        <pre>

        <h1>Manage Gateways</h1>
            <div style="white-space: nowrap">
                <button type="button" class="btn btn-primary">Load</button>
                <a href="?page=create" class="btn btn-primary">Add Gateway</a>
            </div>
        <table class="table">
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
            $conn = new mysqli($server, $user, $password);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            } else {
                if ($conn->select_db('swatlora') === true) {
                    $i = 0;
                    foreach ( $conn->query('SELECT * FROM gateway') as $row ) {
                        ?>
                        <tr>
                            <th scope="row"><?php echo $i + 1 ?></th>
                              <td><?php echo $row['name']?></td>
                              <td><?php echo $row['longitude'] . " " . $row['latitude'] ?></td>
                              <td><?php echo $row['description'] ?></td>
                              <td><?php echo " "?></td>
                              <td style='white-space: nowrap'>
                                  <a href="?page=edit" class="btn btn-primary">Edit</a>
                                  <a href="?page=map" class="btn btn-success">Go Map</a>
                                  <a href="?page=delete" class="btn btn-danger">Delete</a>
                              </td>
                        </tr>
                        <?php
                    }
                    $conn->close();
                }
            }
            ?>
            </tbody>
        </table>
        </pre>
        <?php
//        } else {
//            echo "<pre>";
//            print_r($_SESSION['config']);
//            echo "</pre>";
//            echo '<div class="alert alert-primary" role="alert">';
//            echo "Please set the config first";
//            echo '</div>';
//        }
        ?>
    </div>
</div>