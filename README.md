# web-app-2026
Project for the Web Technology Coursework at University of Bologna

## Deploy via xampp

Per costruire correttamente il db siccome ora è hostato in locale bisogna:
- installare lampp
- aprire una porta libera
- avviare il server
- localizzare la cartella htdocs (dove vengono costruiti i db)
- all'interno di htdocs clonare la repository
- andare su http://localhost/phpmyadmin/ , se vi fa vedere la dashboard allora il server è avviato corrrettamente in locale
- una volta sulla dashboard andare sulla finestra SQL e copiare interamente il codice di db/webappdb.sql
- una volta che il db è stato creato muoversi all'interno.
- per provare il db infine vai su http://localhost/web-app-2026/public/index.php . 

NOTA: é un accrocchio momentaneo, per fare le cose bene il db andrebbe hostato su un server... ma è un punto di partenza

## Deploy via docker compose

Local / Remote deployment with internal docker network and *some* extended security features. Db gets automatically built and is persistent as docker
volume.

To deploy the application via docker ensure the following:
- Ensure docker and docker compose are installed on the system
- Create a `.env` to store the compose users following the `.env.example`
- Change /include/db.php `$host = 'db';` and the rest according to the `.env`

- Run `docker compose up -d --build` to deploy
- Access project at http://localhost/public/index.php
- phpmyadmin is accessible at http://localhost:8080

note: User is bindided to the apache server, one may need to ensure persmissions are properly set or configure a proper user inside compose 