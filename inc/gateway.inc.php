<div class="container mt-3">
    <div class="d-flex justify-content-center">

        <?php
        if (isset($_SESSION['config'])) {
            echo '<div class="alert alert-primary" role="alert">';
            echo $_SESSION['config'];
            echo '</div>';


        }
        ?>

    </div>
<!--    <div class="d-flex justify-content-center">-->

        <pre>
        <?php

        ?>
        <h1 class="display-3    ">Manage gateways</h1>
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