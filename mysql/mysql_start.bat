:######################################################################## 
:# File name: mysql_start.bat
:# Created By: The Uniform Server Development Team
:# Edited Last By: Mike Gleaves (ric) 
:# V 1.0 8-8-2008
:# Comment: Redesigned to allow multi-MySQL servers
:# on same PC. MySQL 4.1.22-community-nt
:######################################################################## 

@echo off

rem ## Save return path
pushd %~dp0

rem ## Check to see if already stopped
if NOT exist udrive\data\mysql_mini.pid goto :NOTSTARTED

rem ## It exists is it running
SET /P pid=<udrive\data\mysql_mini.pid
netstat -anop tcp | FIND /I " %pid%" >NUL
IF ERRORLEVEL 1 goto :NOTRUNNING
IF ERRORLEVEL 0 goto :RUNNING 

:NOTRUNNING
rem ## Not shutdown using mysql_stop.bat hence delete file
del udrive\data\mysql_mini.pid 

:NOTSTARTED
rem ## Check for another server on this MySQL port
netstat -anp tcp | FIND /I "0.0.0.0:3313" >NUL
IF ERRORLEVEL 1 goto NOTFOUND
goto END

:NOTFOUND
rem ## Find first free drive letter
for %%a in (C D E F G H I J K L M N O P Q R S T U V W X Y Z) do CD %%a: 1>> nul 2>&1 & if errorlevel 1 set freedrive=%%a

rem ## Use batch file drive parameter if included else use freedrive
set Disk=%1
if "%Disk%"=="" set Disk=%freedrive%

rem ## To force a drive letter, remove "rem" and change drive leter
rem set Disk=w

rem ## Having decided which drive letter to use create the disk
subst %Disk%: "udrive"

rem ## Save drive letter to file. Used by stop bat 
(set /p dummy=%Disk%) >udrive\data\drive.txt <nul

rem ## Start server
%Disk%:
start \bin\mysqld-opt.exe --defaults-file=/bin/my.cnf

rem ## Info to user

goto :END

:RUNNING

:END


rem ## Return to caller
popd