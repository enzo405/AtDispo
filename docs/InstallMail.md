# Documentation d'Installation et de Configuration de MailHog avec Postfix

## Introduction

MailHog est un outil de test d'e-mails qui vous permet de capturer, visualiser et tester les e-mails envoyés depuis votre application. Cette documentation vous guidera à travers l'installation de MailHog avec Docker et la configuration de Postfix pour la réception d'e-mails locaux.

### Prérequis

Avant de commencer, assurez-vous d'avoir Docker installé sur votre système. Vous pouvez télécharger Docker depuis [le site officiel](https://www.docker.com/get-started).

## Étapes d'Installation

### Étape 1 : Téléchargement de l'image MailHog

Ouvrez un terminal et exécutez la commande suivante pour télécharger l'image MailHog depuis le Docker Hub :

```bash
docker pull mailhog/mailhog
```

### Étape 2 : Démarrage de MailHog

Exécutez la commande suivante pour démarrer MailHog en utilisant Docker :

```bash
docker run -d -p 8025:8025 -p 1025:1025 --name mailhog mailhog/mailhog
```

Cela démarre MailHog en exposant les ports 8025 (interface web) et 1025 (serveur SMTP).

### Étape 3 : Vérification de l'interface Web

Ouvrez votre navigateur et accédez à [http://localhost:8025](http://localhost:8025/) pour vérifier que MailHog est en cours d'exécution.

## Configuration de Postfix

### Étape 1 : Installation de Postfix

Installez Postfix en utilisant la commande suivante :

```bash
sudo apt-get install postfix
```

### Étape 2 : Configuration du relais SMTP

Modifiez le fichier de configuration de Postfix `/etc/postfix/main.cf` en ajoutant les lignes suivantes à la fin du fichier :

```bash
relayhost = [localhost]:1025
```

### Étape 3 : Redémarrage de Postfix

Redémarrez le service Postfix pour appliquer les modifications :

```bash
sudo service postfix restart
```

## Test d'Envoi d'E-mails

Envoyez un e-mail depuis votre application ou un client de messagerie local. Accédez à l'interface web de MailHog [http://localhost:8025](http://localhost:8025/) pour visualiser les e-mails capturés.