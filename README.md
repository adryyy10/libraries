# libraries

Set up:
- php bin/console doctrine:fixtures:load para poder cargar la fake data de las diferentes entidades

- symfony server:start y vamos a la URL: http://127.0.0.1:8000/

A partir de aquí tenemos dos vertientes en el login:
- Backoffice: user= Adryyy10 password= 1234
- FrontOffice: user= AdryyyLibrarian password= 1234

Para poder cambiar de Backoffice a FrontOffice y viceversa primero tendremos que hacer logout en http://127.0.0.1:8000/logout 
