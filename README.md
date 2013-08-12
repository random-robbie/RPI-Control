433Mhz Sender using Pi hat.


Based on Original work from https://github.com/s7mx1/pihat

Original Image i have used for this is from :

http://sourceforge.net/projects/siriproxyrpi/  - Raspbian with siriproxy

This will allow you to control set devices in the house using your status remotes and Siri.

Place all /usr/bin in to your /usr/bin dir
Place all /var/www/ in to your /var/www/ directorty

add the following line to /etc/sudoers
www-data ALL=(ALL) NOPASSWD: ALL

for WOL ensure you do apt-get install wakeonlan -y

any one kind enough to throw a donation my way towards a raspberry pi cam would be welcome - txt3rob@Gmail.com

Any error or need help email me or PM on the raspberry pi forums.

