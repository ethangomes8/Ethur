# 🍺 Ethur Personnellement - PGCPO pour la Brasserie Terroir & Saveurs

Bienvenue sur le dépôt GitHub du projet **Ethur Personnellement**, une **Plateforme de Gestion et de Communication pour Petite Organisation (PGCPO)** développée pour la **Brasserie Terroir & Saveurs**, située dans les Hauts-de-France. Ce projet a été réalisé dans le cadre de ma première année de BTS SIO à l’EPSI Lille.

---

## 🎯 Objectif du projet

L’objectif de ce projet est double :  
- **Développer la présence en ligne de la brasserie** à travers un site vitrine professionnel et attrayant.  
- **Fournir des outils de gestion numériques** adaptés aux différents profils des membres de la brasserie (administrateur, direction, brasseur, caissier, client).

---

## 🧱 Structure du dépôt



---

## 🗃️ Structure de la base de données

La base de données est organisée autour des entités suivantes :
- **Utilisateurs** (admin, brasseurs, direction, caissiers, clients)
- **Produits** (bières, spiritueux)
- **Stocks matières premières** & **produits finis**
- **Recettes**
- **Ventes / Achats**
- **Réservations**
- **Logs systèmes**
- **Points de fidélité**

💡 *La BDD est pensée pour être **évolutive et modulaire**, permettant l'ajout futur de fonctionnalités ou profils utilisateurs.*

---

## 🧩 Structure technique du programme

L'application est divisée en plusieurs modules :

| Module                    | Description |
|--------------------------|-------------|
| `Site vitrine`           | Interface publique avec présentation de la brasserie, ses produits, etc. |
| `Espace utilisateur`     | Connexion, affichage d’un message personnalisé selon le profil |
| `Back-office`            | Interfaces spécifiques pour chaque rôle |
| `API & traitement`       | Gestion des requêtes SQL, logique métier |
| `Système de logs`        | Journalisation des connexions et actions importantes |

---

## 🔐 Fonctionnalités

Voici l’ensemble des fonctionnalités proposées par l’application.  
Les fonctionnalités **réalisées par mes soins** sont **_en gras et en orange_** :

### 🌐 Site vitrine
- **_Affichage dynamique des produits (popup/page)_**
- **_Menu de navigation_**
- **_Design en teintes cuivrées avec logo intégré_**

### 👥 Gestion des utilisateurs
- **_Connexion/Déconnexion_**
- **_Création, modification, suppression des comptes par l’admin_**
- Affichage d’un message de bienvenue selon le rôle connecté

### ⚙️ Profil Brasseur
- **_Calculs automatiques pour la préparation de la bière (formulaire)_**
- **_CRUD stock matières premières_**
- **_CRUD stock produits finis_**
- **_(Option) Sauvegarde de recettes (partiel)_**

### 📊 Profil Direction
- **_Consultation et saisie du bilan financier mensuel_**
- **_Consultation du bilan commercial_**

### 💰 Profil Caissier
- **_Système de caisse avec sélection de produits_**
- **_Création de compte client à la volée_**
- **_Gestion des remises et fidélité_**

### 🧾 Profil Client
- **_Affichage des points de fidélité_**
- **_Historique des achats_**
- **_Système de réservation de produits_**

### 🔧 Profil Administrateur
- **_Gestion des comptes utilisateurs_**
- **_Consultation des logs_**
- **_Supervision serveur (base minimale)_**

---

## 💡 Démonstration

### 🎥 Vidéo de fonctionnement :
📌 *À venir* : Une démonstration vidéo du fonctionnement global et des modules développés.

---

## 🔗 Hébergement et services

Les services installés et configurés :
- **Serveur web** : Apache
- **FTP** : VSFTP sécurisé
- **SSH** : Clés RSA et sécurisation par fail2ban
- **Nom de domaine** : Fourni via FreeDNS (ou équivalent)
- **Base de données** : MySQL / MariaDB

---

## 📚 Sources et ressources

- Frameworks : Bootstrap, FontAwesome  
- Outils : DokuWiki (gestion projet), phpMyAdmin  
- Images et icônes : [Unsplash](https://unsplash.com), [Flaticon](https://www.flaticon.com)  
- Documents pédagogiques : www.pedagogeek.fr  
- Schémas de calculs : Annexe projet

---

## 👤 Auteur

👨‍💻 Réalisé par **Ethan Gomes-Carlier**  
Étudiant en BTS SIO 1ère année à l’EPSI Lille  
Projet réalisé individuellement dans le cadre de l’atelier professionnel 2025  
📫 [LinkedIn](https://www.linkedin.com) • [GitHub](https://github.com)

---

## 📝 Licence

Ce projet est sous licence MIT — Voir le fichier `LICENSE` pour plus d’informations.
