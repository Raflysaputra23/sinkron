@echo off
set DB_USER=%~1
set DB_PASS=%~2
set DB_HOST=%~3
set DB_NAME=%~4
set OUT_FILE=%~5

set LOCAL_EXE=%~dp0tools\mysqldump.exe
set LOCAL_BACKUP_EXE=%~dp0tools\mysqlbackup.exe
set EXE_TO_USE=mysqldump

if exist "%LOCAL_EXE%" (
    set EXE_TO_USE="%LOCAL_EXE%"
) else if exist "%LOCAL_BACKUP_EXE%" (
    set EXE_TO_USE="%LOCAL_BACKUP_EXE%"
)

if "%DB_PASS%"=="" (
    %EXE_TO_USE% --user=%DB_USER% --host=%DB_HOST% %DB_NAME% > "%OUT_FILE%"
) else (
    %EXE_TO_USE% --user=%DB_USER% --password=%DB_PASS% --host=%DB_HOST% %DB_NAME% > "%OUT_FILE%"
)
