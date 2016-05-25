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
            <a href="http://epic-blog/lesson%206/src/index.php?action=delete&message_id=<?= $message['id'] ?>"><h3>kill</h3></a>
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