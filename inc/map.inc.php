<div class="container mt-3">
    <?php
    if (isset($_SESSION['config'])) {
        echo '<div class="alert alert-primary" role="alert">';
        echo $_SESSION['config'];
        require_once 'library.php';
        echo '</div>';
    }
    ?>
        <pre>

        <h1>Map goes here</h1>

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