# <div align="center">**SAE 2-01**</div>

# **Equipe du projet**
- LEBEGUE Killyan login : **lebe0069**, email universitaire: **killyan.lebegue@etudiant.univ-reims.fr** 
-  RAVIGNON Enzo login : **ravi0023**, email universitaire   **enzo.ravignon@etudiant.univ-reims.fr**



# Installation / Configuration

## Serveur Web Local
### Installation Composer 

* Rendez-vous sur GitLab
   
```
git clone https://iut-info.univ-reims.fr/gitlab/ravi0023/sae2-01.git
```

* Rendez-vous sur le site de composer et exécutez les commandes permettant de le télécharger.

```shell

php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === 'dac665fdc30fdd8ec78b38b9800061b4150413ff2e3b6f88543c636f7cd84f6db9189d43a81e5503cda447da73c7e5b6') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"

```


* Vérifiez que la commande « composer » est bien localisée dans votre répertoire « $HOME/bin » : 

```shell
$ which composer
```

* Testez le bon fonctionnement de la commande « composer » en l'exécutant : 

```shell
$ composer --version
```

### Lancer son Serveur Web local en ligne de commande 

**NB : Il faut se placer dans le répertoire de votre projet grâce à la commande cd**

Commande pour lancer le serveur Web local :
```shell
php -d display_errors -S localhost:8000 -t public/
```

### Utilisation de Composer pour lancer son Serveur Web local
A la racine du projet, créer un répertoire nommé **bin**. Dans ce dernier, nous allons y ajouter les fichiers run serveur afin que le projet puisse tourner sur Windows & Linux.

**Linux :**
* Nommer le fichier 'run-server.sh'
* Compléter ce dernier avec les lignes suivantes :
````shell
#!/usr/bin/env bash

APP_DIR="$PWD" php -d display_errors -S localhost:8000 -t public/

````

**Windows :**
* Nommer le fichier 'run-server.bat'
* Compléter ce dernier avec les lignes suivantes :
````shell
set APP_DIR=%cd%
php -d display_errors -d auto_prepend_file="%cd%\vendor\autoload.php" -S localhost:8000 -t public/
````

Ensuite, il faut ajouter un script dans notre fichier **composer.json** de façon a ce que la partie script ressemble à cela :
````shell
"scripts": {
        "start:linux": "bin/run-server.sh -t0 -d auto_prepend_file=\"$PWD/vendor/autoload.php\"",
        "start:windows": [
            "Composer\\Config::disableProcessTimeout",
            "bin/run-server.bat"
        ],
````
Ici on a ajouter **"start:linux"** et **"start:windows"**. Il est donc maintenant possible de lancer son serveur web local avec les commandes suivantes 

**Pour Linux :**
````shell
composer start:linux
````
**Pour Windows:**
````shell
composer start:windows
````

## Configuration de la base de données

NB : Avant de commencer cette partie, veuillez lire la documentation de la méthode «**MyPdo::setConfigurationFromIniFile()**» dans le fichier « **MyPdo.php** »

1) Créez un fichier «**.mypdo.ini** » à la racine du projet
2) Complétez-le avec les informations de connexion, selon le modèle fourni dans la documentation de la méthode 

Exemple :
````shell
 [mypdo]
   dsn = "mysql:host=mysql;dbname=votrenomdebd;charset=utf8"
   username = 'votrelogin'
   password = 'votrepassword'
````


## Style de codage
### PHP CS FIXER

Pour l'installer voici comment faire 
1) Rechercher <<**fixer**>> dans les paquets **Composer** :
   ````shell
   composer search fixer
   ````   

2) Demandez la dépendance de développement sur «**friendsofphp/php-cs-fixer**» :
   ````shell
   composer require friendsofphp/php-cs-fixer --dev
   ````
Observez les répercussions sur le contenu du fichier « **composer.json** »


Constatez l'apparition du fichier « composer.lock »

**NB: Le fichier « composer.lock » contient les versions précises des paquets installés par Composer. Il permet de remettre un projet dans un état fonctionnel en installant les versions des paquets utilisées par le développeur, par exemple lors du clonage d'un dépôt Git. Il est donc primordial d'inclure ce fichier dans votre dépôt Git.**


Vérifiez le bon fonctionnement de PHP CS Fixer :
````shell
php vendor/bin/php-cs-fixer
````

### Utilisation de CS FIXER en ligne de commande
**NB : Pour télécharger le fichier PHP CS Fixer, <a href="http://cutrona/utils/correction/colorcache.php?f=%2Fbut%2Fs2%2Fphp-crud-music%2Fressources%2F.php-cs-fixer.php">cliquez ici</a>**

* Placez le fichier de configuration dans la racine de votre projet, puis ajouter le dans votre .gitignore afin de l'exclure de l'index git.

Exemple de commande :

1) Lancez une première vérification manuelle avec la commande :

    ````shell
    php vendor/bin/php-cs-fixer fix --dry-run
    ````

2) Lancez une nouvelle vérification manuelle avec la commande :

    ````shell
    php vendor/bin/php-cs-fixer fix --dry-run --diff
    ````



3) Lancez une dernière vérification manuelle avec la commande :
    ````shell
    php vendor/bin/php-cs-fixer fix
    ````

Maintenant, vous pouvez ouvrir les fichiers impacter et ainsi constatez les corrections apportées


## Ajout de scripts Composer pour faciliter l'utilisation de CS Fixer

Dans le fichier  « **composer.json** », ajoutez les lignes suivantes à la fin du fichier (**toujours dans l'accolade script**):

````shell
  "test:cs": "php-cs-fixer fix --dry-run --diff",
  "fix:cs": "php-cs-fixer fix"
  ````

Information :
* « **test:cs** » lancera la commande de vérification du code
* « **fix:cs** » qui lancera la commande de correction du code


### Documentaion

Une page index.html est disponible dans le dossier documentation pour pouvoir regarder toutes la documentation
