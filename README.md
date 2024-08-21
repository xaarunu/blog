
## Descargar y configurar el proyecto base

1. Clona el repositorio de este proyecto base:
   **git clone {link del repo sin las llaves}**
2. Accede a la carpeta del proyecto clonado.
3. Conecta tu proyecto a tu propio repositorio en GitHub:
   **git remote add origin {URL de tu repositorio en GitHub sin las llaves}**
4. Verifica que el repositorio remoto esté correctamente configurado:
   **git remote -v**

Este proyecto es un punto de partida. Puedes usarlo para crear tus propios desarrollos, aplicando personalizaciones y subiendo tus cambios a tu repositorio.


## Ejecutar el proyecto de manera local

Para iniciar el proyecto, usa el comando:
**php artisan serve**

---

## Subir cambios al repositorio de GitHub

Para subir cambios, sigue estos pasos:

1. Crea un branch con tu nombre y trabaja siempre en él.
2. Asegúrate de que estás en tu branch verificándolo con: **git status**
3. Cambia de branch usando: **git checkout {Nombre de tu branch sin las llaves}**
4. Agrega los archivos cambiados con: **git add .** (o usa **git add {nombre de tu archivo sin las llaves}** para agregar archivos individualmente).
5. Realiza un commit con un mensaje descriptivo de los cambios: **git commit -m "aquí va tu comentario de lo que hiciste"**
6. Sube tus cambios a tu repositorio con: **git push origin {Nombre de tu branch sin las llaves}**

Si te sale el error de que no sabe quién eres o de que te tienes que identificar usa:
1. **git config user.name "Tu nombre de usuario"**
2. **git config user.email "Tu email"**

---

## Limpiar el cache del proyecto en caso de ser necesario

Ejecuta:
**php artisan cache:clear**

## Mantener tu branch al día con main

Desde tu branch, sincronízate con la rama principal usando:
**git merge main**
Luego, sube los cambios:
**git push**
