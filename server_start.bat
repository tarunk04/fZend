:######################################################################## 
:# File name: server_start.bat
:# Edited Last By: Mike Gleaves (ric) 
:# V 1.0 20-9-2008
:# Comment: Run multi-Apache servers on same PC. Apache 2.2.9 core
:######################################################################## 

@echo off

rem ## Save return path
pushd %~dp0

rem ## Check to see if already stopped
if NOT exist udrive\usr\local\apache2\logs\httpd.pid goto :NOTSTARTED

rem ## It exists is it running
SET /P pid=<udrive\usr\local\apache2\logs\httpd.pid
netstat -anop tcp | FIND /I " %pid%" >NUL
IF ERRORLEVEL 1 goto :NOTRUNNING
IF ERRORLEVEL 0 goto :RUNNING

:NOTRUNNING
rem ## Not shutdown using server_stop.bat hence delete file
del udrive\usr\local\apache2\logs\httpd.pid

:NOTSTARTED
rem ## Check for another server on this Apache port
netstat -anp tcp | FIND /I "0.0.0.0:8088" >NUL
IF ERRORLEVEL 1 goto NOTFOUND

echo  ::Another server is running on port 8088 cannot run fZend server

goto END

:NOTFOUND
echo  ::Port 8088 is free - OK to run server
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
(set /p dummy=%Disk%) >udrive\usr\local\apache2\logs\drive.txt <nul

rem ## Set variable paths
set apachepath=\usr\local\apache2\
set apacheit=%Disk%:%apachepath%bin\Apache_8.exe -f %apachepath%conf\httpd.conf -d %apachepath%.

rem ## Start server
%Disk%:
start %Disk%:\home\admin\program\uniserv.exe "%apacheit%" 

echo  ::The server is working on disk %Disk%:\ [http/127.0.0.1]
echo  ::To view fZend type http://localhost:8088 into a browser
goto :END

:RUNNING
echo  ::This fZend server is already running.
echo  ::Enter "stop" to stop the fZend server
:END


rem ## Return to caller
popd