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
User | mail | varchar(320) |-|-|
User | role | json | Permet de définir le rôle de l'utilisateur |-|
User | garage_id | int | Fait le lien entre la table user et prestataire si le user à le rôle prestataire |-|

## Garage
Entité | Nom du paramètre | Type | Commentaire | Description |
-|-|-|-|-|
Garage | name |-|-|-|
Garage | adress |-|-|-|
Garage | phone |-|-|-|
Garage | mail |-|-|-|
Garage | mobility | boolean |-|-|
Garage | distance | int |-|-|

## Prestation
Entité | Nom du paramètre | Type | Commentaire | Description |
-|-|-|-|-|
Service | name |-|-|-|
Service | duration |-|-|-|
Service | price |-|-|-|

Il y aura une table intermédiaire garage_service pour lister les prestations proposées pour chaque garage.


## Image
Entité | Nom du paramètre | Type | Commentaire | Description |
-|-|-|-|-|
Image | url | varchar |-|-|
Image | garage_id | int |-|-|

## Commentaires et notes
Entité | Nom du paramètre | Type | Commentaire | Description |
-|-|-|-|-|
Comment | content |-|-|-|
Comment | rate | int |-|-|
Comment | garage_id |-|-|-|
Comment | user_id |-|-|-|

## Agenda
Entité | Nom du paramètre | Type | Commentaire | Description |
-|-|-|-|-|
Agenda | title |-|-|-|
Agenda |start_date |-|-|-|
Agenda |start_time |-|-|-|
Agenda | end_date |-|-|-|
Agenda | end_time |-|-|-|
Agenda | garage_id |-|-|-|
Agenda | user_id |-|-|-|