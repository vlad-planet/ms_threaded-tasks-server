microservices

## Реализация многопоточного сервера на PHP

Требования к Запуску Теста:
- Cборка PHP, скомпилированная с флагом 'thread safety' для Windows http://windows.php.net/download/

Из архива копируем:
- файл php_pthreads.dll в директорию C:\php\ext 
- файл pthreadVC2.dll в директории C:\php и C:\Windows\System32

В php.ini и добавляем строку: extension=php_pthreads.dll

Запуск теста:
1. Перейдите в корневой каталог<br>
2. Запустить тест для выполнения задачь в многопаточности: php index.php
3. Запустить тест для запуска Сокетов в многопоточности: server.php
