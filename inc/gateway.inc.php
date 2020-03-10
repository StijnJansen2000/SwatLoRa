<div class="container mt-3">

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
            for ($i = 0; $i < 5; $i++) {
                ?>
                <tr>
                    <th scope="row"><?php echo $i + 1 ?></th>
                      <td><?php echo "Name " . $i ?></td>
                      <td><?php echo "Name " . $i ?></td>
                      <td><?php echo "Name " . $i ?></td>
                      <td><?php echo "Name " . $i ?></td>
                      <td style='white-space: nowrap'>
                          <button type="button" class="btn btn-primary">Edit</button>
                          <button type="button" class="btn btn-success  ">Go Map</button>
                          <button type="button" class="btn btn-danger">Delete</button>
                      </td>
                </tr>
                <?php
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