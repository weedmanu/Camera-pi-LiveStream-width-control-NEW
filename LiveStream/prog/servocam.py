#!/usr/bin/python
# -*- coding: utf-8 -*-

# import des librairies nécessaire
import subprocess
import time
import psutil
import serial 
import socket

ser = serial.Serial('/dev/ttyUSB0', 9600) # port usb utilise pour l'arduino nano

s=socket.socket(socket.AF_INET,socket.SOCK_STREAM) # on définit le socket

host= '127.0.0.1'    # ip du pi ou 192.168.xxx.xxx c'est la même sur les clients php
port=int(9999)       # port utilisé, c'est le même sur les clients php
s.bind((host,port))   #  on construit le socket
s.listen(1)                # 1 seule instruction acceptée à la fois

# en écoute boucle infini
while True: 
	conn,addr =s.accept()         # si un client se connecte
	data=conn.recv(2048)         # met dans la variable data ce qu'il a envoyer
	data=data.decode("utf-8")   # encodage 
	s.close                                   # on ferme le socket
	
	if data <= '5':				# si data est inférieur à 5 (c'est le panneau de contrôle)
		ser.write(str(data)) # on envoie la commande au programme de l'Arduino		
		time.sleep(1)            # on attend 1s
		
	if data == '6':			
		# on verifie si raspistill est deja lance
		# on défini notre flag a false
		existe = False 
		for p in psutil.process_iter():  # on liste en boucle les process qui tournent
			try:
					pi = p.as_dict(attrs=['pid', 'name'])
			except:
					pass
			else:
					if pi['name'] == 'raspistill': # si raspistill est trouvé
						existe = True
						# Pas besoin d'aller plus loin
						break # on sort de la boucle
		#s'il est pas trouvé	
		if not existe:
			# on lance le script du streaming		
			subprocess.call("/var/www/html/LiveStream/prog/./play.sh", shell=True)			

	
	if data == '7':		
		# on lance le script qui stop les programmes	
		subprocess.call("/var/www/html/LiveStream/prog/./stop.sh", shell=True)			


	if data == '8':	
		# on vérifie si raspistill est déjà lance
		existe = False
		for p in psutil.process_iter():
			try:
					pi = p.as_dict(attrs=['pid', 'name'])
			except:
					pass
			else:
					if pi['name'] == 'raspistill':
						existe = True
						# on lance le script qui prend les photos
						subprocess.call("sudo /var/www/html/LiveStream/prog/./photo.sh", shell=True)
					
	if data == '9':
		# on lance le script qui supprime les photos
		subprocess.call("/var/www/html/LiveStream/prog/./supp.sh", shell=True)		




