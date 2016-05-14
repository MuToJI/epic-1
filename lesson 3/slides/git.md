Инициирование git репозитария
git init

Работа с файлами в репозитарии
git add <file.name> - добавление файла
git mv <file.name> <other.name> - перемещение
git rm <file.name> - удаление

Коммит в локальный репозитарий
git commit -m <"message">

Проверка статуса
git status - текущий статус проекта
git log - лог комитов

Работа с удаленными репозитариями
git remote -v - список текущих удаленных репозитариев
git remote add origin <url> - добавление нового
git fetch [<remote-name>] - выгрузка изменений из удаленного репозитария
git push origin [<branch-name>] - загрузка изменений в репозитарий
git remote show origin - просмотр удаленного репозитария
git remote rm <remote-name>
git remote mv <remote-name>
git pull - git fetch | git merge

Ветвление
git branch <branch-name> - создание ветки
git checkout <branch-name> - переключение на ветку
git checkout -b <branch-name> - создание ветки и переключение на нее

Слияние
git merge <branch-name> - слияние текущей ветки с branch-name