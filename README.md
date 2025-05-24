# Galerie

Ce site web permet de naviguer au sein d’une galerie d’images, avec plusieurs options de filtrage : par format (portrait, paysage, autre), par catégorie (0, 1, ...), par nom ou encore par dossier.

Les images peuvent être stockées à n’importe quel emplacement (voir section *Dépendances*).

---

# Motivation

Ce projet m’a servi de point d’entrée dans le développement web, et plus particulièrement dans la découverte de PHP. Il m’a également amené à réfléchir à la conception d’une base de données, ainsi qu’à l’organisation du code en vue de sa réutilisabilité et de sa maintenance.

Ces choix ont porté leurs fruits : un second projet a pu être réalisé efficacement en se basant sur cette première structure.

---

# Dépendances

- Nécessite un fichier `.htaccess` à la racine du projet :

```apache
RewriteEngine On
RewriteRule ^([a-zA-Z0-9\-\_\/]*)$ index.php?url=$1
```

- Nécessite une base de données SQL pour gérer les dépendances entre les différentes pages web (fichiers CSS, JS, etc.), selon le schéma suivant :  
  ![Schéma relationnel de la BDD](Shéma.png)

- Nécessite également une base de données SQL contenant les chemins d’accès vers toutes les images de la galerie, selon le schéma suivant :
  `id`, `path`, `name`, `type`, `category`, `fullscreen`
