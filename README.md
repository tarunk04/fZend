fZend
===================
fZend is a free product and is the created by Accidental Engineer.


To get started:
-------------------
*Run the fZend.exe as Aministrator.
*Run fZend command to create server : 
```
fZend--> start
```
*Server will be hosted at `http://localhost:8088`, you can check it by opening the 
address in your web browser or the browser will autometically be opened by fZend application.

**MAKE SURE THAT YOUR FIREWALL IS OFF**

*Then connect your device with other device on network (either WIFI or LAN).
*Check out your IP address of your device on which the server is running. You can also check `IP ADDRESS` of your device using fZend command:
```
fZend--> start
```

*Assume that IP address is `192.168.XXX.XXX` then type `http://192.168.XXX.XXX:8088` in the
browser of the other device from which you want to send the file ***make sure that device is connected to the same network***.


Shutting down the server
------------------------
To shut down the server run the fZend.exe as Administrator and run fZend command:
```
fZend--> stop
```


Change server default port
--------------------------
Open file: `httpd.conf`

Located in folder: `\udrive\usr\local\apache2\conf`

Locate the lines:
```
  Listen 8088
  ServerName localhost:8088
```
Change to:
```
  Listen 8080
  ServerName localhost:8080
```

This moves the server to the standard secondary web server port

(Note: To open fZend type `http://localhost:8080` into a browser.)

If port already in use try any value above 2000


-----------------------------------------------------------
Copyright 2018-2019 Accidental Engineer
All rights reserved.

The authors were trying to make the best product so they 
cannot be held responsible for any type of damage or 
problems caused by using this or another software.
