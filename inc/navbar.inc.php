<?php
require 'permissions/roles.php';

$userArray = $menuItems['guest'];

?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="?page=home">LoRa Map Software</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <?php
                foreach ($userArray as $menuItem) {
                    if ($menuItem[2] == 'L') {
                        echo '<li class="nav-item"><a class="nav-link a" href="?page=' . $menuItem[0] . '">' . $menuItem[1] . '</a></li>';
                    }
                }
                ?>
            </ul>

            <!--Rechter navbar-->
            <ul class="navbar-nav form-inline my-2 my-md-0">
                <?php
                foreach ($userArray as $menuItem) {
                    if ($menuItem[2] == 'R') {
                        echo '<li class="nav-item"><a class="nav-link a" href="?page=' . $menuItem[0] . '">' . $menuItem[1] . '</a></li>';
                    }
                }
                ?>
            </ul>
        </div>
    </div>
</nav>
