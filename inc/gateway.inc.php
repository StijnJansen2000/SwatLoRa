<div class="container mt-3">
    <?php
    if (isset($_SESSION['config'])) {
        echo '<div class="alert alert-primary" role="alert">';
        echo $_SESSION['config'];
        echo '</div>';
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
<!--                                  <a href="?page=edit" class="btn btn-primary">Edit</a>-->
                                  <a href="?page=map" class="btn btn-success">Go Map</a>
                                  <a href="?page=delete" class="btn btn-danger">Delete</a>
                              </td>
                        </tr>
                    <?php
                }



//            $query = $conn->prepare('SELECT * FROM `config` WHERE name=:name');
//
//            $result = $query->fetch(PDO::FETCH_ASSOC);

//            for ($i = 0; $i < 5; $i++) {
//                ?>
<!--                <tr>-->
<!--                    <th scope="row">--><?php //echo $i + 1 ?><!--</th>-->
<!--                      <td>--><?php //echo "Name " . $i ?><!--</td>-->
<!--                      <td>--><?php //echo "Location " . $i ?><!--</td>-->
<!--                      <td>--><?php //echo "Description " . $i ?><!--</td>-->
<!--                      <td>--><?php //echo "Provider " . $i ?><!--</td>-->
<!--                      <td style='white-space: nowrap'>-->
<!--                          <a href="?page=edit" class="btn btn-primary">Edit</a>-->
<!--                          <a href="?page=map" class="btn btn-success">Go Map</a>-->
<!--                          <a href="?page=delete" class="btn btn-danger">Delete</a>-->
<!--                      </td>-->
<!--                </tr>-->
<!--                --><?php
//            }
            ?>
            </tbody>
        </table>
        </pre>
        <?php
        } else {
            echo '<div class="alert alert-primary" role="alert">';
            echo "Please set the config first";
            echo '</div>';
        }
        ?>
    </div>
</div>
