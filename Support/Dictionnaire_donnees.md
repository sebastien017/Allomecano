## Dictionnaire de données AlloMecano

Entité | Nom du paramètre | Type | Commentaire | Description |
-|-|-|-|-|
User | username | varchar |-|-|
User | firstname| varchar |-|-|
User | lastname | varchar |-|-|
User | firstname| varchar |-|-|
User | mail | varchar(320) |-|-|
User | role | json | Permet de définir le rôle de l'utilisateur |-|
User | prestataire_id | int | Fait le lien entre la table user et prestataire si le user à le rôle prestataire |-|

Entité | Nom du paramètre | Type | Commentaire | Description |
-|-|-|-|-|
Prestataire | adress |-|-|-|
Prestataire | phone |-|-|-|
Prestataire | mail |-|-|-|

Entité | Nom du paramètre | Type | Commentaire | Description |
-|-|-|-|-|
Prestation |-|-|-|-|

Entité | Nom du paramètre | Type | Commentaire | Description |
-|-|-|-|-|
Rate |-|-|-|-|

Entité | Nom du paramètre | Type | Commentaire | Description |
-|-|-|-|-|
RDV |-|-|-|-|