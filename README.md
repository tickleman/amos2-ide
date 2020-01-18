# An online IDE to develop using AMOS-2 

This is the source code to get a online IDE for AMOS-2 BASIC. 

## Install

Here is a little procedure for debian / ubuntu / mint.

```bash
# pre-requisites
apt install apache2 git libapache2-mod-php mysql-server php php-cli php-curl php-gd php-json php-mailparse php-mbstring php-mysql php-opcache php-ssh2 php-yaml php-zip
# Apply configuration tips on apache2 and mysql you will found at https://itrocks.org/wiki/creer-une-application

cd /var/www/html
mkdir amos2-ide
git clone https://github.com/tickleman/amos2-ide
cd amos2-ide
php composer.phar update
mv loc.example.php loc.php
mv pwd.example.php pwd.php
# open and configure loc.php and pwd.php
# configure and create needed directories, give them write access to www-data 
```

- You will need to download AMOS-2 into the /home/amos2/compiler/0.9.2.6 directory.
- Multiple version can be stored here : one version per directory.
- Only versions with amosc-linux-x64 executable will work. Windows executable need more
- You can setup another directory if you configure it into `loc.php`.
- If this is not really easy to install, ask me into the GitHub issues manager. 

## Run the win32 / win64 compiler

If you do not have the linux executable for the AOZ compiler, you can try to make the win32 / win64
(depending on your version of debian / wine) using wine.

Install wine 32+64, and configure it for win7 using winetricks :

```bash
dpkg --add-architecture i386 && apt update && apt install wine wine32
mkdir /var/www/.local
mkdir /var/www/.wine
chown www-data.www-data /var/www/.local
chown www-data.www-data /var/www/.wine
wget -O /usr/bin/wintricks https://raw.githubusercontent.com/Winetricks/winetricks/master/src/winetricks
chmod ugo+x /usr/bin/wintricks
sudo -uwww-data winetricks win7
```

Create a script named **aoz** into the folder of your compiler version.
Here is an example for 32 bits executable.
If it does not work, you may try with the 64 bits executable. 

```bash
#!/bin/bash
wine ./aoz-x86.exe $1 &>$1/.output
mv $1/.output $1/output
```

Create a script named **aozscreen** into the folder of your compiler version.

```bash
#!/bin/bash
screen -dmS aoz ./aoz $1
```

Finally, the **winecompile** present in this project must run on your server, on an infinite loop :

```bash
cd /var/www/html/
screen -dmS winecompile sudo -uwww-data ./winecompile
```

Don't forget to make all these scripts executables and prepare in/out API folders :

```bash
mkdir /home/amos2/compiler/in
mkdir /home/amos2/compiler/out
chmod u+x /home/amos2/compiler/0.9.2.6/aoz
chmod u+x /home/amos2/compiler/0.9.2.6/aozscreen
chmod u+x /var/www/html/winecompile
chown www-data.www-data -R /home/amos2/compiler
```

How will this work :

- The IDE automatically detects if the compiler version has a linux or win32/win64 executable
- In case of a linux executable : he runs it, without using these scripts 
- If Windows : it creates a "flag file" into compiler/in
- winecompile looks at compiler/in folder 10 times per second
- when a flag file is found, it gets the version number and application path to compile
- then it runs aozscreen
- aozscreen launches aoz
- aoz launches the compiler using wine
- the compilation output is stored into a file name output into the path to compile
- the IDE waits for the output file, and analyzes it to know if the compilation worked or not

It is complicated a lot, yes, but I had to try many tricks before making it work.
Running directly the Windows compiler using wine from a php script crashes the execution of the compiler.
I had to create a totally independent execution context using screen, and to redirect outputs. 
'hope this will be simplified one day.
