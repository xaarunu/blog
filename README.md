# rij

## Descargar el proyecto

1. Clonar  repositorio
**git clone {link del repo sin las llaves}**
2. Crear base de datos con nombre **rij** con esta codificacion  utf8_general_ci
3. Instalar node.js y correr los comandos dentro de la carpeta del proyecto
**npm install && run dev**
4. **php artisan storage:link**
5. **php artisan migrate:fresh --seed**

---
## Settear ambiente local
1. Ve al archivo config/app.php y asegurate que en la seccion Application URL este las linea que dicen localhost **Descomentadas** y las que tienen una direccion ip **Comentadas**
2. En la raiz del proyecto esta el archivo .env,  cambia el DB_PASSWORD en live settings segun sea necesario para trabajar en local

---
## Correr el proyecto de manera local
php artisan serve

---
## Subir cambios al repositorio de github
Para subir cambios se debe crear un branch con tu nombre y trabajar siempre en ella
1. Asegurate de que estas en tu branch por medio de: git status
2. Cambiar de branch: git checkout {Nombre de tu branch sin las llaves}
3. git add . (Para agregar todos los archivos cambiados) o usa git add {nombre de tu archivo sin las llaves} para agregar uno por uno
4. git commit "aqui va tu comentario de que hiciste"
5. git push

Si te sale el error de que no sabe quien eres o de que te tienes que identificar usa:
1. git config user.name "Tu nombre de usuario"
2. git config user.email "Tu email"

---

## Limpiar el cache del proyecto en caso de ser necesario
php artisan cache:clear

## Mantener tu branch al dia con main
git merge main desde tu branch
git push

## Proyecto realizado por

- David Bonilla
- Juan Pablo Gutierrez Arreola
- Jonathan Eslavi
- Daniel Gonzalez Reveles
- Karina Villa