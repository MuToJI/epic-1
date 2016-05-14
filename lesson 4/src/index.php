<?php

if (!empty($_GET['title']) && !empty($_GET['message'])) {
    file_put_contents(__DIR__ . '/../messages/' . $_GET['title'], $_GET['message']);
}

$files = glob(__DIR__ . '/../messages/*');

?>
<html>
<head></head>
<body>
<?php foreach ($files as $file): ?>
    <h1><?= basename($file) ?></h1>
    <div><?= nl2br(htmlentities(file_get_contents($file))) ?></div>
<?php endforeach; ?>

<form method="GET">
    <input type="text" name="title"/><br>
    <textarea name="message" id="" cols="30" rows="10"></textarea><br>
    <input type="submit"/>
</form>

</body>
</html>
