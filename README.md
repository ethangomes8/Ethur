# 🍺 Ethur Personnellement - PGCPO pour la Brasserie Terroir & Saveurs

Bienvenue sur le dépôt GitHub du projet **Ethur**, une **Plateforme de Gestion et de Communication pour Petite Organisation (PGCPO)** développée pour la **Brasserie Terroir & Saveurs**, située dans les Hauts-de-France. Ce projet a été réalisé dans le cadre de ma première année de BTS SIO à l’EPSI Lille.

---

## Objectif du projet

L’objectif de ce projet est double :  
- **Développer la présence en ligne de la brasserie** à travers un site vitrine professionnel et attrayant (Simulation posé par l'intervenant)  
- **Fournir des outils de gestion numériques** adaptés aux différents profils des membres de la brasserie (administrateur, direction, brasseur, caissier, client).

---

## Structure du dépôt

├── admin_dashboard.php

├── annule_reservation.php

├── brasseurs_dashboard.php

├── calculBiere.php

├── commercial.php

├── connexion.php

├── contact.php

├── direction_dashboard.php

├── finance.php

├── index.php

├── info-register.php

├── logout.php

├── register.php

├── reserve_biere.php

├── reset_password.php

├── stockmat.php

├── terroir_savoir.sql

├── user_dashboard.php

├── README.md

├── Database/

│   └── config.php

└── public/
    
    └── images/
    
        ├── banniere.jpg
        
        ├── bannierebiere.jpg
        
        ├── blonde.png
        
        ├── brune.webp
        
        ├── chaine.jpg
        
        ├── ethurbiere.webp
        
        └── rouge2.jpg
        

---

## Structure de la base de données

La base de données est organisée autour des entités suivantes :
- **CLient** (<ins>id</ins>, nom_utilisateur, email, , mdp, role(admin, brasseurs, direction, caissiers, clients), mdp_reset, points)
- **Stocks** (<ins>id</ins>, type, description, montant, date)
- **Recettes** (<ins>id</ins>, nom, quantite, unite)
- **Matière Premières** (<ins>id</ins>, #brasseur_id, nom, volume, alcool, ebc, malt, brassage, eaurince, mcu, ebcresultat, srm, levure, houblon, arome, cree_le)
- **Réservations** (<ins>id</ins>, #utilisateur_id, #biere, quantite, nom_reservation, date_reservation, status, prix, points_utilises)
- **Finance** (<ins>id</ins>, biere, quantite, prix)


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
- **_Page Index_** <img width="938" alt="image" src="https://github.com/user-attachments/assets/fe425a7e-51c4-40e8-a950-b8522c27d575" />
- Hébergement du site
- **_Page de connexion_** <img width="944" alt="image" src="https://github.com/user-attachments/assets/9e09f2d0-ae4d-4b6b-8624-2e7d01e96d30" />
- **_Page d'inscription_** <img width="946" alt="image" src="https://github.com/user-attachments/assets/df479b5e-1ddd-406e-8c10-cbb75d162fb6" />
- **_Page de déconnexion logout.php_** 
- **_Page contact.php_** <img width="938" alt="image" src="https://github.com/user-attachments/assets/5a52183a-70bb-4e28-a4fe-fc5aa129a51e" />

### Sprint 2 Base de Donnée
- **_MCD de base de données_**
- **_Création de la BDD sur phpmyadmin_**
- Création des pages de chaque persona pour les connecter à la BDD
- **_Création de la page administrateur_** <img width="946" alt="image" src="https://github.com/user-attachments/assets/813a1268-a406-41f1-b7d4-408230e6223f" />
- **_Système de MDP hashé_**

### Sprint 3 Brasserie
- Faire la page brasseur
- Outils de brassage (calcul)
- Gestion du stock (Matières)
- **_Gestion du stock actuel (bières)_** <img width="941" alt="image" src="https://github.com/user-attachments/assets/8a8d6f1a-1211-4c18-ab0d-e0b11f1b15d3" />
- **_Changement du blog en pdf sur pedagogeek_**
- **_(Option) Sauvegarde de recettes (partiel)_** <img width="949" alt="image" src="https://github.com/user-attachments/assets/8d15922d-86fb-45fb-bb23-141587a6e544" />

### Sprint 4 Client & Admin
- **_Tableau de bord administrateur_** <img width="946" alt="image" src="https://github.com/user-attachments/assets/813a1268-a406-41f1-b7d4-408230e6223f" />
- **_Fonction de CRUD de la page Admin(Présent sur la capture ci-dessus_**
- **_Création de la page utilisateur_** 
- **_Système de Commande/Réservation des bières_** <img width="934" alt="image" src="https://github.com/user-attachments/assets/6b3e6cef-36cc-4ea4-b515-cb50cbbdf75f" />
- **_Système de fidélité(Présent ci dessus)_** 

### Sprint 5 Management
- Bilan Financier
- Bilan Commercial
- Passerelle de gestion

### Sprint 6 Caissier
- **_Système de caisse_** <img width="938" alt="image" src="https://github.com/user-attachments/assets/3642874b-0e2c-4126-8743-a39357659ceb" />
- **_Fidélité_**
- **_Système de réservation de produits_** <img width="92" alt="image" src="https://github.com/user-attachments/assets/d319dc06-a4b4-4853-9c17-4126fed713f0" />
- **_Système d'achats manuel_** <img width="940" alt="image" src="https://github.com/user-attachments/assets/d367827e-c418-4b7e-866b-2394a0671977" />
- **Possibilité d'ajout de compte client_** <img width="940" alt="image" src="https://github.com/user-attachments/assets/91708f4c-4a09-4748-8a39-7123e03e6b0a" />

### Sprint 7 Finition 
- **_Finition du site_**
- Consultation des logs
- **_Supervision serveur (base minimale)_**
- **_Canva de présentation_**
- **_Relier tout les fichiers à la base de données et vérifier de la compatibilité générale du site_**
- **_Bouton de retour au tableau de bord / de déconnexion de toutes les pages_** <img width="217" alt="image" src="https://github.com/user-attachments/assets/e4a627fe-f37f-4bb4-8ecf-78259f9f5a44" />

---

## Démonstration

### Vidéo de fonctionnement :

Lien youtube : [vidéo](https://youtu.be/k4V0SAnApyc)

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

Ce projet est la propriété intellectuelle d’Ethan Gomes-Carlier & Arthur Picque.
Toute réutilisation doit être sous autorisation
