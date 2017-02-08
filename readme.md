# Mettre en place l'environnement de dev
Deux options pour la base:
## Au CREMI
*NON TESTE*  
Un espace de dev web est disponible, vous pouvez utiliser l'espace `~/espaces/www/`  
le site est accessible depuis `http://\<PRENOM>.\<NOM>.emi.u-bordeaux.fr/`  
Créez des sous dossiers pour vous y retrouver

## Chez soi
Les devs de Laravel fournissent une base de VM ubuntu déjà configurée (pas mal pour dev sous windows), suivre les instructions [ici](https://laravel.com/docs/5.4/homestead) pour la mettre en place (modifiez les maps de dossiers et sites si besoin). Je conseil d'utiliser virtualbox en provider de vagrant.  

### Pour Archlinux
Il faut aussi installer `net-tools` pour que la partie network de virtualbox fonctionne, et utiliser `virtualbox-host-dkms` comme provider des drivers virtualbox (necessite `linux-headers`)

Je conseil vraiment de se servir de la VM, c'est assez rapide à installer (si vous galérez c'est que vous avez sauté une étape, comme moi :rip:)  
N'oubliez pas de mapper correctement les redirections de dossiers et les sites, et d'ajouter `192.168.10.10  homestead.app` dans votre fichier host

# Mettre en place le projet 

Y'a plus qu'à cloner le dépot

## homestead
Clonez le dépot dans la racine du dossier mappé vers la VM, par example j'ai mon dossier Homestead sur le host, qui contient le dépot. Ce dossier est mappé vers /home/vagrant/Code sur le guest, et le site web est mappé vers /home/vagrant/Code/public dans le guest

# Lumen PHP Framework

[![Build Status](https://travis-ci.org/laravel/lumen-framework.svg)](https://travis-ci.org/laravel/lumen-framework)
[![Total Downloads](https://poser.pugx.org/laravel/lumen-framework/d/total.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/lumen-framework/v/stable.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Unstable Version](https://poser.pugx.org/laravel/lumen-framework/v/unstable.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![License](https://poser.pugx.org/laravel/lumen-framework/license.svg)](https://packagist.org/packages/laravel/lumen-framework)

Laravel Lumen is a stunningly fast PHP micro-framework for building web applications with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Lumen attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as routing, database abstraction, queueing, and caching.

## Official Documentation

Documentation for the framework can be found on the [Lumen website](http://lumen.laravel.com/docs).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell at taylor@laravel.com. All security vulnerabilities will be promptly addressed.

## License

The Lumen framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
