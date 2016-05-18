<?php $path = empty($_GET['path']) ? __DIR__ : $_GET['path']; ?>
    <div>
        <a href="?path=<?= dirname($path) ?>">
            <?= dirname($path) ?>
        </a>
    </div>
<?php

if (is_dir($path)) {
    $files = glob("{$path}/*");
    include "template_dir.php";
} else {
    include "template_file.php";
}
