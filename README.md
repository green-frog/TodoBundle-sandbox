GreenFrogTodoBundle Sandbox
===================

**Note**: This is the sandbox WITHOUT vendors

Installation
-------------

##### First, you need to Create and Configure your ``app/config/parameters.ini``

##### Install vendors (ALL vendors are in the deps file, look in ``deps.dist`` if you start by a symfony with vendors)

``` bash
php bin/vendors install --reinstall
```

##### Now install assets

``` bash
php app/console assets:install web/ --symlink``
```

``` bash
php app/console assets:dump
```

##### Generate database, entities and load fixtures

``` bash
php app/console doctrine:database:create``
```

``` bash
php app/console doctrine:schema:update --force``
```

``` bash
php app/console doctrine:fixtures:load``
```

##### This is ready !

Built-in 2 accounts

    Username : user
    Password : test
    Role : ROLE_USER

    Username : admin
    Password : test
    Role : ROLE_SUPER_ADMIN