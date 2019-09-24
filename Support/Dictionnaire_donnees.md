## Dictionnaire de données AlloMecano

## User
Entité | Nom du paramètre | Type | Commentaire | Description |
-|-|-|-|-|
User | username | varchar |-|-|
User | firstname | varchar |-|-|
User | lastname | varchar |-|-|
User | phone |-|-|-|
User | adress | varchar |-|-|
User | avatar |-|-|-|
User | email | varchar(320) |-|-|
User | role | json | Permet de définir le rôle de l'utilisateur |-|
User | created_at | datetime |-|-|
User | updated_at | datetime |-|-|
User | garage_id | int | Fait le lien entre la table user et prestataire si le user à le rôle prestataire |-|

## Garage
Entité | Nom du paramètre | Type | Commentaire | Description |
-|-|-|-|-|
Garage | name |-|-|-|
Garage | adress |-|-|-|
Garage | phone |-|-|-|
Garage | email |-|-|-|
Garage | created_at | datetime |-|-|
Garage | updated_at | datetime |-|-|
Garage | mobility | boolean |-|-|
Garage | distance | int |-|-|

## Prestation
Entité | Nom du paramètre | Type | Commentaire | Description |
-|-|-|-|-|
Service | name |-|-|-|
Service | price |-|-|-|
Service | image | varchar |-|-|
Service | created_at | datetime |-|-|
Service | updated_at | datetime |-|-|

Il y aura une table intermédiaire garage_service pour lister les prestations proposées pour chaque garage.


## Image
Entité | Nom du paramètre | Type | Commentaire | Description |
-|-|-|-|-|
Image | url | varchar |-|-|
Image | garage_id | int |-|-|
Image | created_at | datetime |-|-|
Image | updated_at | datetime |-|-|

## Commentaires et notes
Entité | Nom du paramètre | Type | Commentaire | Description |
-|-|-|-|-|
Comment | content |-|-|-|
Comment | rate | int |-|-|
Comment | garage_id |-|-|-|
Comment | user_id |-|-|-|
Comment | created_at | datetime |-|-|
Comment | enable | boolean |-|-|

## Agenda
Entité | Nom du paramètre | Type | Commentaire | Description |
-|-|-|-|-|
Agenda | date |-|-|-|
Agenda | time |-|-|-|
Agenda | garage_id |-|-|-|
Agenda | user_id |-|-|-|
Agenda | reservation_date | datetime |-|-|
Agenda | created_at | datetime |-|-|
Agenda | updated_at | datetime |-|-|