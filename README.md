RPI control
------------

433Mhz Sender using Pi hat.

Based on Original work from https://github.com/s7mx1/pihat

Original Image i have used for this is from :

http://sourceforge.net/projects/siriproxyrpi/  - Raspbian with siriproxy

This will allow you to control set devices in the house using your status remotes and Siri.

The remote sockets - http://www.amazon.co.uk/Status-Remote-Controlled-Sockets-SREMSOC3PK3/dp/B003XOXAVG/

The Transmitter - http://www.ebay.co.uk/itm/140958983913

Apache Setup
------------

apt-get install apache php5 php5-cli php5-mysql -y

Place all /usr/bin in to your /usr/bin dir
Place all /var/www/ in to your /var/www/ directorty

Ensure all the files have been chmod 777 in the usr/bin/ folder

cd /usr/bin/
chmod 777 *.sh
Chmod 777 pihat


add the following line to /etc/sudoers
www-data ALL=(ALL) NOPASSWD: ALL

for WOL ensure you do apt-get install wakeonlan -y

Config.php
----------

use this file to configure all the variables.

this will set the buttons and the sms commands required.

SMS Setup
------------

Configuring TextLocal to Post…

you need to tell text local where to POST too. Its a simple setup process:

1. Login to textlocal dashboard
2. Select ‘inboxes’
3. Select the inbox you wish to use and press ‘settings’
4. Find the heading ‘Forward incoming messages to a URL’
5. Enter the URL of your script.
6. Save!


insms.php
------------
I found it better to have the database on an external server.
But do not forget to fill in the username password database details.

for the keyword check the 5 digits in your text local account for the 60777 number 
and ensure this is put in to the $keyword section in config.php.

Import the database.sql to set the database up.

To do
---------------

1) Have it so you can disable and enable webcams via config file

2) Better theme??

3) Upload Siri Proxy Example I used.

4) Twitter commnads

For Me
--------------
Any one kind enough to throw a donation my way towards a raspberry pi cam would be welcome - txt3rob@Gmail.com

Any errors or need help email me or PM on the raspberry pi forums.

