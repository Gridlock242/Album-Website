# Album Notation App

Bienvenue sur mon projet Symfony !  
C’est une petite application web qui permet de **noter des albums de musique**, les **classer par genre/date de sortie**, **ajouter des favoris**, et gérer tout ça via une interface **admin**.  
Il y a aussi un système d'**abonnements entre utilisateurs**.

---

⭐ **Fonctions principales**

- Inscription et connexion
- Rôles (ROLE_USER ou ROLE_ADMIN)
- Un profil utilisateur
- Une interface administrateur
- Une barre de recherche (albums / artistes / genre)
- Les admins peuvent ajouter, éditer et supprimer des albums

---

⭐ **Sécurité**

- Accès restreint aux pages selon les rôles
- Authentification avec `make:auth`
- Protection CSRF et validation des formulaires

---

⭐ **Problèmes rencontrés**

- Quelques confusions sur les relations entre les entités au début
- Beaucoup de soucis d'authentification au départ, réglés ensuite avec le session auto-start mis à 0
- Problème pour afficher le genre dans la page admin/album, supprimé pour le moment
- Même problème dans le formulaire d’update : je voulais afficher les genres en preview mais ça ne fonctionne pas
- J’ai voulu faire un système d’édition directement sur la page admin/album (sans rediriger vers `/edit/{id}`), mais le rendu était trop brouillon, donc j’ai finalement opté pour une page dédiée

---

⭐ **Améliorations prévues**

- Corriger la recherche par année (pas encore fonctionnelle)
- Ajouter une photo de profil utilisateur (remplacer l’adresse mail)
- Pouvoir choisir et se connecter avec un pseudo
- Corriger le système de notation qui n'est pas du tout fonctionnel et n'a qu'une partie front
- Ajouter une pagination avec : composer require knplabs/knp-paginator-bundle
