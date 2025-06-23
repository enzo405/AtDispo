# AP3 Planning formateur

> Site accessible en version de test sur https://atdispo.luhcaran.fr

## 1. Contexte

Les formateurs assurent des cours pour différentes structures. Chaque formateur doit fournir ses disponibilités aux responsables pédagogiques de différentes formations, afin de permettre à ceux-ci de l'affecter sur des créneaux horaires de cours. Pour cela, les formateurs fournissent un tableau de disponibilité qu'ils sont obligés de mettre à jour régulièrement.

## 2. Mission

Le but du projet est de réaliser une application à interface web permettant de gérer ces tableaux de disponibilités. Les données seront conservées dans une base MariaDB, et le développement réalisé en PHP, avec obligatoirement le framework utilisé en cours. L'accès à l'application se fait en s'identifiant par une adresse de courrier électronique personnelle. Le développement et la documentation respecteront le formalisme prévu dans le document sur les fondamentaux des projets. Un exemple de tableau de disponibilité  annuel est fourni.

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
