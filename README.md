# 🍺 Ethur Personnellement - PGCPO pour la Brasserie Terroir & Saveurs

Bienvenue sur le dépôt GitHub du projet **Ethur**, une **Plateforme de Gestion et de Communication pour Petite Organisation (PGCPO)** développée pour la **Brasserie Terroir & Saveurs**, située dans les Hauts-de-France. Ce projet a été réalisé dans le cadre de ma première année de BTS SIO à l’EPSI Lille.

---

## Objectif du projet

L’objectif de ce projet est double :  
- **Développer la présence en ligne de la brasserie** à travers un site vitrine professionnel et attrayant (Simulation posé par l'intervenant)  
- **Fournir des outils de gestion numériques** adaptés aux différents profils des membres de la brasserie (administrateur, direction, brasseur, caissier, client).

---

## Structure du dépôt

- Database
   - config.php
- public
   - images
      - banniere.jpg
      - bannierebiere.jpg
      - blonde.png
      - brune.webp
      - chaine.jpg
      - ethurbiere.webp
      - rouge2.jpg
- admin_dashboard.php
- annule_reservation.php
- brasseurs_dashboard.php
- calculBiere.php
- commercial.php
- connexion.php
- contact.php
- direction_dashboard.php
- finance.php
- index.php
- info-register.php
- logout.php
- README.md
- register.php
- reserve_biere.php
- reset_password.php
- stockmat.php
- terroir_savoir.sql
- user_dashboard.php

---

## Structure de la base de données

La base de données est organisée autour des entités suivantes :
- **CLient** (admin, brasseurs, direction, caissiers, clients)
- **Stocks**
- **Recettes**
- **Matière Premières**
- **Réservations**
- **Finance**


 La BDD est pensée pour être **évolutive et modulaire**, permettant l'ajout futur de fonctionnalités ou profils utilisateurs.*

---

## Structure technique du programme

L'application est divisée en plusieurs modules :

| Module                    | Description |
|--------------------------|-------------|
| `Site vitrine`           | Interface publique avec présentation de la brasserie, ses produits, etc. |
| `Espace utilisateur`     | Connexion, affichage d’un message personnalisé selon le profil |
| `Back-office`            | Interfaces spécifiques pour chaque rôle |
| `API & traitement`       | Gestion des requêtes SQL, logique métier |
| `Système de logs`        | Journalisation des connexions et actions importantes |

---

## Fonctionnalités

Voici l’ensemble des fonctionnalités proposées par l’application.  
Les fonctionnalités **réalisées par mes soins** sont **_en gras et en orange_** :

### Sprint 1 Initialisation 
- Logo Brasserie
- Création du trello et rédaction des sprints
- **_Page Index_**
- Hébergement du site
- **_Page de connexion_**
- **_Page d'inscription_**
- **_Page de déconnexion logout.php_**
- **_Page contact.php_**

### Sprint 2 Base de Donnée
- **_MCD de base de données_**
- **_Création de la BDD sur phpmyadmin_**
- Création des pages de chaque persona pour les connecter à la BDD
- **_Création de la page administrateur_**
- **_Système de MDP hashé_**

### Sprint 3 Brasserie
- Faire la page brasseur
- Outils de brassage (calcul)
- Gestion du stock (Matières)
- **_Gestion du stock actuel (bières)_**
- **_Changement du blog en pdf sur pedagogeek_**
- **_(Option) Sauvegarde de recettes (partiel)_**

### Sprint 4 Client & Admin
- **_Tableau de bord administrateur_**
- **_Fonction de CRUD de la page Admin_**
- **_Création de la page utilisateur_**
- **_Système de Commande/Réservation des bières_**
- **_Système de fidélité_**

### Sprint 5 Management
- Bilan Financier
- Bilan Commercial
- Passerelle de gestion

### Sprint 6 Caissier
- **_Système de caisse_**
- **_Fidélité_**
- **_Système de réservation de produits_**
- **_Système d'achats manuel_**
- **Possibilité d'ajout de compte client_**

### Sprint 7 Finition 
- **_Finition du site_**
- Consultation des logs
- **_Supervision serveur (base minimale)_**
- **_Canva de présentation_**
- **_Relier tout les fichiers à la base de données et vérifier de la compatibilité générale du site_**
- **_Bouton de retour au tableau de bord / de déconnexion de toutes les pages_**

---

## Démonstration

### Vidéo de fonctionnement :

Lien youtube : https://youtu.be/uCPaAX0lrB4

---

## Hébergement et services

Les services installés et configurés :
- **Serveur web** : Infinity Free
- **FTP** : VSFTP sécurisé
- **SSH** : Clés RSA et sécurisation par fail2ban
- **Nom de domaine** : infy.uk fourni par InfinityFree
- **Base de données** : MySQL, PhpMyAdmin

---

## Sources et ressources
 
- Outils : DokuWiki (gestion projet), phpMyAdmin  
- Documents pédagogiques : www.pedagogeek.fr  
- Schémas de calculs : Annexe projet

---

## Auteur

👨‍💻 Réalisé par **Ethan Gomes-Carlier** & **Arthur Picque** 
Étudiants en BTS SIO 1ère année à l’EPSI Lille  
Projet réalisé dans le cadre de l’atelier professionnel SLAM 2025  
[LinkedIn](www.linkedin.com/in/ethang-gomes-carlier-350570327) 

---

## 📝 Licence

Ce projet appartient à Ethan & Arthur
