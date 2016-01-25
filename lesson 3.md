#Немного про теорию БД и про разные СУБД

*База данных* -  фактически способ организации и хранения данных для их последующей обработки (поиск, выборка и т.д.). <br/>
*СУБД* -  это набор программ для управления БД.<br/>

##Реляционные (табличные) и нереляционные БД.

Рассмотрим сначала реляционные БД на примере MySQL.<br/>
В реляционных БД данные состоят из таблиц. Каждая таблица состоит из столбцов (поля, атрибуты) и строк (записи, кортежи). 
В таблице должно быть как минимум одно поле. Названия полей уникальны в пределах таблицы и должны иметь определенный тип.<br/>
(типы: int, bool, date, datetime, varchar, text, double)<br/>

Пример таблицы на основе гостевой доски с коментариями (пользователь, сообщение, дата)<br/>
**users:**
```
id	name	message	data
```
<br/>
Пример денормализации таблицы (выносим сообщения из таблицы users в таблицу messages с ключом пользователя)<br/>
**users:**
```
id	name
```
<br/>
messages:
```
id	user_id	message	data
```
<br/>

Добавляем таблицу с пользовательскими аватарками.<br/>
avatars:
```
id	user_id	picture_uri
```

##Что такое SQL
*structured query language* - язык структурированных запросов, служит для поиска и управления данными в реляционных (и некоторых не реляционных) БД. Прародителем стал язык от IBM SEQUEL, первый стандарт языка вышел в 1986 г.

##Что нужно знать для работы с БД с помощью SQL

Каждая команда SQL это всегда операция на таблицей или набором таблиц в БД.<br/>
Набор стандартных простых команд:

* [создание в базе данных новой таблицы](http://www.w3schools.com/sql/sql_create_table.asp)  
```
CREATE TABLE table_name (column_name1 data_type(size) [<options>], …, column_nameN data_type(size) [<options>]);
```
* [добавление в таблицу новых записей](http://www.mysql.ru/docs/man/INSERT_SELECT.html)<br/>
```
    INSERT INTO table_name
    SET col_name=expression, col_name=expression, … ;
    или
    INSERT INTO table_name (field1, field2, ...) VALUES (value1, value2, ...);
```
* [изменение записей](http://www.mysql.ru/docs/man/UPDATE.html)<br/>
```
    UPDATE table_name SET field1=value1, field2=value2, … [WHERE … ];
    REPLACE [INTO] table_name SET field1=value1, ...
```
* [удаление записей](http://www.mysql.ru/docs/man/DELETE.html)<br/>
```
    DELETE FROM table_name WHERE … ;
```
* [выборка записей из одной или нескольких таблиц (в соответствии с заданным условием)](http://www.mysql.ru/docs/man/SELECT.html)<br/>
```
    SELECT field1, field2, … FROM table_name WHERE … ;
```
* [изменение структур таблиц](http://www.mysql.ru/docs/man/ALTER_TABLE.html)<br/>
```
    ALTER TABLE table_name [<options>];
```

#Упоминаем про функции mysql_ и объясняем, почему их не надо использовать
Фактически это функции для работы с БД mysql которыми пользовались из глубин веков, но которые уже с версии 5.5 помечаются как устаревшие. В версии 7 удалены, потому пользоваться ими не стоит.

#PDO - наше все. Объясняем, почему это хорошо, примеры синтаксиса, простая демонстрация

*PDO (php data object)* обеспечивает абстракцию (доступа к данным). Это значит, что вне зависимости от того, какая конкретная база данных используется, 
вы можете пользоваться одними и теми функциями для выполнения запросов и выборки данных. 
Стоит учесть что сами запросы все равно придется переписывать под каждую специфичную БД.<br/>

Подключение к БД<br/>

```
$config = [
  'host' => 'localhost',
  'port' => '',
  'user' => 'some',
  'password' => '',
];

$mysql = new \PDO("mysql:host={$config['host']}" . (empty($config['port']) ? '' : ";port:{$config['port']}"), $config['user'], $config['password'], [
  \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
  \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
]);
empty($config['dbname']) ?: $mysql->query("USE `{$config['dbname']}`");
empty($config['encoding']) ?: $mysql->query("SET NAMES '{$config['encoding']}'");
```

4. SQLite
5. Транзакции в БД

