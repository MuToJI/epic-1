<?php

error_reporting(E_ALL);

$connection = new \PDO("mysql:host=localhost;dbname=blog", 'root', 'vagrant', [
   \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
   \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
   \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
]);

if (!empty($_GET['message'])) {
    $connection->query("INSERT INTO `messages` SET `message`='{$_GET['message']}', `time`=NOW(), `user_id`=0");
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
<a href="http://epic-blog/lesson%205/src/index.php"><h1>Epic blog</h1></a>
<?php if (!empty($messages)): ?>
    <?php foreach ($messages as $message): ?>
        <div class="message">
            <div><?= $message['message']; ?></div>
            <span class="left"><?= $message['login']; ?></span>
            <span class="right"><?= $message['time']; ?></span>
        </div>
        <br/>
    <?php endforeach ?>
<?php endif ?>
</body>
</html>
