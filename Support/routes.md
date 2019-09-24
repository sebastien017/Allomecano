# Routes

| URL | Méthode HTTP | Controller | Méthode | Titre | Contenu | Commentaire |
|--|--|--|--|--|--|--|
| `/` | `GET` | `MainController` | `home` | AlloMecano | Page d'accueil avec recherche | - |
| `/profile`| `GET` | `UserController` | `profile` | Mon profil | Informations du profil |--|
| `/profile/edit`| `GET & POST` | `UserController` | `editProfile` | Edition du profil | Mise à jour du profil |--|
| `/signup` | `GET & POST`|`UserController`| `signup`| Inscription |--|--|
| `/signin` | `GET & POST` |`UserController`| `signin`| Connexion |--|--|
| `/planing` | `GET & POST` |`PlaningController`| `editPlaning`| Mon planing| Débloquer certains créneaux horaires | Accessibles aux pro uniquement |
| `/admin` | `GET & POST` |--|--|--|--| Géré par EasyAdminBundle|
| `/services` | `GET` | `ServiceController` | `showServices`| Prestations | Choix de la prestation |--|
| `/services/{service}` | `GET` | `ServiceController` | `showGarageByService` | Les professionnels | Choix du professionnel |--|
| `/garage/{garage}` |`GET` | `GarageController` | `showSingleGarage` | {NomDuGarage} | Affichage des infos du professionnel pour les particuliers |--|
| `/reservation`| `GET & POST` | `PlaningController`| `showPlaningByGarage` | Réservation de mon rdv| Choix de la date |--|
| `/reservation/confirm`| `GET & POST` | `PlaningController` | `validatePlaning` | Confirmation de mon rdv | Validation de la prise de rdv |--|
| `/reservation/success`| `GET & POST` | `PlaningController` | `reservationSuccess`| Récapitulatif de mon rdv | Récapitulatif et confirmation de la prise de rdv |--|
| `/contact` | `GET & POST` | `MainController` | `showContactForm` | Contact | Formulaire de contact |--|
| `/mentions-legales`| `GET` | `MainController` | `showLegalMentions` | Mentions légales | Mentions légales |--|
| `/a-propos` | `GET` | `MainController` | `aboutUs`| A propos de nous | Affichage des informations des dev |--|
| `/faq` | `GET` | `MainController`| `showFaq` | FAQ |--|--|
|--|--|--|--|--|--|--|
