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
        <h1 class="display-">Data Management</h1>
            <div style="white-space: nowrap">
                <a href="" class="btn btn-primary">Add Data</a>
            </div>
        <table class="table">
            <thead class="thead-dark">
                <tr>
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
            for ($i = 0; $i < 5; $i++) {
                $boolean = rand(0,1);
                ?>
                <tr>
                    <th scope="row"><?php echo $i + 1 ?></th>
                    <td><?php echo "Name of Data" . $i ?></td>
                    <td><?php echo "Description of Data" . $i ?></td>
                    <td><?php echo "Date of data " . $i ?></td>
                    <td><?php echo "Name of gateway " . $i ?></td>
                    <td style='white-space: nowrap'>
                        <button type="button" class="btn btn-primary">Edit</button>
                        <button type="button" class="btn btn-danger">Delete</button>
                        <button type="button" class="btn btn-success">See</button>
                    </td>
                    <td style="white-space: nowrap">
                        <?php
                            if ($boolean == 1){
                                echo "<span class=\"badge badge-success\"> </span>";

                            } else {
                                echo "<span class=\"badge badge-danger\"> </span>";
                            }

                        ?>
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