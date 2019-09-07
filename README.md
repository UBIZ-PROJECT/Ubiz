![logo](./public/images/logo.png)

## Table of contents
* [General info](#general-info)
* [Deploy Source](#deploy-source)
* [Install worker](#install-worker)

## General info
This project is TKT - ERP.

## Deploy Source
To run this project, install it locally using git, composer, php artisan:

```
$ cd /home
$ mkdir tkp_$(date +%Y%m%d_%H%M%S)
$ cd tkp_$(date +%Y%m%d_%H%M%S)
$ git clone ...
$ composer install
$ php artisan config:clear
$ php artisan route:cache
$ php artisan view:clear
```

## Install worker
To use queue function of laravel project

```
$ apt-get install supervisor -y
$ cp -r /home/tkp_$(date +%Y%m%d_%H%M%S)/worker.conf /etc/supervisor/conf.d
$ supervisorctl reread
$ supervisorctl update
$ supervisorctl start tkp-worker:*
```