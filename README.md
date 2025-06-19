
#!/bin/bash
ls /etc/*.conf > ~/Escritorio/examen_so_linux/salida/conf_list.txt
cantidad=$(ls /etc/*.conf | wc -l)
echo "Cantidad de archivos .conf: $cantidad"
df -h > ~/Escritorio/examen_so_linux/salida/disco.txt
