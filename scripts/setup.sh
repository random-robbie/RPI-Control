#!/bin/bash
sudo apt-get update
sudo apt-get upgrade -y
sudo apt-get install wakeonlan -y
sudo echo "www-data ALL=(ALL) NOPASSWD: ALL" >> /etc/sudoers
sudo cp pihat /usr/bin/pihat
sudo chmod 777 /usr/bin/pihat
echo "setup complete"
