<div class="container mt-3">
    <?php
    if (isset($_SESSION['config'])) {
        require_once 'library.php';
    ?>
        <pre>

        <h1>Map goes here</h1>

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