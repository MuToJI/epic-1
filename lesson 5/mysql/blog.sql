# создаем базу
CREATE DATABASE `blog`
  COLLATE utf8_general_ci;

USE `blog`;

# таблица пользователей
CREATE TABLE `users` (
  `id`    INT AUTO_INCREMENT PRIMARY KEY,
  `login` VARCHAR(255) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL
);

# таблица сообщений
CREATE TABLE `messages` (
  `id`      INT AUTO_INCREMENT PRIMARY KEY,
  `title`   VARCHAR(100),
  `message` TEXT,
  `time`    DATETIME
);

RENAME TABLE `some` TO `other`;

ALTER TABLE `messages` DROP COLUMN `user_id`;
ALTER TABLE `messages` ADD COLUMN `title` VARCHAR(100);

UPDATE `messages` SET `user_id`=1 WHERE `id`=1;
UPDATE `messages` SET `user_id`=2 WHERE `id`=3;
UPDATE `messages` SET `user_id`=3 WHERE `id`=2;

UPDATE `users` SET `password`=MD5(`password`);

INSERT INTO `users`
SET `id` = 0, `password` = MD5('admin');

INSERT INTO `messages`
SET
  `title`   = 'легкая наркомания',
  `message` = 'В одном лесу жил белый-белый зайчик. Он был не только трусливым, как все зайчики, но и добрым-добрым. Он никогда никого не обижал, даже тех, кто был меньше и слабее. Зато его любой мог обидеть. И волк, и лиса, и филин... Даже некоторые другие зайцы. А все из-за его доброты. Даже те, кто были меньше зайчика, обижали его',
  `time`    = NOW() - INTERVAL 10 MINUTE;

INSERT INTO `messages` (`message`, `title`, `time`) VALUES
  (
    'В одном лесу жил белый-белый зайчик. Он был не только трусливым, как все зайчики, но и добрым-добрым. Он никогда никого не обижал, даже тех, кто был меньше и слабее. Зато его любой мог обидеть. И волк, и лиса, и филин... Даже некоторые другие зайцы. А все из-за его доброты. Даже те, кто были меньше зайчика, обижали его',
    'зачик', NOW()),
  (
    'Уже давно в его шкурке поселились злые вошки, и они все время кусали бедного зайку, принося ему постоянные страдания. А он был таким добрым, что даже не мылся, чтобы не смыть вошек, боясь, что они погибнут. Жил он так какое-то время, все время от боли мучаясь',
    'вошки', NOW()),
  (
    'Так долго терпел, что вскоре сами вошки не вытерпели и стали спрашивать своего хозяина: «Как же так, мы на тебе живем, да еще вместо благодарности тебя же и едим, кусаем больно, никакой жизни тебе от нас нет, а ты не то что злишься на нас, а наоборот, любишь и заботишься. Даже если кто-то из нас, крови твоей напившись, с тебя свалится, ты его поднимешь и обратно на шкурку посадишь, чтобы он не погиб... Откуда в тебе столько добра?»',
    'страшная правда', NOW());

SELECT
  `temp`.`id`,
  `temp`.`time`
FROM
  (SELECT *
   FROM `messages`) `temp`;

SELECT * FROM `messages`
WHERE `id`=0 AND `title` LIKE '%нарк%'
ORDER BY `time` DESC
LIMIT 1,10;

SELECT * FROM `messages` `m`
  LEFT JOIN `users` `u` ON `m`.`user_id`=`u`.`id`;

DELETE FROM `messages` WHERE `id`=3;

TRUNCATE `messages`;

DROP TABLE `messages`;

DROP DATABASE `blog`;