# Galleries
Site web permettant de naviguer dans une galleries d'image.
Il est possible de filtrer les images par format (Portrait, paysage, autre), catégorie (0, 1, ...), nom, dossier, possibilité de l'afficher en plein écran ...

Les images peuvent être stocké n'importe où (voire section Dépendance)

# Dépendances
- Nécéssite un fichier .htaccess à la racine
```
RewriteEngine On
RewriteRule ^([a-zA-Z0-9\-\_\/]*)$ index.php?url=$1
```

- Nécéssite una base sql pour gérer les dépendances des pages web (pour les fichier css et js), selon le shéma suivant
  ![Shéma relationnel de la bbd](Shéma.png)
  
- Nécessite une base sql contenant les chemins d'accés vers toutes les images de la gallerie selon le shéma relationnel : 
  id, path, name, type, category, fullscreen
