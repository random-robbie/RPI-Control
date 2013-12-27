RPI control
------------

This version currently does not fully work yet! 


433Mhz Sender using Pi hat.

Based on Original work from https://github.com/s7mx1/pihat

The remote sockets - http://www.amazon.co.uk/Status-Remote-Controlled-Sockets-SREMSOC3PK3/dp/B003XOXAVG/

The Transmitter - http://www.ebay.co.uk/itm/140958983913




Parts List
----------

```
1) http://www.amazon.co.uk/Raspberry-Pi-Model-Latest-VERSION/dp/B009SMWSQA
2) USB mobile phone charger and USB to micro usb b (samsung blackberry nokia) or  - http://www.amazon.co.uk/Hostey%C2%AE-Micro-Supply-Charger-Raspberry/dp/B00C1EKF5S/ref=pd_sim_ce_5
3) http://www.ebay.co.uk/itm/140958983913
4) 16GB SD card - http://www.amazon.co.uk/For-Raspberry-preloaded-operating-partitioned/dp/B008IU78EK/ref=pd_bxgy_ce_text_z
5) http://www.amazon.co.uk/Status-Remote-Controlled-Sockets-SREMSOC3PK3/dp/B003XOXAVG/ - remove control sockets
6) USB wireless adaptor - http://www.amazon.co.uk/USB-Wifi-Adapter-Raspberry-Pi/dp/B009FA2UYK/ref=pd_sim_ce_7
7 ) text local account - http://www.textlocal.com/?tlrx=162301.

```



Apache Setup
------------

apt-get install apache php5 php5-cli php5-mysql -y

Place all in to your /var/www/ directorty


```
cd /usr/bin/
Chmod 777 pihat
```

add the following line to /etc/sudoers
```
www-data ALL=(ALL) NOPASSWD: ALL
```
for WOL ensure you do 
```
apt-get install wakeonlan -y
```
Config.php
----------
Please ensure you chmod this to 755 or 777


SMS Setup
------------


Configuring for TextLocal to Post…

you need to tell text local where to POST too. Its a simple setup process:

1. Login to textlocal dashboard
2. Select ‘inboxes’
3. Select the inbox you wish to use and press ‘settings’
4. Find the heading ‘Forward incoming messages to a URL’
5. Enter the URL of your script.
6. Save!


sms.php
------------


To do
---------------
1) Make it work Fully

For Me
--------------
Any one kind enough to throw a donation my way towards another  raspberry pi  would be welcome - txt3rob@Gmail.com

Any errors or need help email me txt3rob@gmail.com

