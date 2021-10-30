# API BileMo [![Codacy Badge](https://app.codacy.com/project/badge/Grade/8d6848e3eab642b288a3854cd0cd90ac)](https://www.codacy.com/gh/leCheveuCodeur/API_BileMo/dashboard?utm_source=github.com&utm_medium=referral&utm_content=leCheveuCodeur/API_BileMo&utm_campaign=Badge_Grade) [![Maintainability](https://api.codeclimate.com/v1/badges/a6252228fd26cd57ae90/maintainability)](https://codeclimate.com/github/leCheveuCodeur/API_BileMo/maintainability)

## Description

This project is the 7th project of the [Developer PHP / Symfony](https://openclassrooms.com/fr/paths/59-developpeur-dapplication-php-symfony) formation of [Openclassrooms](https://openclassrooms.com/).

The goal of this project to make an API that respect the level 3 of Richardson model with cache management.

Concerning the authentication it's managed via JWT Token and Refresh Token

## How it work

![bilemo_doc_nelmio.png](./bilemo_doc_nelmio.png)

![bilemo_demo.gif](./bilemo_demo.gif)

## Build with

### Server :

- [PHP v7.4.19](https://www.php.net/releases/index.php)
- [Apache v2.4.48](https://www.apachelounge.com/download/VC15/)

* [MySQL v8.0.24](https://downloads.mysql.com/archives/installer/)
* **Server** : *for the server you can turn to the classics: [WAMP](https://www.wampserver.com/), [MAMP](https://www.mamp.info/en/downloads/), [XAMPP](https://www.apachefriends.org/fr/index.html) ...Or test the best of the swiss knives server: [Laragon](https://laragon.org/), my favorite ❤️*

### Framework & Libraries :

- [Symfony 5.3.9](https://symfony.com/https://)

* [Composer](https://getcomposer.org/download/)
* [FakerPHP/Faker v1.16.0](https://packagist.org/packages/fakerphp/faker)
* [liorchamla/faker-prices v2.0.0](https://packagist.org/packages/liorchamla/faker-prices)
* [Friendofsymfony/Rest-bundle v3.1.0](https://packagist.org/packages/friendsofsymfony/user-bundlehttps://getbootstrap.com/)
* [Jms/Serializer-bundle v3.15.0](https://packagist.org/packages/jms/serializer-bundle)
* [Babdev/Pagerfanta-bundle v3.3.0](https://packagist.org/packages/babdev/pagerfanta-bundle)
* [Lexik/Jwt-authentication-bundle v2.13.0](https://packagist.org/packages/lexik/jwt-authentication-bundle)
* [Gesdinet/Jwt-refresh-token-bundle v1.0.0 beta4](https://packagist.org/packages/gesdinet/jwt-refresh-token-bundle)
* [Willdurand/Hateoas-bundle v2.3.0](https://packagist.org/packages/willdurand/hateoas-bundle)
* [Nelmio/Api-doc-bundle v4.6.2](https://packagist.org/packages/nelmio/api-doc-bundle)

## Installation

### **Clone or download the repository**, and put files into your environment,

```
https://github.com/leCheveuCodeur/API_BileMo.git
```

### Install libraries with **composer**,

```
composer install
```

### Configure your environment with `.env` file :

```
# DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=8"


###> INIT CUSTOMER ###
CUSTOMER_COMPANY='your_company'
CUSTOMER_EMAIL='your_email_company@email.com'
CUSTOMER_PASSWORD='your_password'
###< INIT CUSTOMER ###

```

### Initialise your Database :

1 - create your database :

````
php bin/console d:d:c
````

2 - create the structure in your database :

```
php bin/console d:m:m
```

3 - and install fixturesfor have first contents and your Admin account :

```
php bin/console d:f:l -n
```

### Generate your SSL keys

```
php bin/console lexik:jwt:generate-keypair
```

### And Voilà !

## Access to API documentation

* Json documentation: /api/doc.json
* Html interactive documentation: /api/doc
