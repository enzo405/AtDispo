# Cahier des charges :

Date de modification : 16/10/2023

Auteur : Erwan BRION / Tess NASSIVET

[toc]

## Maître d'ouvrage :

CCI Campus de la Chambre de Commerce et d’Industrie d’Alsace

Eurométropole 234, Avenue de Colmar – 67021 Strasbourg



## Présentation :

Ce cahier des charges technique à pour objectif de décrire la création d'une application à interface web permettant de gérer des tableaux de disponibilités.

Cette application est destinée aux formateurs et responsables pédagogiques.  



## Objectif :

L'équipe doit avoir une démarche de gestion de projets impliquant la définition de tâches, leur attribution à une personne, la  définition d’échéances, un plan de charge, des états d’avancement, une gestion du temps et un travail d’équipe.



## Description fonctionnelle :

L'application doit permettre :

- à un administrateur :
  - de saisir annuellement les périodes de congés scolaires et les jours fériés,
  - de gérer les organismes de formation :
    - valider les noms proposés par les responsables pédagogiques,
    - fusionner si nécessaire des organismes en doublon,
  - de valider les noms des formations proposées par les responsables pédagogiques, quitte à les fusionner,
  - de valider les comptes des formateurs et des responsables pédagogiques,
- à un formateur :
  - de créer un compte sur l'application,
  - de choisir le ou les organismes de formation où il intervient,
  - de désigner le ou les responsables pédagogiques pouvant visualiser ses disponibilités,
  - d'accepter la réservation d'un créneau par tel ou tel responsable pédagogique pour une formation donnée,
  - de saisir ses disponibilités par demi-journée, avec quatre niveaux : disponible, éventuellement disponible, indisponible, non renseigné, avec le choix de présentation annuel ou mensuel,
  - d'envoyer par courrier électronique en PDF le tableau de disponibilités vers une adresse à saisir,
  - de visualiser un emploi du temps d'une formation sur laquelle il intervient, c'est-à-dire touts les créneaux occupés d'une formation, en précisant le nom du cours et le formateur associé,
- à un responsable pédagogique :
  - de créer un compte sur l'application,
  - de proposer le nom du ou des organismes de formation auquel il appartient, s'il est manquant,
  - d'ajouter éventuellement au calendrier des ponts pour son organisme,
  - de saisir le nom de la ou des formations dont il est responsable,
  - de visualiser le tableau des disponibilités de chaque intervenant qui partage avec lui ses disponibilités, avec le choix de présentation annuel ou mensuel,
  - de visualiser sur les indisponibilités des formateurs, le nom de la formation si cette formation fait partie d'une des formations qu'il gère (et uniquement celles-ci),
  - de réserver un créneau chez un intervenant pour un organisme et une formation donnés,
- automatiquement de modifier les disponibilités en passant en :
  - éventuellement disponibles les créneaux réservés,
  - non disponible les créneaux dont la réservation a été acceptée par le formateur.



## Accès à la plateforme : 

Tout formateur et responsables pédagogiques intervenant dans différentes structure.



## Interfaces utilisateur :

#### Interfaces communes :

- Page de login

- Page calendrier

  - Vue annuelle
  - Vue mensuelle

- Paramètre

  - Modification des données personnelles (mail, tel, nom utilisateur, mot de passe)

- Page mot de passe oublié

  

#### Interface formateur :

- Page demande de création de compte

- Page de calendrier personnel (toutes les cours sans distinction de lieu ou de formation)

  - Section disponibilité (code couleur)

- Page calendrier par formation (sio22)

- Bouton envoi PDF par email

- Choisir organismes et formations

- Désigner son responsable pédagogique

- Réservation de créneau :

  - Refuser
  - Accepter

  

#### Interface responsable pédagogique :

- Page demande de création de compte

- Page de calendrier de ces formateurs

  - Vue des disponibilités (code couleur)
  - Vue des indisponibilités

- Page d'ajout de formations dont il est responsable

- Page d'ajout d’organismes

- Page d'ajout des ponts au calendrier

- Page réservation de créneaux

  

#### Interface administrateur :

- Page calendrier
  - Saisie congés et jours fériés
- Page administration utilisateurs :
  - liste d'utilisateurs 
  - attente validation utilisateurs
  - créer / supprimer / modifier
- Page administration formations :
  - liste de formations
  - attente validation formations
  - créer / supprimer / modifier
- Page administration des organismes :
  - liste des organismes
  - attente validation organismes
  - créer / supprimer / modifier