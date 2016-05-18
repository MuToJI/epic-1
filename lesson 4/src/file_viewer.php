<?php $path = empty($_GET['path']) ? __DIR__ : $_GET['path']; ?>
<div><a href="file_viewer.php?path=<?= dirname($path) ?>"><?= dirname($path) ?></a></div>
<?php if (is_dir($path)):
    $files = glob("{$path}/*"); ?>
    <ul>
        <?php foreach ($files as $file): ?>
            <li><a href="file_viewer.php?path=<?= $file ?>"><?= $file ?></a></li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <pre>
    <?= htmlentities(file_get_contents($path)) ?>
    </pre>
<?php endif ?>
