:#######################################################################
:# File name: server_stop.bat
:# Edited Last By: Mike Gleaves (ric) 
:# V 1.0 20-9-2008
:# Comment: Run multi-Apache servers on same PC. Apache 2.2.9 core
:######################################################################## 

@echo off

rem ## Save return path
pushd %~dp0

rem ## Check to see if already stopped
if NOT exist udrive\usr\local\apache2\logs\httpd.pid goto :ALREADYKILLED

rem ## It exists is it running
SET /P pid=<udrive\usr\local\apache2\logs\httpd.pid
netstat -anop tcp | FIND /I " %pid%" >NUL
IF ERRORLEVEL 1 goto :NOTRUNNING
IF ERRORLEVEL 0 goto :RUNNING

:NOTRUNNING
rem ## Not shutdown using server_stop.bat hence delete file
del udrive\usr\local\apache2\logs\httpd.pid
goto :ALREADYKILLED

rem ## It is running hence shut server down
:RUNNING
rem ## Get drive letter
SET /P Disk=<udrive\usr\local\apache2\logs\drive.txt

rem ## Kill Apache process and all it's sub-processes
SET killstring= -t "%pid%"
udrive\home\admin\program\pskill.exe  Apache_8.exe c
echo  ::fZend Stopped

rem ## Remove pid file
del udrive\usr\local\apache2\logs\httpd.pid

rem ## Remove disk file
del udrive\usr\local\apache2\logs\drive.txt

rem ## Kill drive
subst %Disk%: /D

goto :END

:ALREADYKILLED
echo  ::fZend already stopped
:END


rem ## Return to caller
popd