Plugin AutoLogin (autologin)
=============================

![Logo plugin](../images/logoplugin.png "Logo plugin")

Plugin pour se connecter automatiquement à Jeedom avec un utilisateur choisi restreint à une IP.

**Cas d'utilisation :**
- Ecrans déportés (tablettes)
- Difffusion Jeedom sur GoogleCast (voir plugin googlecast)

**Fonctionnement :**

Une page spécifique devra être appelé par le navigateur et gérera l'authentification automatique puis redirigera sur l'URL Jeedom.

> **Note**    
> L'utilisateur du plugin prend la responsabilité de fournir un accès à Jeedom de manière simplifié (sans mot de passe)


Dashboard
=======================

Pas de panneau disponible sur le dashboard

Configuration du plugin
=======================

Activer seulement le plugin.


Configuration des équipements
=============================

La configuration des sessions Autologin est accessible à partir du menu *Plugins > Programmation > AutoLogin*.

![Configuration](../images/configuration.png "Configuration")

Liste des paramêtres :

- IP autorisée : L'IP à partir duquel l'équipement devra se connecter
- Utilisateur : Choisir un utilisateur non admin (il est nécessaire d'avoir créé un utilisateur non admin au préalable)
- URL Jeedom : La page Jeedom de redirection une fois l'autologin effectué


URL à appeler : Le lien à appeler qui gérera l'authentification et redirigera sur la page Jeedom choisie après 2 secondes.

![Screenshot](../images/loginscreenshot.png "Screenshot")


> **Example**
>
> Utiliser le lien fournit par le plugin dans le navigateur de l'équipement ayant la même IP que celle renseignée :
``https://myjeedom/plugins/autologin/core/php/go.php?apikey=mypluginapikey&id=187``
>
> Après 2 secondes, le lien de la page Jeedom renseignée va se charger.

FAQ
=============================


Changelog
=============================

[Voir la page dédiée](changelog.md).
