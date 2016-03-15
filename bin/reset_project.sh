#!/bin/sh

# this will reset your project and generate proxies and everything
# run from root directory with ./bin/reset_project.sh

# additionally, when new vendors have been added or moved around, you will have to run
# ./bin/install_vendors.sh -d

sudo rm -Rf ./app/cache/*

sudo ./composer.phar install

#./bin/setup_permissions.sh

app/console doctrine:database:drop --force
app/console doctrine:database:create

app/console doctrine:migration:migrate -n
app/console doctrine:fixtures:load --fixtures=app/DataFixtures/ORM

app/console assets:install --symlink web