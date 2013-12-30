RPI control
------------

This version does work now but may be some bugs in the installer. 


433Mhz Sender using Pi hat.

Based on Original work from https://github.com/s7mx1/pihat


Parts List
----------



[Raspberry pi](http://www.amazon.co.uk/gp/product/B008PT4GGC/ref=as_li_ss_tl?ie=UTF8&camp=1634&creative=19450&creativeASIN=B008PT4GGC&linkCode=as2&tag=raspihel-21)

[8GB SD Card](http://www.amazon.co.uk/gp/product/B000VUVA62/ref=as_li_ss_tl?ie=UTF8&camp=1634&creative=19450&creativeASIN=B000VUVA62&linkCode=as2&tag=raspihel-21)

[Power Adaptor](http://www.amazon.co.uk/gp/product/B00AUKR4EU/ref=as_li_ss_tl?ie=UTF8&camp=1634&creative=19450&creativeASIN=B00AUKR4EU&linkCode=as2&tag=raspihel-21)

[Remote Power Sockets](http://www.amazon.co.uk/gp/product/B003XOXAVG/ref=as_li_ss_tl?ie=UTF8&camp=1634&creative=19450&creativeASIN=B003XOXAVG&linkCode=as2&tag=raspihel-21)

[433 Transmitter](http://www.amazon.co.uk/gp/product/B00EQ1U5XQ/ref=as_li_ss_tl?ie=UTF8&camp=1634&creative=19450&creativeASIN=B00EQ1U5XQ&linkCode=as2&tag=raspihel-21)

[Breadboard](http://www.amazon.co.uk/gp/product/B00520JLWG/ref=as_li_ss_tl?ie=UTF8&camp=1634&creative=19450&creativeASIN=B00520JLWG&linkCode=as2&tag=raspihel-21)

[Dupont cables](http://www.amazon.co.uk/gp/product/B00ATMHU52/ref=as_li_ss_tl?ie=UTF8&camp=1634&creative=19450&creativeASIN=B00ATMHU52&linkCode=as2&tag=raspihel-21)





Apache Setup
------------
```
apt-get install apache php5 php5-cli php5-mysql -y
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
5. Enter the URL of your /sms/textlocal.php (ensure port forward has been done)
6. Save!
7. Edit textlocal.php and where $smskey is put your inbox keyword in and ensure you add a space.




To do
---------------
1) Bug Hunt! - Ensure any issues you let me know

2) new ideas - got an idea or what to intergrate a new sms provider email me :)

For Me
--------------
Any one kind enough to throw a donation my way towards another  raspberry pi  would be welcome - txt3rob@Gmail.com

Any errors or need help email me txt3rob@gmail.com

