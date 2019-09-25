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
Garage | adress | varchar(255) Null |-|-|
Garage | city | varchar(100) Null |-|-|
Garage | postal_code | int (5) Null|-|-|
Garage | phone | int(10) Null |-|-|
Garage | email | varchar(320) Null |-|-|
Garage | created_at | datetime |-|-|
Garage | updated_at | datetime Null |-|-|
Garage | mobility | boolean Null |-|-|
Garage | distance | int(100) Null |-|-|

## Prestation
Entité | Nom du paramètre | Type | Commentaire | Description |
-|-|-|-|-|
Service | name |varchar(100)|-|-|
Service | price |int|-|-|
Service | image | text(65000) Null |-|-|
Service | created_at | datetime |-|-|
Service | updated_at | datetime Null |-|-|

Il y aura une table intermédiaire garage_service pour lister les prestations proposées pour chaque garage.


## Image
Entité | Nom du paramètre | Type | Commentaire | Description |
-|-|-|-|-|
Image | url | text(65000) |-|-|
Image | garage_id | int |-|-|
Image | created_at | datetime |-|-|
Image | updated_at | datetime Null |-|-|

## Commentaires et notes
Entité | Nom du paramètre | Type | Commentaire | Description |
-|-|-|-|-|
Comment | content | text(500) Null |-|-|
Comment | rate | int(6) |-|-|
Comment | garage_id | int |-|-|
Comment | user_id | int |-|-|
Comment | created_at | datetime |-|-|
Comment | enable | boolean |-|-|

## Visit
Entité | Nom du paramètre | Type | Commentaire | Description |
-|-|-|-|-|
Visit | date | date |-|-|
Visit | time | time |-|-|
Visit | garage_id |int|-|-|
Visit | user_id |int|-|-|
Visit | reservation_date | datetime |-|-|
Visit | created_at | datetime |-|-|
Visit | updated_at Null | datetime |-|-| 