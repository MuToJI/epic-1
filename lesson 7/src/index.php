<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

$connection = new \PDO("mysql:host=localhost;dbname=blog", 'root', 'vagrant', [
   \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
   \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
   \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
]);

$user = require 'authorization.php';

$message_id = null;

if (!empty($_GET['action'])) {
    switch ($_GET['action']) {

        case 'show':
            if (isset($_GET['message_id'])) {
                $message_id = (int)$_GET['message_id'];
            }
            break;

        case 'save':
            if (!empty($_GET['message'])) {
                $params = [
                   ':message' => $_GET['message'],
                ];
                if (isset($_GET['message_id'])) {
                    $params[':message_id'] = $_GET['message_id'];
                    $sql = 'UPDATE `messages` SET `message`=:message, `time`=NOW(), `user_id`=0 WHERE `id`=:message_id';
                } else {
                    $sql = 'INSERT INTO `messages` SET `message`=:message, `time`=NOW(), `user_id`=0';
                }
                $query = $connection->prepare($sql);
                $query->execute($params);
                header('Location:http://epic-blog/lesson%207/src/index.php');
            }
            break;
    }
}

if (!empty($_POST['action'])) {
    switch ($_POST['action']) {
        case 'save':
            if (!empty($_POST['message'])) {
                $params = [
                   ':message' => $_POST['message'],
                ];
                if (isset($_POST['message_id'])) {
                    $params[':message_id'] = $_POST['message_id'];
                    $sql = 'UPDATE `messages` SET `message`=:message, `user_id`=0 WHERE `id`=:message_id';
                } else {
                    $sql = 'INSERT INTO `messages` SET `message`=:message, `time`=NOW(), `user_id`=0';
                }
                $query = $connection->prepare($sql);
                $query->execute($params);
                header('Location:http://epic-blog/lesson%207/src/index.php');
            }
            break;
    }
}

$messages =
   $message_id === null
      ? $connection->query('SELECT m.`id`,m.`message`,m.`time`,u.`login` FROM `messages` m LEFT JOIN `users` u ON m.`user_id`=u.`id` ORDER BY m.`time` DESC')->fetchAll()
      : $connection->query("SELECT m.`id`,m.`message`,m.`time`,u.`login` FROM `messages` m LEFT JOIN `users` u ON m.`user_id`=u.`id` WHERE m.`id`={$message_id} ORDER BY m.`time` DESC")->fetchAll();

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
<a href="http://epic-blog/lesson%207/src/index.php"><h1>Epic blog</h1></a>
<?php if (!empty($messages)): ?>
    <?php foreach ($messages as $message): ?>
        <div class="message">
            <a href="http://epic-blog/lesson%207/src/index.php?action=show&message_id=<?= $message['id'] ?>"><h2>message № <?= $message['id'] ?></h2></a>

            <div><?= htmlspecialchars($message['message']); ?></div>
            <span class="left"><?= $message['login']; ?></span>
            <span class="right"><?= $message['time']; ?></span>
        </div>
        <br/>
    <?php endforeach ?>
<?php endif ?>
<form action="http://epic-blog/lesson%207/src/index.php" method="post">
    <textarea name="message" id="message" rows="10"><?= empty($message_id) ? '' : $messages[0]['message'] ?></textarea>
    <input type="hidden" name="message_id" value="<?= $message_id ?>">
    <input type="submit" name="action" value="save">
</form>
</body>
</html>
