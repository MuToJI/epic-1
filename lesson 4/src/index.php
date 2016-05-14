<?php

$files = glob(__DIR__ . '/../messages/*');

?>
<html>
<head></head>
<body>
<?php foreach ($files as $file): ?>
    <h1><?= basename($file) ?></h1>
    <div><?= nl2br(htmlentities(file_get_contents($file))) ?></div>
<?php endforeach; ?>
</body>
</html>
