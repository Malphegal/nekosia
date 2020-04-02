# Nekosia

## Installation

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

Un grand merci aux artistes pour les images (probablement temporaire) du site !

 * [Lap Pun Cheung](https://www.artstation.com/c780162)