<div class="container mt-3" xmlns="http://www.w3.org/1999/html">
    <?php
    if (isset($_SESSION['config'])) {
        include 'php/dbh.php';
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
                        <form action="?page=edit" method="post">
                            <input type="hidden" id="gateway" name="gateway" value="<?php echo $row['name']?>">
                            <input type="hidden" id="longitude" name="longitude" value="<?php echo $row['longitude']?>">
                            <input type="hidden" id="latitude" name="latitude" value="<?php echo $row['latitude']?>">
                            <input type="hidden" id="description" name="description" value="<?php echo $row['description']?>">
                            <input type="hidden" id="provider" name="provider" value="<?php echo " "  ?>">
                            <button type="submit" name="editValue" class="btn btn-primary">Edit</button>
                        </form>
                        <form action="php/delete.php" method="post" onsubmit="return confirm('Are you sure you want to delete gateway: <?php echo $row['name'] ?>?');">
                            <input type="hidden" id="gateway" name="gateway" value="<?php echo $row['name']?>">
                            <button type="submit" name="deleteGateway" class="btn btn-danger">Delete</button>
                        </form>
                                  <a href="?page=map" class="btn btn-success">Go Map</a>
                              </td>
                        </tr>
                    <?php
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
