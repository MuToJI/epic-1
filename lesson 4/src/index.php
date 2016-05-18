<?php

if (!empty($_REQUEST['title']) && !empty($_REQUEST['message'])) {
    file_put_contents(__DIR__ . '/../messages/' . $_REQUEST['title'], $_POST['message']);
    header('Location:http://epic-blog/lesson%204/src/index.php');
}

$files = glob(__DIR__ . '/../messages/*');

include 'template.php';