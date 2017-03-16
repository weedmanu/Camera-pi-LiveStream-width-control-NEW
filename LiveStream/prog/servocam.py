#!/usr/bin/python
# -*- coding: utf-8 -*-

import subprocess
import time
import psutil
import serial 
import socket

ser = serial.Serial('/dev/ttyUSB0', 9600) # port usb utilise pour l'arduino nano

s=socket.socket(socket.AF_INET,socket.SOCK_STREAM)

host= '127.0.0.1'
port=int(9999)
s.bind((host,port))
s.listen(1)

while True:
	conn,addr =s.accept()
	data=conn.recv(2048)
	data=data.decode("utf-8")
	s.close
	
	if data <= '5':				
		ser.write(str(data)) # on envoie la commande au programme de l'arduino		
		time.sleep(1)
		
	if data == '6':			
		# on verifie si raspistill est deja lance
		# on defini notre flag a false
		existe = False
		for p in psutil.process_iter():
			try:
					pi = p.as_dict(attrs=['pid', 'name'])
			except:
					pass
			else:
					if pi['name'] == 'raspistill':
						existe = True
						# Pas besoin d'aller plus loin
						break
		# sinon on le lance	dans un process en parallele et on continu		
		if not existe:
			# on lance la prise de photos.		
			subprocess.call("/var/www/html/LiveStream/prog/./play.sh", shell=True)			

	
	if data == '7':		
		# on stop les programmes	
		subprocess.call("/var/www/html/LiveStream/prog/./stop.sh", shell=True)			


	if data == '8':	
		# on verifie si raspistill est deja lance
		existe = False
		for p in psutil.process_iter():
			try:
					pi = p.as_dict(attrs=['pid', 'name'])
			except:
					pass
			else:
					if pi['name'] == 'raspistill':
						existe = True
						subprocess.call("sudo /var/www/html/LiveStream/prog/./photo.sh", shell=True)
					
	if data == '9':	
		subprocess.call("/var/www/html/LiveStream/prog/./supp.sh", shell=True)		




