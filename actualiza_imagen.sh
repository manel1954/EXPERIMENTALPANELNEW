#!/bin/bash

fecha=$(date +%Y%m%d) # extrae fecha del día en formato 20241129 
# Convertir a formato dd-mm-yyyy 29-11-2024
fecha_formateada=$(echo "$fecha" | awk '{print substr($0, 7, 2) "-" substr($0, 5, 2) "-" substr($0, 1, 4)}')
sed -i "2c $fecha_formateada" /home/pi/version-fecha-actualizacion

                        cd /home/pi/EXPERIMENTAL_PANEL                                              
                        git pull --force                      
                        sudo rm -R /home/pi/A108
                        mkdir /home/pi/A108                                                
                        cp -R /home/pi/EXPERIMENTAL_PANEL/* /home/pi/A108
                        sleep 6                                             
                        sudo chmod 777 -R /home/pi/A108
                        

                        cp subir_archivos.php /var/www/html/ # implementado el 07-07-2025
                        cp panel_control.php /var/www/html/paneles_virtuales_nextion/ # implementado el 07-07-2025

                        sudo rm /home/pi/esp32/*.*
                        sudo rm -R /home/pi/esp32/esp32_nextion
                        sudo rm -R /home/pi/esp32/esp32_openweather
                        sudo cp -R /home/pi/A108/esp32 /home/pi/
                        sudo chmod 777 -R /home/pi/esp32

                 


                        
                    
