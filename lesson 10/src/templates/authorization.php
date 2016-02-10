<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>epic blog</title>
    <link rel="stylesheet" href="assets/<?= $style ?>.css">
</head>
<body>
<form action="<?= $site_url ?>?action=login" method="post">
    <input type="text" name="login" value="<?= $login ?>" title="login">
    <input type="password" name="password" title="password">
    <input type="submit" name="action" value="login">
    <input type="hidden" name="token" value="<?= $token ?>">
</form>
</body>
</html>