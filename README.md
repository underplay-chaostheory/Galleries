# Galerie
Site web permettant de naviguer dans une galerie d'image, en les filtrant par format (portrait, paysage, autre), catégorie (0, 1, ...), nom, dossier, possibilité de l'afficher en plein écran ...

Les images peuvent être stocké n'importe où (voire section Dépendance)

# Motivation
Ce projet a servi de prétexte pour :
- découvrir le monde web, notamment php
- réfléchir à la création d’une base de donné
- prêter attention à la réutilisable du code et à la facilité de le modifier. En particulier, un second projet a pu être efficacement réalisé en servant de celui-ci.

# Dépendances
- Nécessite un fichier .htaccess à la racine
```
RewriteEngine On
RewriteRule ^([a-zA-Z0-9\-\_\/]*)$ index.php?url=$1
```

- Nécessite une base sql pour gérer les dépendances des pages web (pour les fichier css et js), selon le shéma suivant
  ![Shéma relationnel de la bbd](Shéma.png)
  
- Nécessite une base sql contenant les chemins d’accès vers toutes les images de la galerie selon le schéma relationnel : 
  id, path, name, type, category, fullscreen
