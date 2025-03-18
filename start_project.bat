@echo off
echo Démarrage du projet...

REM Ouvre VS Code
start code .

REM Ouvre pgAdmin 4
start "" "C:\Program Files\PostgreSQL\17\pgAdmin 4\runtime\pgAdmin4.exe"

REM Ouvre le serveur Laravel
start cmd /k "php artisan serve"

REM Lance npm run dev
start cmd /k "npm run dev"

REM Ouvre le projet dans le navigateur
start "" "http://127.0.0.1:8000"

echo Projet lancé !
exit
