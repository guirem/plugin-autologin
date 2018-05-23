Plugin Autologin (autologin)
=============================

![Logo plugin](../images/logoplugin.png "Logo plugin")

Plugin pour se connecter automatiquement à Jeedom avec un utilisateur choisi restreint à une IP.

**Cas d'utilisation :**
- Ecran déporté (tablette)
- Difffusion Jeedom sur GoogleCast (voir plugin googlecast)

**Fonctionnement :**

Une page spécifique devra être appelé et gérera l'authentification automatique et redirection sur l'URL Jeedom selectionnée.

Dashboard
=======================

Pas de panneau disponible sur le dashbaoard

Configuration du plugin
=======================

Activer seulement le plugin.

Configuration des équipements
=============================

La configuration des sessions Autologin est accessible à partir du menu *Plugins > Programmation > Autologin*.

![Configuration](../images/configuration.png "Configuration")

Listes des paramêtres :

- IP autorisées : L'IP à partir duquel l'équipement devra se connecter
- Utilisatuer : Choisir un utilisateur non admin (il est nécessaire d'avoir créer un utilisateur non admin au préalable)
- Redirect URL : La page Jeedom de redirection une fois l'autologin effectué


URL à appeler : Le lien à appeler qui gérera l'authentification et redirigera sur la page Jeedom choisie après 2 secondes.

![Screenshot](../images/loginscreenshot.png "Screenshot")


> **Example**
>
> Utiliser le lien fournit par le plugin dans le navigateur :
``https://myjeedom/plugins/autologin/core/php/go.php?apikey=mypluginapikey&id=187``
>
> Après 2 secondes, la page Jeedom selectionnée va se charger.

FAQ
=============================


Changelog
=============================

[Voir la page dédiée](changelog.md).
