<?php

const POST_DIR = 'posts';

$file = fopen(date('Y-m-d H') . '.post', 'w+');
while (true) {
    $text = readline();
    if ($text === ':exit') {
        break;
    }
    fputs($file, $text);
}
fclose($file);