<div class="container mt-3">

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
        for ($i = 0; $i < 5; $i++) {
            $boolean = rand(0, 1);
            ?>
            <tr>
                <td><input type="checkbox"> </td>
                <th scope="row"><?php echo $i + 1 ?></th>
                <td><?php echo "Name of Data" . $i ?></td>
                <td><?php echo "Description of Data" . $i ?></td>
                <td><?php echo "Date of data " . $i ?></td>
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
        }
        ?>
        </tbody>
    </table>

    <a href="" class="btn btn-primary">Load</a>
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