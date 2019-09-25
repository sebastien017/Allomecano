## Dictionnaire de données AlloMecano

## User
Entité | Nom du paramètre | Type | Commentaire | Description |
-|-|-|-|-|
User | username | varchar(50) |-|-|
User | firstname | varchar(100) |-|-|
User | lastname | varchar(100) |-|-|
User | phone | int(10) |-|-|
User | adress | varchar(255) |-|-|
User | city | varchar(100) |-|-|
User | postal_code | int (5) |-|-|
User | avatar | text(65000) |-|-|
User | email | varchar(320) |-|-|
User | role | json | Permet de définir le rôle de l'utilisateur |-|
User | created_at | datetime |-|-|
User | updated_at | datetime |-|-|
User | garage_id | int | Fait le lien entre la table user et prestataire si le user à le rôle prestataire |-|

## Garage
Entité | Nom du paramètre | Type | Commentaire | Description |
-|-|-|-|-|
Garage | name | varchar(100) |-|-|
Garage | adress | varchar(255) |-|-|
Garage | city | varchar(100) |-|-|
Garage | postal_code | int (5) |-|-|
Garage | phone | int(10) |-|-|
Garage | email | varchar(320) |-|-|
Garage | created_at | datetime |-|-|
Garage | updated_at | datetime |-|-|
Garage | mobility | boolean |-|-|
Garage | distance | int(100) |-|-|

## Prestation
Entité | Nom du paramètre | Type | Commentaire | Description |
-|-|-|-|-|
Service | name |varchar(100)|-|-|
Service | price |int|-|-|
Service | image | text(65000) |-|-|
Service | created_at | datetime |-|-|
Service | updated_at | datetime |-|-|

Il y aura une table intermédiaire garage_service pour lister les prestations proposées pour chaque garage.


## Image
Entité | Nom du paramètre | Type | Commentaire | Description |
-|-|-|-|-|
Image | url | text(65000) |-|-|
Image | garage_id | int |-|-|
Image | created_at | datetime |-|-|
Image | updated_at | datetime |-|-|

## Commentaires et notes
Entité | Nom du paramètre | Type | Commentaire | Description |
-|-|-|-|-|
Comment | content | text(500) |-|-|
Comment | rate | int(6) |-|-|
Comment | garage_id | int |-|-|
Comment | user_id | int |-|-|
Comment | created_at | datetime |-|-|
Comment | enable | boolean |-|-|

## Agenda
Entité | Nom du paramètre | Type | Commentaire | Description |
-|-|-|-|-|
Agenda | date | date |-|-|
Agenda | time | time |-|-|
Agenda | garage_id |int|-|-|
Agenda | user_id |int|-|-|
Agenda | reservation_date | datetime |-|-|
Agenda | created_at | datetime |-|-|
Agenda | updated_at | datetime |-|-|