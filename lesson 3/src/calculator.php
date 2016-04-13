<?php

const EXIT_COMMAND = 'exit';

$operations = [
    '+' => function ($a, $b) {
        return $a + $b;
    },
    '-' => function ($a, $b) {
        return $a - $b;
    },
    '*' => function ($a, $b) {
        return $a * $b;
    },
    '/' => function ($a, $b) {
        return $b == 0 ? 'Operation not permitted, b==0' : $a / $b;
    },
];

while (true) {
    $a = input('First operand: ', 'is_numeric');
    if ($a === false) {
        return;
    }
    $b = input('Second operand: ', 'is_numeric');
    if ($b === false) {
        return;
    }
    $operation = input('Operation: ', function ($value) use ($operations) {
        return !empty($operations[$value]);
    });
    $func = $operations[$operation];
    echo $func($a, $b) . PHP_EOL;
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
    is_callable($validator);
    while (!$validator($value)) {
        $value = readline($prompt);
        if ($value === EXIT_COMMAND) {
            return false;
        }
    }
    return $value;
}