#!/bin/bash

# Define variable
ROOT_DIR=$(pwd)
VHOST='magento1.conf'
DOMAIN='magento1.local'

NGINX=0

ENDC=`tput setaf 7`
RED=`tput setaf 1`
GREEN=`tput setaf 2`
BLUE=`tput setaf 3`

setupAcl() {
	echo $GREEN 'Setup ownership and permissions for' $ROOT_DIR $ENDC	
	HTTPDUSER='www-data'
	sudo chown -R `whoami`:"$HTTPDUSER" .
	find . -type d -exec chmod 775 {} \; && find . -type f -exec chmod 664 {} \;
}

setupNginx()
{
	echo $GREEN 'Setup Nginx virtual host' $ENDC
	if [ -s /etc/nginx/conf.d/$VHOST ]; then
		sudo rm -rf /etc/nginx/conf.d/$VHOST
	fi
	sudo cp nginx.conf.sample /etc/nginx/conf.d/$VHOST

}

setupApache()
{
    echo $GREEN 'Setup Apache virtual host' $ENDC
	if [ -s /etc/apache2/conf-enabled/$VHOST ]; then
		sudo rm /etc/apache2/conf-enabled/$VHOST
	fi
	sudo cp apache.conf.sample /etc/apache2/conf-enabled/$VHOST
}

restartServer() {
    if [[ $NGINX = 1 || $NGINX = '1' ]]; then
		setupNginx
		sudo service nginx restart
	else
		setupApache
		sudo service apache2 restart
	fi
    sudo sh -c -- "echo '127.0.0.1 ${DOMAIN}' >> /etc/hosts"
	sudo service php7.0-fpm restart
	echo $GREEN 'Go to' http://$DOMAIN $ENDC
}

setupAcl &&
restartServer
