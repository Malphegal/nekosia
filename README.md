# Nekosia

## Installation

[Mise à jour]\
Le fichier .htaccess en racine du projet suffit maintenant à ne plus avoir besoin d'ajouter des modifications dans httpd.conf

Pour correctement utiliser les redirections, il faut ajouter, au httpd.conf tout en bas :
```
<Directory "<cheminLaragon>/www/<NomDossier>">
	FallbackResource "/<NomDossier>/index.php"
</Directory>
```
> Note :\
> `<NomDossier>` sera remplacé par le nom du dossier dans `www/` de laragon !\
> `<cheminLaragon>` sera remplacé par le chemin d'installation de laragon !     

## Ressources

Un grand merci aux artistes pour les images du site !

 * [yuri_b](https://pixabay.com/fr/users/yuri_b-2216431/)