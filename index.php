<?php

require_once 'vendor/autoload.php';

use App\Clothing as Clothing;
use App\Electronic as Electronic;



$clothing = new Clothing();
$electronic = new Electronic();

var_dump($clothing);
var_dump($electronic);


// findOneById -------------------------
// $newClothing = $clothing->findOneById(1);
// $newElectronic = $electronic->findOneById(9);

// findAll -------------------------
// $newClothing = $clothing->findAll();
// $newElectronic = $electronic->findAll();

// create -------------------------
// $clothing->create();
// $electronic->create();

// update -------------------------
// $clothing->update();
// $electronic->update();


// var_dump($newClothing);
// var_dump($newElectronic);




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job15</title>
</head>

<body>
    <h1>Job15</h1>
</body>

</html>