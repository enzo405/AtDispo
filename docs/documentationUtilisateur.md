# Documentation utilisateur : 

Date de modification : 23/10/2023

Auteur : Erwan BRION / Tess NASSIVET

[toc]

## Installation :

```bash
####### Prérequis #######
# Mise à jour du système
sudo apt update && sudo apt upgrade -y

# Création de la clé SSH pour gitlab
ssh-keygen -t rsa -b 4096 -q
# Ne faire que entrer
# Mettre la clé SSH dans votre compte gitlab

# Cloner le repo
git clone git@gitlab.com:antoine.zimmer.gambsheim/ap3-planning-formateur.git
# Si git n'est pas installé faire (normalement git est installé par défaut sur les VM multipass) :
sudo apt install git

# On lance le script
cd ap3-planning-formateur/installation
sudo chmod +x script
./script
```

<u>Le script :</u>

```bash
####### Script d'installation pour AT-DISPOS #######
# Installation de mariadb, apache2, php8.1-fpm et ses extensions
if sudo apt install -y mariadb-server apache2 php8.1-fpm php-common php-mysql php-curl php-gd php-intl php-json php-mbstring php-xml php-zip libapache2-mod-php phpmyadmin unzip;
then
    echo "Paquets mariadb, apache, php, phpmyadmin et unzip installés avec succès."
else
    echo "L'installation des paquets mariadb, apache, php, phpmyadmin et unzip a échoué. Vérifiez les erreurs ci-dessus."
    exit 1
fi

# Activer le démarrage automatique de PHP
sudo systemctl enable php8.1-fpm

# Activation des modules Apache
if sudo a2enmod php8.1 && sudo a2enmod rewrite;
then
    echo "Modules Apache activés avec succès."
else
    echo "L'activation des modules Apache a échoué. Vérifiez les erreurs ci-dessus."
    exit 1
fi

sudo mv ~/ap3-planning-formateur /var/www/

sudo cp /var/www/ap3-planning-formateur/installation/000-default.conf /etc/apache2/sites-available/000-default.conf

# Redémarrage du service Apache2
sudo systemctl restart apache2

# Ajouter le groupe www-data à l'utilisateur ubuntu
sudo usermod -a -G www-data ubuntu

# Définition des droits
if sudo chown -R www-data:www-data /var/www && sudo chmod -R 2775 /var/www; then
    echo "Droits définis avec succès."
else
    echo "La configuration des droits a échoué. Vérifiez les erreurs ci-dessus."
    exit 1
fi

#Installation de composer
if sudo php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
sudo php -r "if (hash_file('sha384', 'composer-setup.php') === 'e21205b207c3ff031906575712edab6f13eb0b361f2085f1f1237b7126d785e826a450292b6cfd1d64d92e6563bbde02') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
sudo php composer-setup.php
sudo php -r "unlink('composer-setup.php');"
sudo mv composer.phar /usr/local/bin/composer;
echo "Composer.phar à été déplacé vers : /usr/local/bin/composer"
then
	echo "Composer est installé avec succès"
else
	echo "L'installation de composer à échoué"
	exit 1
fi

# Ajout du vendor
cd /var/www/ap3-planning-formateur/project
composer dump-autoload

# Faire l'ajout de la BDD ?

# Avertissement pour redémarrer manuellement
echo "Le script a terminé. Veuillez redémarrer manuellement la machine pour appliquer les modifications."
exit 1
```



## Configuration :

### Configuration Apache2 :

```bash
sudo nano /etc/apache2/sites-available/000-default.conf
```

```bash
<VirtualHost *:80>
	ServerName dev.mshome.net
	ServerAdmin webmaster@localhost
    DocumentRoot /var/www/ap3-planning-formateur/project/public

    <Directory /var/www/ap3-planning-formateur/project/public>
    	DirectoryIndex index.html index.cgi index.pl index.php index.xhtml
    	Options -Indexes +FollowSymLinks +MultiViews
    	AllowOverride All
    	Order allow,deny
    	Allow from all
    	Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```



## Mise à jour : 

 