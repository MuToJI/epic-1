<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require 'blog.php';

define('SITE_URL', 'http://epic-blog/lesson%208/src/index.php');

$connection = connection(['host' => 'localhost', 'dbname' => 'blog', 'user' => 'root', 'password' => 'vagrant', 'encoding' => 'utf8']);

$message_id = empty($_REQUEST['message_id']) ? null : (int)$_REQUEST['message_id'];
$message = empty($_REQUEST['message']) ? null : $_REQUEST['message'];

if (!empty($message)) {
    isset($message_id)
       ? update_message($connection, $message, $message_id)
       : insert_message($connection, $message, 0);
    header('Location:' . SITE_URL);
}

$messages = load_messages($connection, $message_id);

$style = 'main';
if (isset($_COOKIE['style'])) {
    switch ((int)$_COOKIE['style']) {
        case 1:
            $style = 'black';
            break;
        case 2:
            $style = 'yellow';
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>epic blog</title>
    <link rel="stylesheet" href="<?= $style ?>.css">
</head>
<body>
<a href="<?= SITE_URL?>"><h1>Epic blog</h1></a>
<?php if (!empty($messages)): ?>
    <?php foreach ($messages as $message): ?>
        <div class="message">
            <a href="<?= SITE_URL?>?message_id=<?= $message['id'] ?>"><h2>message № <?= $message['id'] ?></h2></a>

            <div><?= htmlspecialchars($message['message']); ?></div>
            <span class="left"><?= $message['login']; ?></span>
            <span class="right"><?= $message['time']; ?></span>
        </div>
        <br/>
    <?php endforeach ?>
<?php endif ?>
<form action="<?= SITE_URL?>" method="post">
    <textarea name="message" id="message" rows="10"><?= empty($message_id) ? '' : $messages[0]['message'] ?></textarea>
    <input type="hidden" name="message_id" value="<?= $message_id ?>">
    <input type="submit" name="action" value="save">
</form>
</body>
</html>
