<?php

const EXIT_COMMAND = 'exit';

while (true) {
    $a = input('First operand: ', 'is_numeric');
    if ($a === false) {
        return;
    }
    $b = input('Second operand: ', 'is_numeric');
    if ($b === false) {
        return;
    }
    $operation = input('Operation: ', function ($value) {
        return $value == '+' || $value == '-' || $value == '*' || $value == '/';
    });
    $result = 0;
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
            $result = (int)$b === 0 ? 'undefined, division by zero' : $a / $b;
            break;
    }
    echo $result . PHP_EOL;
}
//=======================================================================
/**
 * @param string $prompt
 * @param callable $validator
 * @return bool|string
 */
function input($prompt, $validator)
{
    $value = '';
    while (!$validator($value)) {
        $value = readline($prompt);
        if ($value === EXIT_COMMAND) {
            return false;
        }
    }
    return $value;
}