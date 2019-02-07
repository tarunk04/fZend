#include <windows.h>
#include <stdio.h>
#include <iostream>
#include <conio.h>
#include <fstream>
#include <stdlib.h>
#include <string>

#include "resource.h"


using namespace std;
bool is_file_exist(const char *fileName)
{
    std::ifstream infile(fileName);
    return infile.good();
}

int main()
{
    STARTUPINFO si;
    PROCESS_INFORMATION pi;

    ZeroMemory( &si, sizeof(si) );
    si.cb = sizeof(si);
    ZeroMemory( &pi, sizeof(pi) );
    string line;
    ifstream IPFile;
    string net="";
    int offset;
    char* searchip = "IPv4 Address. . . . . . . . . . . :";      // search pattern
    char* searchwifi = "Wireless LAN adapter Wi-Fi:";
    char* searchlan = "Ethernet adapter";
    string error="";


    cout<<"**********************************Welcome To fZend*********************************************\n";
    cout<<"*                    **MAKE SURE THAT THAT YOU FIREWALL IS OFF**                              *\n";
    cout<<"*                                                                                             *\n";
    cout<<"*  Please read instructions (Read ME.txt) to carefully before started.                        *\n";
    cout<<"*  This application allows you to send you files upto 2GB either on Wifi or LAN               *\n";
    cout<<"*  Enter fZend command \"start\" to start the server and \"stop\" to End the server.              *\n";
    cout<<"*  Enter fZend command \"show-ip\" to get ip address to connect to Device.                      *\n";
    cout<<"*  Enter fZend command \"exit\" to exit the Program.                                            *\n";
    cout<<"*                                                                                             *\n";
    cout<<"***********************************************************************************************\n\n\n\n";

    cout<<"\nfZend--> ";
    string num;
    cin>>num;

    while(num!= "exit"){
    if (num == "start" ){
        if(is_file_exist("server_start.bat" ) && is_file_exist("mysql\\mysql_start.bat" )){
            system("server_start.bat");
            system("mysql\\mysql_start.bat");
            WaitForSingleObject( pi.hProcess, INFINITE );
            CloseHandle( pi.hProcess );
            CloseHandle( pi.hThread );

            system("ipconfig > ip.txt");
            IPFile.open ("ip.txt");
            if(IPFile.is_open())
            {   cout << " ::To connect device enter in your browser\n";
               while(!IPFile.eof())
               {
               getline(IPFile,line);
               if ((offset = line.find(searchwifi, 0)) != string::npos)
               {
                   net="WIFI";
               }
               else if ((offset = line.find(searchlan, 0)) != string::npos)
               {
                   net="LAN ";
               }
               if ((offset = line.find(searchip, 0)) != string::npos)
               {
               line.erase(0,39);
               cout << " ::To connect Device over "<< net<<" :   http://"<<line<<":8088\n";
               }
            }
            IPFile.close();
            }
               string URL = "http://localhost:8088";
               cout<<" Opening in browser. Please wait....";
               Sleep(2000);
               ShellExecuteA(NULL, "open", URL.c_str(), NULL, NULL, SW_SHOWNORMAL);
        }
        else{
            error = " ::ERROR : File missing server_start.bat";
            cout<<error;
        }
    }
    else if (num == "stop"){
        if(is_file_exist("server_stop.bat") && is_file_exist("mysql\\mysql_stop.bat")){
            system("server_stop.bat");
            system("mysql\\mysql_stop.bat");
        }
        else{
        error = " ::ERROR : File missing server_stop.bat";
        cout<<error;
        }
    }
    else if (num == "show-ip"){
        system("ipconfig > ip.txt");
        IPFile.open ("ip.txt");
        if(IPFile.is_open())
        {  cout << " ::To connect device enter in your browser\n";
           while(!IPFile.eof())
           {
           getline(IPFile,line);
           if ((offset = line.find(searchwifi, 0)) != string::npos)
           {
               net="WIFI";
           }
           else if ((offset = line.find(searchlan, 0)) != string::npos)
           {
               net="LAN ";
           }
           if ((offset = line.find(searchip, 0)) != string::npos)
           {
           line.erase(0,39);
           cout << " ::To connect Device over "<< net<<" :   http://"<<line<<":8088\n" ;

           }
        }
        IPFile.close();
        }
    }
    else {
        cout<<" ::ERROR : Not Found As Internal Command";
    }
    cout<<"\nfZend--> ";
    cin>>num;
    }
    return 0;
}
