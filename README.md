## Как развернуть проект

`git clone https://github.com/axelmason/testtodos.git`

В папке проекта:
1. `composer update`
2.  - Linux: `cp .env.example .env` 
	- Windows: `copy .env.example.env`
3. `php artisan key:generate`
4. `php artisan migrate:fresh`
