<?php
/**
 * global @var \PDO $connection
 */


if (empty($connection) || empty($input['login']) || empty($input['password'])) {
    return [];
}

$query = $connection->prepare("SELECT * FROM `users` WHERE `login`=:login AND `password`=:password");
$query->execute([
                   ':login' => $input['login'],
                   ':password' => md5($input['password']),
                ]);
$user = $query->fetch();
if (!empty($user)) {
    $_SESSION['user'] = $user;
    return $user;
}

?>

<form action="authorization.php" method="post">
    <input type="text" name="login" title="login">
    <input type="password" name="password" title="password">
    <input type="hidden" name="token" value="<?= $token ?>">
    <input type="submit" value="login" title="login">
</form>
