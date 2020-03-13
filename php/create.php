<?php
session_start();
include 'dbh.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.2/jquery.fancybox.min.css">
    <!--===============================================================================================-->
    <title>Library Test Environment</title>
</head>
<body>

<?php require 'navbar.php'; ?>

<div class="container mt-3">
    <?php

        $gateway = htmlspecialchars($_POST['gateway']);
        $lat = htmlspecialchars($_POST['latitude']);
        $long = htmlspecialchars($_POST['longitude']);
        $desc = htmlspecialchars($_POST['description']);
        $provider = htmlspecialchars($_POST['gateway']);

        function convertToBCD($val){
            if (strpos($val, '.') !== false) {
                $vars = explode(".",$val);
            } elseif (strpos($val, ',')!== false){
                $vars = explode(".",$val);
            }

            $deg = $vars[0];
            $tempma = "0.".$vars[1];

            $tempma = $tempma * 3600;
            $min = floor($tempma / 60);
            $sec = $tempma - ($min*60);

            $bcd = $deg . "°" . $min . "," . abs($sec);
            echo $bcd;
            return $bcd;
        }

//        echo "<br>";
//        convertToBCD($long);
//        echo "<br>";
//        convertToBCD($lat);

        $query = $conn->prepare('SELECT * FROM `gateway` WHERE name=:name');
        $query->execute(array(
            ':name' => $gateway
        ));
        $result = $query->fetch(PDO::FETCH_ASSOC);
        if ($query->rowCount() == 0){
            $sql = "SELECT config_id FROM `config` WHERE name='" . $_SESSION['name'] ."';";
            $result = $conn->query($sql);
            $result = ($result->fetch());
            $result = $result['config_id'];

            $query1 = $conn->prepare('INSERT INTO gateway SET gateway_id=:id, name=:name, longitude=:longitude, latitude=:latitude, description=:description, config_id=:cid');
            if (!$query1) {
                echo "\nPDO::errorInfo():\n";
                echo '<div class="alert alert-danger" role="alert">';
                    print_r($query1->errorInfo());
                echo '</div>';
            } else {
                $query1->execute(array(
                    ':id' => NULL,
                    ':name' => $gateway,
                    ':longitude' => $long,
                    ':latitude' => $lat,
                    ':description' => $desc,
                    ':cid' => $result
                ));
                echo '<div class="alert alert-success" role="alert">';
                echo "Gateway created successfuly";
                echo '</div>';
            }

            echo "<a href='../?page=home' class='btn btn-primary btn-sm' tabindex='-1' role='button' aria-disabled='true' align='center'>Home</a>";
            echo "<a href='../?page=create' class='btn btn-secondary btn-sm' tabindex='-1' role='button' aria-disabled='true' align='center'>Create another gateway</a>";


        } else {
            echo '<div class="alert alert-danger" role="alert">';
            echo "Gateway name already exists";
            echo '</div>';
            echo '<a href="javascript:history.back(1)" class="btn btn-primary btn-sm" tabindex="-1" role="button" aria-disabled="true">Go Back</a>';
        }
        ?>
</div>
</body>

