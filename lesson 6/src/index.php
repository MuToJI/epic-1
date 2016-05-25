<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

$connection = new PDO("mysql:host=localhost;dbname=blog", 'root', 'vagrant', [
   PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
   PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
   PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
]);

$message_id = (isset($_GET['message_id'])) ? (int)$_GET['message_id'] : null;

if (!empty($_GET['message'])) {
    $params = [
       ':message' => $_GET['message'],
    ];

    $query = $connection->prepare($sql);
    $query->execute($params);
    header('Location:http://epic-blog/lesson%206/src/index.php');
}

if (!empty($_POST['action']) && $_POST['action'] === 'save' && !empty($_POST['message'])) {
    $params[':message'] = $_POST['message'];
    if (!empty($message_id)) {
        $params[':message_id'] = $message_id;
        $sql = 'UPDATE `messages` SET `message`=:message, `time`=NOW(), `user_id`=0 WHERE `id`=:message_id';
    } else {
        $sql = 'INSERT INTO `messages` SET `message`=:message, `time`=NOW(), `user_id`=0';
    }
    $query = $connection->prepare($sql);
    $query->execute($params);
    header('Location:http://epic-blog/lesson%206/src/index.php');
}

$messages =
   $message_id === null
      ? $connection->query('SELECT m.`id`,m.`message`,m.`time`,u.`login` FROM `messages` m LEFT JOIN `users` u ON m.`user_id`=u.`id` ORDER BY m.`time` DESC')->fetchAll()
      : $connection->query("SELECT m.`id`,m.`message`,m.`time`,u.`login` FROM `messages` m LEFT JOIN `users` u ON m.`user_id`=u.`id` WHERE m.`id`={$message_id} ORDER BY m.`time` DESC")->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>epic blog</title>
    <style type="text/css">
        body {
            width: 60%;
            margin-left: auto;
            margin-right: auto;
        }

        .left {
            float: left;
        }

        .right {
            float: right;
        }

        .message {
            margin-bottom: 20px;
        }

        textarea {
            width: 100%;
        }

    </style>
</head>
<body>
<a href="http://epic-blog/lesson%206/src/index.php"><h1>Epic blog</h1></a>
<?php if (!empty($messages)): ?>
    <?php foreach ($messages as $message): ?>
        <div class="message">
            <a href="http://epic-blog/lesson%206/src/index.php?message_id=<?= $message['id'] ?>"><h2>message № <?= $message['id'] ?></h2></a>

            <div><?= htmlspecialchars($message['message']); ?></div>
            <span class="left"><?= $message['login']; ?></span>
            <span class="right"><?= $message['time']; ?></span>
        </div>
        <br/>
    <?php endforeach ?>
<?php endif ?>
<form method="post">
    <textarea name="message" id="message" rows="10"><?= empty($message_id) ? '' : $messages[0]['message']; ?></textarea>
    <input type="submit" name="action" value="save">
</form>
</body>
</html>
