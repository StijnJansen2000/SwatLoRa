<div class="container mt-3">
    <div class="d-flex justify-content-center">
        <div class="col-lg-6 col-md-12">

            <?php
            if (isset($_SESSION['config'])) {
                echo '<div class="alert alert-primary" role="alert">';
                echo $_SESSION['config'];
                require_once 'library.php';
                echo '</div>';
            }
            ?>

            <body style="text-align:center;">
            <div class="text-center">
                Which gateway do you want to delete?
                <form action="php/delete.php" method="post" onsubmit="return confirm('Are you sure you want to delete this gateway?');">
                    <div class="form-group">
                        <select class="form-control" name="selectGateway" id="selectGateway">
                            <option>List of gateways here</option>
                        </select>
                    </div>

                <button type="submit" name="confirmDelete" value="Confirm" class="btn btn-primary">Confirm</button>

                </form>
                <?php

//                } else {
//                    echo '<div class="alert alert-primary" role="alert">';
//                    echo "Please set the config first";
//                    echo '</div>';
//                }
                ?>
            </div>
        </div>
    </div>