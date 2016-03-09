<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>epic blog</title>
    <link rel="stylesheet" href="assets/<?= $style ?>.css">
</head>
<body>
<a href="<?= $site_url ?>"><h1>Epic blog</h1></a>
<form action="<?= $site_url ?>?action=profile" method="post">
    <input type="radio" name="style" value="0" <?= $style == 'main' ? 'checked' : '' ?>>default<Br>
    <input type="radio" name="style" value="1" <?= $style == 'black' ? 'checked' : '' ?>>black<Br>
    <input type="radio" name="style" value="2" <?= $style == 'yellow' ? 'checked' : '' ?>>yellow<Br>
    <input type="submit" name="action" value="profile">
</form>
</body>
</html>