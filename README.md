fZend
===================
![fZend](icon.png)<br><br>
[![license](https://img.shields.io/github/license/mashape/apistatus.svg?maxAge=2592000)](https://github.com/Accidental-Engineer/fZend/blob/master/LICENSE)<br>
fZend is a open source product and is the created by Accidental Engineer.fZend is a windows application for file sharing over WiFi or Ethernet. It provides a web-based interface for authorization and file selection. fZend comes with a solution of  plug and play portable server based file sharing application, to ease the file transfer from PC to any device vice versa. It is easy to setup also support sharing of large file upto 2GB.


To get started:
-------------------
* Clone this repository:  
```console
git clone https://github.com/tarunk04/fZend.git
```
or click `Download ZIP` in right panel of repository and extract it.
* Run the fZend.exe as *Aministrator*.
* Run fZend command to create server : 
```
fZend--> start
```
* Server will be hosted at `http://localhost:8088`, you can check it by opening the 
address in your web browser or the browser will autometically be opened by fZend application.

**MAKE SURE THAT YOUR FIREWALL IS OFF**

* Then connect your device with other device on network (either WIFI or LAN).
* Check out your IP address of your device on which the server is running. You can also check `IP ADDRESS` of your device using fZend command:
```
fZend--> show-ip
```

* Assume that IP address is `192.168.XXX.XXX` then type `http://192.168.XXX.XXX:8088` in the
browser of the other device from which you want to send the file ***make sure that device is connected to the same network***.

Sharing a file
------------------------

* ##### Send a file from `Server` to `Client` :
  * On `server` side open `http://localhost:8088` in your browser.<br><br>
  <img src="https://github.com/Accidental-Engineer/fZend/blob/master/screenshot/sh1.png"  width=400><br><br>
  * Choose single or multiple files.<br><br>
  <img src="https://github.com/Accidental-Engineer/fZend/blob/master/screenshot/sh_1.png"  width=400><br><br>
  Tick `checkbox` if you want to zip the files before sending.
  * On `client` side open `http://192.168.XXX.XXX:8088` in the browser.<br><br>
  <img src="https://github.com/Accidental-Engineer/fZend/blob/master/screenshot/sh3.png"  width=400><br><br>
  ##### Note: For the first time a password will be asked, deflault password is `000000`. 
  * Click `Receive`.<br><br>
  <img src="https://github.com/Accidental-Engineer/fZend/blob/master/screenshot/sh2.png"  width=400><br><br>
  * Downloading will autometically start. 
* ##### Send a file from `Client` to `Server` :
  * On `client` side open `http://192.168.XXX.XXX:8088` in the browser.
  * Select `Send` option and then select single or multiple files.<br><br>
  <img src="https://github.com/Accidental-Engineer/fZend/blob/master/screenshot/sh3.png"  width=400><br><br>
  * On `server` side open `http://localhost:8088` in your browser and wait for incoming request.<br><br>
  <img src="https://github.com/Accidental-Engineer/fZend/blob/master/screenshot/sh4.png"  width=400><br><br>
  * Click on `Accept` to receive files.
  
Shutting down the server
------------------------
To shut down the server run the fZend.exe as Administrator and run fZend command:
```
fZend--> stop
```

Change server default port
--------------------------
Open file `httpd.conf` located in folder : `\udrive\usr\local\apache2\conf`<br>
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
This moves the server to the standard secondary web server port<br>
If port already in use try any value above 2000


-----------------------------------------------------------

[![BuyMeCoffe](https://cdn-images-1.medium.com/max/800/1*Dpw8-hNGI2fDmosV4E8DVQ.png)](https://www.buymeacoffee.com/tarunkumar)

### Authors
Accidental Engineer

#### Authors' Note:<br>
The authors were trying to make the best product so they 
cannot be held responsible for any type of damage or 
problems caused by using this or another software.
