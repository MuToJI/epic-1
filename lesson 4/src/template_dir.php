<ul>
    <?php foreach ($files as $file): ?>
        <li>
            <a href="?path=<?= $file ?>">
                <?= $file ?>
            </a>
        </li>
    <?php endforeach; ?>
</ul>