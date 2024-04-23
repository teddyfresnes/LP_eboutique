# LP_eboutique
Création d'une boutique en ligne de voyages avec Symfony : [http://teddy.alwaysdata.net/](http://teddy.alwaysdata.net/)

## Cahier des charges
- L'utilisateur final pourra naviguer entre catégories de produits et choisir un produit pour le mettre dans son panier (on choisira de placer plutôt le panier en variable de session, mais la solution qu'il soit dans la base est aussi possible).
- Lors de la mise en panier du produit ou lors de la commande finale, il pourra ajuster le nombre d'exemplaires du(des) produit(s) choisi(s).
- A la visualisation de la commande, le montant de chaque ligne sera affiché, ainsi que le montant total et le prix du transport.
- Pour payer, l'acheteur devra se connecter, s'il se connecte pour la première fois, il devra s'enregistrer en fournissant son nom,  son e-mail un password et une adresse de livraison.
- Lorsque l'utilisateur se connecte à la boutique, ses paramètres de connexion le suivront en variable de session.
- On ne demande pas le traitement du paiement (pas de tunnel d'achat).
- Le back-office de la boutique permettra de gérer le catalogue
- L'utilisateur aura accès à son profil pour le mettre à jour.

## Compte rendu
- OK Login (connexion)
- OK Inscription
- OK Parcours par catégorie
- OK Parcours des articles
- OK Mise au panier
- OK Ajustement des quantités au panier avec le prix total
- OK Message de commande faite
- OK Ajout d'un nouveau type d'article proposé (la gestion du stock n'est pas demandée)
- OK Ajout d'une nouvelle catégorie
- OK A part l'inscription, la gestion des utilisateurs n'est pas demandée (bonus possible en cas)


## Réalisation du projet
### 1. Fonctionnalités Utilisateur
- L'utilisateur peut naviguer entre les différentes catégories de produits.
- Il peut choisir un produit pour le mettre dans son panier.
- Il peut choisir d'afficher + de détails sur un produit (popup div description).
- Il peut ajuster le nombre d'exemplaires dans son panier.
- Affichage du montant de chaque ligne, du montant total, et du prix du transport.
- Le panier est géré dans la session utilisateur.
- L'utilisateur peut ajuster les quantités dans le panier avec le prix total.
- Redirection vers les détails de la commande après l'achat, et réinitialisation du panier.
- L'utilisateur doit s'inscrire avec un nom, un e-mail, un mot de passe, et une adresse de livraison.
- Lors de la connexion à la boutique, les paramètres de connexion sont stockés en session.
- L'utilisateur peut accéder à son profil pour le mettre à jour.
### 2. Fonctionnalités Admin (Back-Office)
- L'administrateur peut se connecter avec le compte `admin@admin.admin:admin`.
- L'administrateur peut ajouter de nouvelles offres (titre, prix, description, image, choix parmi les catégories disponibles) et supprimer des offres.
- L'administrateur peut ajouter et supprimer des catégories.
- L'administrateur peut gérer les utilisateurs (supprimer des comptes).
### 3. Design et Accessibilité
- Le site a été conçu pour être **ergonomique** et **responsive**, ce qui signifie qu'il s'adapte aux différents types d'appareils (ordinateur, tablette, téléphone portable).
### 4. Accès au Site
- Le site est disponible à l'adresse suivante : [http://teddy.alwaysdata.net/](http://teddy.alwaysdata.net/)

## Screenshots
![image](https://github.com/teddyfresnes/LP_eboutique/assets/80900011/d137c362-8d8c-4450-92d9-6a393afb0f22)  
![image](https://github.com/teddyfresnes/LP_eboutique/assets/80900011/24452691-76f5-41d5-86e2-3a1584ded938)  
![image](https://github.com/teddyfresnes/LP_eboutique/assets/80900011/cfb641de-e1e0-452d-9d7c-58180940da0f)  
![image](https://github.com/teddyfresnes/LP_eboutique/assets/80900011/9711bb24-5011-48ab-ad0c-e9aab8a27511)  
![image](https://github.com/teddyfresnes/LP_eboutique/assets/80900011/13547ac4-5726-4aa9-beda-e196384784e2)  
![image](https://github.com/teddyfresnes/LP_eboutique/assets/80900011/237d7b6f-2333-4074-97b3-8953e0d5bb6d)  
![image](https://github.com/teddyfresnes/LP_eboutique/assets/80900011/8ce1bcaa-eadd-4db2-84d8-f0209ab6f2dc)  
![image](https://github.com/teddyfresnes/LP_eboutique/assets/80900011/b754290b-57df-4cd8-820e-25d8bc2bbe7c)  
![image](https://github.com/teddyfresnes/LP_eboutique/assets/80900011/4c555184-6086-48f4-b2ae-ee4909e418bd)  
![image](https://github.com/teddyfresnes/LP_eboutique/assets/80900011/82682904-8da5-4e71-a9a9-005f8c32b60b)  
![image](https://github.com/teddyfresnes/LP_eboutique/assets/80900011/dcaccb99-b9c7-4458-af6d-f73e710ca28c)  









