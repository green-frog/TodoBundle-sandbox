GreenFrogTodoBundle
===================

This is the sandbox WITHOUT vendors

1. First, you need to Configure your app/config/parameters.ini

2. Install vendors (ALL vendors are in the deps file, look in `deps.dist` if you start by a symfony with vendors)

``php bin/vendors install --reinstall``

3. Now install assets with symlink

``php app/console assets:install web/ --symlink``

3. Generate database, entities and load fixtures

``php app/console doctrine:database:create``
``php app/console doctrine:schema:update --force``
``php app/console doctrine:fixtures:load``

4. This is ready !