#!/bin/bash

CYAN='\033[1;36m'
RED='\033[1;31m'
GREEN='\033[1;32m'
YELLOW='\033[1;33m'
BLUE='\033[1;34m'
NC='\033[0m'

if (whiptail --title "Installation" --yesno "voulez vous lancer l'installation ?" --yes-button "oui" --no-button "non" 10 60) then	
	printf "%b\n" "   ${GREEN}////////////////////////////////////////////////\n   ${YELLOW}//      Début du programme dinstallation      //\n   ${RED}////////////////////////////////////////////////${NC}\n"	
	echo ""
	printf "%b\n" "${BLUE}     ********************************\n     *   mise à jour du Raspberry   *\n     ********************************${NC}\n"
	echo ""
	printf "%b\n" "${CYAN}"
	apt-get update && apt-get upgrade -y	
	echo ""
	printf "%b\n" "${BLUE}     *************************************************\n     *   installation des librairie nécessaire à mjpg-streamer  *\n     *************************************************${NC}\n"
	echo ""
	printf "%b\n" "${CYAN}"
	apt-get install apt-transport-https
	echo ""
	apt-get install subversion libjpeg8-dev imagemagick libv4l-dev -y
	echo ""
	ln -s /usr/include/linux/videodev2.h /usr/include/linux/videodev.h
	printf "%b\n" "${BLUE}     ***************************************************\n     *  téléchargement et compilation du programme'   *\n     ***************************************************${NC}\n"
	echo ""
	printf "%b\n" "${CYAN}"
	svn co https://svn.code.sf.net/p/mjpg-streamer/code/
	echo ""
	cd code/mjpg-streamer
	printf "%b\n" "${CYAN}"
	make mjpg_streamer input_file.so output_http.so
	cp mjpg_streamer /usr/local/bin
	cp output_http.so input_file.so /usr/local/lib/
	cp -R www /usr/local/www
	cd /home/pi
	rm -r /home/pi/code
	cp /usr/local/www/stream_simple.html /usr/local/www/cam.html
	printf "%b\n" "${BLUE}     *****************************************************************\n     *   installation d' apache de git et des outils python.'   *\n     *****************************************************************${NC}\n"
	echo ""
	printf "%b\n" "${CYAN}"
	cd /home/pi
	apt-get install python-dev python-openssl python-pip git -y
	echo ""
	pip install psutil && sudo pip install pyserial
	echo ""
	apt-get install apache2 php5 libapache2-mod-php5 php5-mysql -y
	cd /var/www/html/
	rm index.html
	cd /home/pi
	printf "%b\n" "${BLUE}     *****************************************************************\n     *   installation du  su site web.'   *\n     *****************************************************************${NC}\n"
	echo ""
	printf "%b\n" "${CYAN}"
	git clone https://github.com/weedmanu/Camera-pi-LiveStream-width-control-NEW.git
	echo ""
	mv /home/pi/Camera-pi-LiveStream-width-control-NEW/LiveStream -t /var/www/html/
	rm -rf /home/pi/Camera-pi-LiveStream-width-control-NEW
	echo ""
	cp /etc/rc.local /home/pi/test
	sed -i '$d' test
	echo "python /var/www/html//LiveStream/prog/servocam.py" >> test
	echo "" >> test
	echo "exit 0" >> test
	mv test /etc/rc.local
	python /var/www/html/LiveStream/prog/servocam.py &
	echo "Ouvrez ce lien ci-dessous dans votre navigateur  pour voir le résultat"
	ipeth0=`ifconfig eth0|grep inet|head -1|sed 's/\:/ /'|awk '{print $3}'`
	ipwlan0=`ifconfig wlan0|grep inet|head -1|sed 's/\:/ /'|awk '{print $3}'`
	function valid_ip()
	{
		local  ip=$1
		local  stat=1

		if [[ $ip =~ ^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$ ]]; then
			OIFS=$IFS
			IFS='.'
			ip=($ip)
			IFS=$OIFS
			[[ ${ip[0]} -le 255 && ${ip[1]} -le 255 \
				&& ${ip[2]} -le 255 && ${ip[3]} -le 255 ]]
			stat=$?
		fi
		return $stat		
	}
	valid_ip $ipeth0
	exitstatus=$?
	if [[ $exitstatus = 0 ]]; then
	tonip=$ipeth0
	fi
	valid_ip $ipwlan0
	exitstatus=$?
	if [[ $exitstatus = 0 ]]; then
	tonip=$ipwlan0		
	fi
	echo ""  
	printf "           http://${tonip}/LiveStream/ "    
	printf "%b\n" "${NC}"
	echo ""
	printf "%b\n" "${GREEN}powered ${YELLOW}by ${RED}weedmanu${NC}\n"
	echo ""
	printf "%b\n" "${RED}Un reboot est recommandé${NC}\n"
	echo ""
	if (whiptail --title "Installation" --yesno "voulez-vous le faire maintenant ? ?" --yes-button "oui" --no-button "non" 10 60) then
		reboot
	else
		whiptail --title "Installation" --msgbox "reboot annulée !!!" 10 60
	fi	
else
	whiptail --title "Installation" --msgbox "Installation annulée !!!" 10 60
fi
exit

