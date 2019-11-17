# An online IDE to develop using AMOS-2 

This is the source code to get a online IDE for AMOS-2 BASIC. 

## Install

Here is a little procedure for debian/ubuntu/mint.

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
# configure and create needed directories, given them write access to www-data 
```

You will need to download AMOS-2 into the /home/amos2/compiler directory.
You can setup another directory if you configure it into `loc.php`.

If this is not really easy to install, ask me into the GitHub issues manager. 