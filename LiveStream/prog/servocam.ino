#include <Servo.h>

Servo myservoZ;  // déclare le servo pour l'axe z

Servo myservoY; // déclare le servo pour l'axe y

int posZ = 90;    // pour la position initial 90°
int posY = 90;    // pour la position initial 90°
int message = 0;  //  par défaut message vaut 0
int posZZ;
int posYY;


void setup() {
  myservoZ.attach(2);  // servo z sur pin 2 
  myservoZ.write(posZ);  // va en position initial
  myservoY.attach(3);  // servo z sur pin 3
  myservoY.write(posY); // va en position initial
  Serial.begin(9600); 
}

void cam()  // fonction  
{
  if (Serial.available())  {   // si on recoit quelque chose du port serie
    message = Serial.read()-'0';  // on soustrait le caractère 0, qui vaut 48 en ASCII
    
    switch (message) {  // si message vaut
    case 1:  //  si message vaut 1 on tourne à droite
      posZZ = posZ + 10;  // on defini la nouvelle position (position actuelle augmentée de 10°)
      if (posZZ > 180)    // pour ne jamais depassé les 180°
        {
          posZZ = 180;
        }    
      for(posZ=posZ; posZ <= posZZ; posZ += 1) // boucle for, pour se déplacer à la nouvelle position pas trop vite et pas à pas.
         {                                  
           myservoZ.write(posZ);
           delay(100);
         }      
      break;
    case 2:    //  si message vaut 2 on tourne à gauche
      posZZ = posZ - 10;   // on defini la nouvelle position (position actuelle diminuée de 10°)   
      if (posZZ < 0)   // pour ne jamais descendre en dessous de 0°
        {
          posZZ = 0;
        }
      for(posZ=posZ; posZ >= posZZ; posZ -= 1)    // boucle for, pour se déplacer à la nouvelle position pas trop vite et pas à pas.
         {                                  
           myservoZ.write(posZ);
           delay(100);
         }      
      break;
    case 3:    //  si message vaut 3 on monte
      posYY = posY + 10;  // on defini la nouvelle position (position actuelle augmentée de 10°)
      if (posYY > 180)   // pour ne jamais depassé les 180°
        {
          posYY = 180;
        }  
      for(posY=posY; posY <= posYY; posY += 1)      // boucle for, pour se déplacer à la nouvelle position pas trop vite et pas à pas.
         {                                  
           myservoY.write(posY);
           delay(100);
         }
      break;
    case 4:   //  si message vaut 3 on descend
      posYY = posY - 10;   // on defini la nouvelle position (position actuelle diminuée de 10°) 
      if (posYY < 0)       // pour ne jamais descendre en dessous de 0°
        {
          posYY = 0;
        }
      for(posY=posY; posY >= posYY; posY -= 1)      // boucle for, pour se déplacer à la nouvelle position pas trop vite et pas à pas.
         {                                  
           myservoY.write(posY);
           delay(100);
         }
      break;
    case 5:   //  si message vaut 5 on se remet en position initiale en fonction de la ou on se trouve pas trop vite et pas à pas.
      if (posZ > 90)  {   
        for(posZ=posZ; posZ >= 90; posZ -= 1)      
         {                                  
          myservoZ.write(posZ);
          delay(100);
         }           
      }
      if (posZ < 90)  {
        for(posZ=posZ; posZ <= 90; posZ += 1)      
         {                                  
           myservoZ.write(posZ);
           delay(100);
         }           
      }
      if (posY > 90)  {
        for(posY=posY; posY >= 90; posY -= 1)      
         {                                  
          myservoY.write(posY);
          delay(100);
         }           
      }
      if (posY < 90)  {
        for(posY=posY; posY <= 90; posY += 1)      
         {                                  
           myservoY.write(posY);
           delay(100);
         }           
      }
      break;
    }
  }
}

void loop() {
   cam();  // appel de la fonction en boucle,
}

