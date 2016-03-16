<?php

$a = (int)readline();
$operation = readline();
$b = (int)readline();
$result = null;

switch ($operation) {
    case '+':
        $result = $a + $b;
        break;
    case '-':
        $result = $a - $b;
        break;
    case '*':
        $result = $a * $b;
        break;
    case '/':
        $result = $a / $b;
        break;
}

echo $result . PHP_EOL;