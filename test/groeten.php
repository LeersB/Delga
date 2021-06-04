<?php

$hour = date('G');

if($hour < 6) {
    $greeting = 'Goedenacht';
} elseif($hour < 12) {
    $greeting = 'Goedemorgen';
} elseif($hour < 18) {
    $greeting = 'Goedemiddag';
} else {
    $greeting = 'Goedenavond';
}

?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo $greeting; ?></title>
</head>
<body>
<h1><?php echo $greeting; ?></h1>
</body>
</html>