#!/bin/sh

if [ -z "$1" ]
  then
    echo "please supply a username for ssh operations as argument "
    exit 1
fi

USER="$1"

git pull origin master
git checkout master

app/console cache:clear --env prod
app/console assetic:dump --env prod

scp -r ./web/js/ "$USER@188.226.235.234":/tmp/js
scp -r ./web/css/ "$USER@188.226.235.234":/tmp/css

ssh -A "$USER@188.226.235.234" << ENDSSH
cd /var/www/dictionary
sudo su
chown -R "$1":"$1" /var/www/dictionary
chmod -R 755 /var/www

exit
echo "checking out master"
git checkout master
git fetch
git pull origin master
git reset --hard origin/master

sudo su
service php5-fpm stop
cp /tmp/js/* web/js/
cp /tmp/css/* web/css/

app/console cache:clear --env prod
app/console assets:install web

app/console doctrine:migrations:migrate  --no-interaction
chown -R www-data:www-data /var/www/dictionary

rm -Rf /tmp/js
rm -Rf /tmp/css

service php5-fpm restart
service nginx restart
