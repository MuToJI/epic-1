<?php

error_reporting(E_ALL);

$connection = new \PDO("mysql:host=localhost;dbname=blog", 'root', 'vagrant', [
   \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
   \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
   \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
]);

if (!empty($_GET['message'])) {
    $query = $connection->prepare("INSERT INTO `messages` SET `message`=:message, `time`=NOW(), `user_id`=0");
    $query->execute([':message' => $_GET['message']]);
}

$messages = $connection->query('SELECT m.`message`,m.`time`,u.`login` FROM `messages` m LEFT JOIN `users` u ON m.`user_id`=u.`id` ORDER BY m.`time` DESC')->fetchAll();

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

    </style>
</head>
<body>
<h1>Epic blog</h1>
<?php if (!empty($messages)): ?>
    <?php foreach ($messages as $message): ?>
        <div class="message">
            <div><?= htmlspecialchars($message['message']); ?></div>
            <span class="left"><?= $message['login']; ?></span>
            <span class="right"><?= $message['time']; ?></span>
        </div>
        <br/>
    <?php endforeach ?>
<?php endif ?>
</body>
</html>
