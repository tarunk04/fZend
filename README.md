fZend
===================

fZend is a free product and is the created by Accidental Engineer.
To start transfer of files run the fZend.exe as Aministrator and type `fZend--> start` to create server.
Server will be hosted at http://localhost:8088, you can check it by opening the 
address in your web browser.

-------------------
To get started:
-------------------
**MAKE SURE THAT YOUR FIREWALL IS OFF**, 
Then connect your device with other device on network (either WIFI or LAN).
Check out your IP address of your device on which the server is running. 
Assume that IP address is 192.168.XXX.XXX then type http://192.168.XXX.XXX:8088 in the
browser of the other device from which you want to send the file.

------------------------
Shutting down the server
------------------------
To shut down the server run the fZend.exe as Administrator and type `fZend--> stop`.

--------------------------
Change server default port
--------------------------
Open file: httpd.conf\n
Located in folder: `\mini_server_8\udrive\usr\local\apache2\conf`\n
`Locate the lines:\n
  Listen 8088\n 
  ServerName localhost:8088\n
Change to:\n
  Listen 8080 \n
  ServerName localhost:8080\n`
This moves the server to the standard secondary web server port\n
Note: Type http://localhost:8080 into a browser to view the site.\n

If port already in use try any value above 2000\n


-----------------------------------------------------------
Copyright 2018-2019 Accidental Engineer
All rights reserved.

The authors were trying to make the best product so they 
cannot be held responsible for any type of damage or 
problems caused by using this or another software.
