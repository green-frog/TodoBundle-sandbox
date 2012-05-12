GreenFrogTodoBundle
===================

This is the sandbox WITHOUT vendors

. First, you need to Configure your app/config/parameters.ini

. Install vendors (ALL vendors are in the deps file, look in `deps.dist` if you start by a symfony with vendors)

``php bin/vendors install --reinstall``

. Now install assets with symlink

``php app/console assets:install web/ --symlink``

. Generate database, entities and load fixtures

``php app/console doctrine:database:create``

``php app/console doctrine:schema:update --force``

``php app/console doctrine:fixtures:load``

. This is ready !