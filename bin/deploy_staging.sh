#!/bin/sh

if [ -z "$1" ]
  then
    echo "please supply a username for ssh operations as argument "
    exit 1
fi

USER="$1"
BRANCH="$2"

git pull origin $BRANCH
git checkout $BRANCH

app/console cache:clear --env prod
app/console assetic:dump --env prod

scp -r ./web/js/ "$USER@188.226.235.234":/tmp/js
scp -r ./web/css/ "$USER@188.226.235.234":/tmp/css

ssh -A "$USER@188.226.235.234" << ENDSSH
cd /var/www/staging.dictionary
sudo su
chown -R "$1":"$1" /var/www/staging.dictionary
chmod -R 755 /var/www

exit
echo "checking out $BRANCH"
git checkout $BRANCH
git fetch
git pull origin $BRANCH
git reset --hard origin/$BRANCH

sudo su
tar -zxvf vendors.tar.gz
service php5-fpm stop

cp /tmp/js/* web/js/
cp /tmp/css/* web/css/

app/console cache:clear --env prod
app/console assets:install web

app/console doctrine:migrations:migrate  --no-interaction
chown -R www-data:www-data /var/www/staging.dictionary

rm -Rf /tmp/js
rm -Rf /tmp/css

service php5-fpm restart
service nginx restart
